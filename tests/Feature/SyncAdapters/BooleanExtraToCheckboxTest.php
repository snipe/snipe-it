<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Fleet\FleetAdapter;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Regression for #19725. Boolean extras get stringified by
 * SyncsHostFromRecord::stringifyExtra() into '1' or '0'. When the
 * admin has mapped the extra to a single-option checkbox custom field
 * (option list = ['1']), the '0' string fails the `checkboxes`
 * validation rule ("contains invalid options") and blows up the
 * whole asset save. None of the device's mapped values persist.
 *
 * The fix in writeCustom() coerces '0' -> '' at the write boundary
 * when the target field is a checkbox that does not list '0' as one
 * of its valid options. Empty string is what an unchecked checkbox
 * stores natively and passes validation cleanly. Two-option
 * "on/off" checkboxes that DO list '0' as a valid option keep the
 * raw '0' passed through.
 */
class BooleanExtraToCheckboxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_false_boolean_extra_saves_as_empty_on_single_option_checkbox(): void
    {
        $checkbox = CustomField::factory()->create([
            'element' => 'checkbox',
            'name' => 'MDM BYOD',
            'field_values' => '1',
        ]);
        $this->attachCheckboxToNewFieldset($checkbox);

        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_byod', 'custom:'.$checkbox->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(
                        id: 42,
                        hostname: 'byod-off-host',
                        mdmEnrollmentStatus: 'On (corporate)',
                    ),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $asset = Asset::where('name', 'byod-off-host')->firstOrFail();
        $this->assertSame('', $asset->{$checkbox->db_column});
    }

    public function test_true_boolean_extra_still_saves_as_one_on_single_option_checkbox(): void
    {
        $checkbox = CustomField::factory()->create([
            'element' => 'checkbox',
            'name' => 'MDM BYOD',
            'field_values' => '1',
        ]);
        $this->attachCheckboxToNewFieldset($checkbox);

        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_byod', 'custom:'.$checkbox->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(
                        id: 43,
                        hostname: 'byod-on-host',
                        mdmEnrollmentStatus: 'On (personal)',
                    ),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $asset = Asset::where('name', 'byod-on-host')->firstOrFail();
        $this->assertSame('1', $asset->{$checkbox->db_column});
    }

    public function test_two_option_checkbox_still_stores_zero_when_zero_is_a_valid_option(): void
    {
        // A checkbox with both '1' and '0' as options represents an
        // explicit on/off shape. In that setup '0' IS a valid
        // stored value and must survive the write path unchanged so
        // the vendor's false gets recorded rather than silently
        // collapsed to empty.
        $checkbox = CustomField::factory()->create([
            'element' => 'checkbox',
            'name' => 'MDM BYOD On Off',
            'field_values' => "1\n0",
        ]);
        $this->attachCheckboxToNewFieldset($checkbox);

        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_byod', 'custom:'.$checkbox->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(
                        id: 44,
                        hostname: 'byod-explicit-off',
                        mdmEnrollmentStatus: 'On (corporate)',
                    ),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $asset = Asset::where('name', 'byod-explicit-off')->firstOrFail();
        $this->assertSame('0', $asset->{$checkbox->db_column});
    }

    public function test_other_mapped_values_still_persist_when_boolean_extra_is_false(): void
    {
        // Core regression: pre-fix, the whole asset save failed on
        // the checkbox validator so NOTHING mapped to the asset
        // saved. Confirm that hostname AND a scalar extra both
        // persist alongside the false boolean.
        $checkbox = CustomField::factory()->create([
            'element' => 'checkbox',
            'name' => 'MDM BYOD',
            'field_values' => '1',
        ]);
        $textField = CustomField::factory()->create(['element' => 'text', 'name' => 'Fleet Team']);
        $this->attachCheckboxToNewFieldset($checkbox, $textField);

        $fleet = $this->configuredFleetInstance();
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_byod', 'custom:'.$checkbox->id);
        SyncAdapterConfig::put($fleet->id, 'mapping.fleet_team', 'custom:'.$textField->id);

        Http::fake([
            '*/api/latest/fleet/hosts*' => Http::sequence()
                ->push(['hosts' => [
                    $this->fleetHost(
                        id: 45,
                        hostname: 'coverage-host',
                        team_name: 'Engineering',
                        mdmEnrollmentStatus: 'On (corporate)',
                    ),
                ]])
                ->push(['hosts' => []]),
        ]);

        $adapter = new FleetAdapter($fleet);
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $asset = Asset::where('name', 'coverage-host')->firstOrFail();
        $this->assertSame('Engineering', $asset->{$textField->db_column});
        $this->assertSame('', $asset->{$checkbox->db_column});
    }

    private function attachCheckboxToNewFieldset(CustomField ...$fields): CustomFieldset
    {
        $fieldset = CustomFieldset::factory()->create();
        foreach ($fields as $field) {
            $fieldset->fields()->attach($field->id, ['required' => 0, 'order' => 1]);
        }

        // Pre-create the AssetModel the Fleet host payloads reference
        // (hardware_model="Generic Laptop") with the fieldset already
        // attached. resolveModelIdByName inside the sync finds this
        // existing model by name and reuses it rather than
        // auto-creating a fresh fieldset-less "Discovered Hardware"
        // shell, so the fieldset's checkbox validation rule actually
        // fires on the Asset::saveOrFail() at the end of the sync.
        AssetModel::factory()->create([
            'name' => 'Generic Laptop',
            'fieldset_id' => $fieldset->id,
        ]);

        return $fieldset;
    }

    private function configuredFleetInstance(): SyncAdapterInstance
    {
        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://example.com/fleet');
        SyncAdapterConfig::put($instance->id, 'token', Crypt::encrypt('fake-token'));

        return $instance->fresh();
    }

    /**
     * @return array<string, mixed>
     */
    private function fleetHost(
        int $id,
        string $hostname = 'host',
        string $hardware_model = 'Generic Laptop',
        ?string $team_name = null,
        ?string $mdmEnrollmentStatus = null,
    ): array {
        return [
            'id' => $id,
            'hostname' => $hostname,
            'hardware_model' => $hardware_model,
            'team_name' => $team_name,
            'uuid' => 'fleet-uuid-'.$id,
            'status' => 'online',
            'mdm' => [
                'enrollment_status' => $mdmEnrollmentStatus,
            ],
        ];
    }
}
