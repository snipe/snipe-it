<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\Asset;
use App\Models\AssetExternalSource;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Fleet\FleetAdapter;
use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

/**
 * Coverage for the per-adapter opt-out that stops `syncFromRecord`
 * from creating new Snipe-IT assets for vendor records with no
 * existing match. Addresses #19752.
 */
class CreateSnipeitAssetsOnPullTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_defaults_on_so_existing_installs_keep_creating()
    {
        $instance = $this->configuredFleet();

        $this->assertTrue((new FleetAdapter($instance))->createsSnipeitAssetsOnPull());
    }

    public function test_unmatched_vendor_record_creates_asset_when_toggle_on()
    {
        $this->configuredFleet();

        $result = SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'fleet-1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-01',
            hardwareModel: 'MacBook Pro',
        ));

        $this->assertNotNull($result);
        $this->assertDatabaseHas('assets', ['name' => 'wksn-01']);
    }

    public function test_unmatched_vendor_record_is_skipped_when_toggle_off()
    {
        $instance = $this->configuredFleet();
        SyncAdapterConfig::put($instance->id, 'create_snipeit_assets_on_pull', '0');

        $result = SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'fleet-skip',
            hostname: 'wksn-skipped',
            hardwareSerial: 'SN-SKIP',
            hardwareModel: 'MacBook Pro',
        ));

        $this->assertNull($result);
        $this->assertDatabaseMissing('assets', ['name' => 'wksn-skipped']);
        $this->assertDatabaseMissing('asset_external_sources', ['source' => 'fleet', 'external_id' => 'fleet-skip']);
    }

    public function test_matched_vendor_record_still_updates_when_toggle_off()
    {
        // Previously-linked assets must keep syncing. Only the no-match
        // branch is gated.
        $instance = $this->configuredFleet();
        SyncAdapterConfig::put($instance->id, 'create_snipeit_assets_on_pull', '0');

        $asset = Asset::factory()->create(['name' => 'wksn-existing', 'serial' => 'SN-EXISTING']);
        AssetExternalSource::create([
            'asset_id' => $asset->id,
            'source' => 'fleet',
            'external_id' => 'fleet-linked',
        ]);

        $result = SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'fleet-linked',
            hostname: 'wksn-updated',
            hardwareSerial: 'SN-EXISTING',
            hardwareModel: 'MacBook Pro',
        ));

        $this->assertNotNull($result);
        $this->assertSame($asset->id, $result->id);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'name' => 'wksn-updated']);
    }

    private function configuredFleet(): SyncAdapterInstance
    {
        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://example.com/fleet');
        SyncAdapterConfig::put($instance->id, 'token', Crypt::encrypt('fake-token'));

        return $instance->fresh();
    }
}
