<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\CustomField;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Fleet\FleetAdapter;
use App\SyncAdapters\MappingTargets;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExtraFieldMappingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_extra_field_mapping_writes_scalar_value_to_custom_field()
    {
        $customField = CustomField::factory()->create(['element' => 'text']);
        $fleet = $this->configuredFleetInstance();

        // Map fleet_team (scalar string) to the custom field.
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'custom:'.$customField->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(id: 1, hostname: 'wksn-01', hardware_model: 'MacBook Pro', team_name: 'Engineering'),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseHas('assets', [
            'name' => 'wksn-01',
            $customField->db_column => 'Engineering',
        ]);
    }

    public function test_extra_field_mapping_stringifies_array_to_comma_joined()
    {
        $customField = CustomField::factory()->create(['element' => 'text']);
        $fleet = $this->configuredFleetInstance();

        // Map fleet_labels (an array from the vendor) to the custom field.
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_labels', 'custom:'.$customField->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(
                        id: 2,
                        hostname: 'wksn-02',
                        hardware_model: 'MacBook Pro',
                        labels: ['production', 'us-east', 'engineering'],
                    ),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseHas('assets', [
            'name' => 'wksn-02',
            $customField->db_column => 'production, us-east, engineering',
        ]);
    }

    public function test_skipped_extra_fields_do_not_touch_the_asset()
    {
        $customField = CustomField::factory()->create(['element' => 'text']);
        $fleet = $this->configuredFleetInstance();

        // No mapping stored: default is skip for extras.
        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(id: 3, hostname: 'wksn-03', hardware_model: 'MacBook Pro', team_name: 'Engineering'),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        // Asset created, but the custom-field column stays null since
        // no mapping was stored.
        $this->assertDatabaseHas('assets', [
            'name' => 'wksn-03',
            $customField->db_column => null,
        ]);
    }

    public function test_extra_field_options_include_native_and_custom_targets_for_text_type()
    {
        CustomField::factory()->create(['element' => 'text', 'name' => 'Team Assignment']);

        $options = MappingTargets::optionsForExtra('text');

        // No 'skip' target: the mapping-picker widget models
        // "unmapped" as the extra sitting in the picker's
        // available list, not as a committed row with target='skip'.
        $this->assertArrayNotHasKey('skip', $options);

        // Text-type extras can route to native asset_tag / model /
        // notes so admins whose vendor stores per-device metadata in
        // labels / blueprints / teams / marketing names can land it
        // in a native column instead of forcing a custom field.
        // Everything else must be custom:{id}.
        $this->assertArrayHasKey('native:asset_tag', $options);
        $this->assertArrayHasKey('native:model', $options);
        $this->assertArrayHasKey('native:notes', $options);
        $this->assertArrayHasKey('native:purchase_date', $options);
        $this->assertArrayHasKey('native:order_number', $options);
        $nativeTargets = ['native:asset_tag', 'native:model', 'native:notes', 'native:purchase_date', 'native:order_number'];
        foreach (array_keys($options) as $target) {
            if (in_array($target, $nativeTargets, true)) {
                continue;
            }
            $this->assertStringStartsWith('custom:', $target);
        }
    }

    public function test_boolean_extra_field_options_stay_custom_only()
    {
        CustomField::factory()->create(['element' => 'checkbox', 'name' => 'Flagged']);

        $options = MappingTargets::optionsForExtra('boolean');

        // Boolean-typed extras stay custom-fields-only because no
        // native asset column carries a boolean semantic. Also no
        // 'skip' entry: unmap via ×, not via a stored 'skip' target.
        $this->assertArrayNotHasKey('skip', $options);
        $this->assertArrayNotHasKey('native:asset_tag', $options);
        $this->assertArrayNotHasKey('native:model', $options);
        $this->assertArrayNotHasKey('native:notes', $options);
    }

    public function test_extra_can_route_to_native_purchase_date()
    {
        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'native:purchase_date');

        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'purchase-1',
            hostname: 'host-1',
            hardwareSerial: 'SN-1',
            hardwareModel: 'MacBook Pro',
            extra: ['fleet_team' => '2024-03-15'],
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', [
            'name' => 'host-1',
            'purchase_date' => '2024-03-15',
        ]);
    }

    public function test_purchase_date_accepts_iso_8601_datetime()
    {
        // ABM emits orderDateTime as ISO 8601 with a time component.
        // The write path normalizes to YYYY-MM-DD so it fits Snipe-IT's
        // date column.
        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'native:purchase_date');

        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'purchase-2',
            hostname: 'host-2',
            hardwareSerial: 'SN-2',
            hardwareModel: 'MacBook Pro',
            extra: ['fleet_team' => '2024-03-15T00:00:00Z'],
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', [
            'name' => 'host-2',
            'purchase_date' => '2024-03-15',
        ]);
    }

    public function test_unparseable_purchase_date_is_skipped_not_crashed()
    {
        // Fail-safe: bad vendor data on one field should not abort the
        // whole sync. Asset still gets created, purchase_date stays
        // null, the sync run continues.
        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'native:purchase_date');

        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'bad-date',
            hostname: 'host-3',
            hardwareSerial: 'SN-3',
            hardwareModel: 'MacBook Pro',
            extra: ['fleet_team' => 'not-a-date'],
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', ['name' => 'host-3']);
        $this->assertDatabaseMissing('assets', ['name' => 'host-3', 'purchase_date' => 'not-a-date']);
    }

    public function test_extra_can_route_to_native_order_number()
    {
        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'native:order_number');

        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'order-1',
            hostname: 'host-4',
            hardwareSerial: 'SN-4',
            hardwareModel: 'MacBook Pro',
            extra: ['fleet_team' => 'PO-12345'],
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', [
            'name' => 'host-4',
            'order_number' => 'PO-12345',
        ]);
    }

    public function test_asset_tag_native_target_overwrites_the_asset_tag_column()
    {
        $fleet = $this->configuredFleetInstance();

        // Standard-field mapping: route the normalized asset_tag field
        // to Snipe-IT's native asset_tag column. Fleet doesn't emit
        // asset_tag in its normalize() so we simulate a source that
        // does by using the extra->normalized path elsewhere. Here we
        // exercise the mapping wiring itself.
        SyncAdapterConfig::put($fleet->id, 'mapping.asset_tag', 'native:asset_tag');

        // Build a record with an explicit assetTag so writeNative
        // picks it up.
        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'tag-test-1',
            hostname: 'host-with-tag',
            hardwareSerial: 'SN-1',
            hardwareModel: 'MacBook Pro',
            assetTag: 'VENDOR-TAG-001',
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', [
            'name' => 'host-with-tag',
            'asset_tag' => 'VENDOR-TAG-001',
        ]);
    }

    public function test_asset_tag_defaults_to_native_and_writes_vendor_tag()
    {
        $this->configuredFleetInstance();

        // No explicit mapping stored: default target for asset_tag is
        // native:asset_tag so the vendor's tag flows into Snipe-IT's
        // asset_tag column. Common case is admins want the printed
        // sticker in Kandji / Jamf to match the Snipe-IT tag.
        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'tag-test-2',
            hostname: 'host-default-mapping',
            hardwareSerial: 'SN-2',
            hardwareModel: 'MacBook Pro',
            assetTag: 'VENDOR-TAG-002',
        );

        SyncAdapter::syncFromRecord($record);

        $this->assertDatabaseHas('assets', [
            'name' => 'host-default-mapping',
            'asset_tag' => 'VENDOR-TAG-002',
        ]);
    }

    public function test_asset_tag_skip_target_preserves_curated_snipe_it_tag()
    {
        $fleet = $this->configuredFleetInstance();

        // Admins who want to protect curated tags flip the mapping
        // to skip. Vendor tag ignored on both create and update.
        SyncAdapterConfig::put($fleet->id, 'mapping.asset_tag', 'skip');

        $record = new \App\SyncAdapters\HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'tag-test-3',
            hostname: 'host-skipped-mapping',
            hardwareSerial: 'SN-3',
            hardwareModel: 'MacBook Pro',
            assetTag: 'VENDOR-TAG-003',
        );

        SyncAdapter::syncFromRecord($record);

        $created = \App\Models\Asset::where('name', 'host-skipped-mapping')->firstOrFail();
        $this->assertNotSame('VENDOR-TAG-003', $created->asset_tag);
    }

    public function test_adapter_declares_extra_fields_via_schema()
    {
        $fleet = $this->configuredFleetInstance();
        $adapter = new FleetAdapter($fleet);

        $extras = $adapter->extraFields();

        // Fleet's normalize() emits these four extras. the declaration
        // matches so the mapping UI knows to render dropdowns for
        // them.
        $this->assertArrayHasKey('fleet_team', $extras);
        $this->assertArrayHasKey('fleet_labels', $extras);
        $this->assertArrayHasKey('fleet_uuid', $extras);
        $this->assertArrayHasKey('fleet_status', $extras);
    }

    public function test_settings_page_renders_extra_field_picker_for_adapter_that_declares_them()
    {
        // Side-effect factory create. The custom field is a fixture that
        // has to exist on the DB for the settings page to render it as
        // an extras-mapping target. The returned instance isn't
        // referenced by name. The assertion just checks the field's
        // name string shows up in the rendered HTML.
        CustomField::factory()->create(['element' => 'text', 'name' => 'Team Assignment']);

        $html = $this->actingAs(\App\Models\User::factory()->superuser()->create())
            ->get(route('settings.adapters.index', ['adapter' => 'fleet']))
            ->assertOk()
            ->getContent();

        // Each unmapped Fleet extra shows up as a picker option carrying
        // its key as the value and its resolved label as the option text
        // (mapping-picker widget replaced the one-row-per-extra @foreach).
        $this->assertStringContainsString('value="fleet_team"', $html);
        $this->assertStringContainsString('value="fleet_labels"', $html);
        // Custom field is offered as a target inside each option's
        // data-target-options JSON. The custom field's name shows up
        // literally in that JSON.
        $this->assertStringContainsString('Team Assignment', $html);
    }

    private function configuredFleetInstance(): SyncAdapterInstance
    {
        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://example.com/fleet');
        SyncAdapterConfig::put($instance->id, 'token', Crypt::encrypt('fake-token'));

        return $instance->fresh();
    }

    /**
     * @param  array<int, string>|null  $labels
     * @return array<string, mixed>
     */
    private function fleetHost(
        int $id,
        string $hostname = 'host',
        string $hardware_model = 'Generic Laptop',
        ?string $team_name = null,
        ?array $labels = null,
    ): array {
        return [
            'id' => $id,
            'hostname' => $hostname,
            'hardware_model' => $hardware_model,
            'team_name' => $team_name,
            'labels' => $labels,
            'uuid' => 'fleet-uuid-'.$id,
            'status' => 'online',
        ];
    }
}
