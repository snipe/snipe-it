<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\Asset;
use App\Models\AssetExternalSource;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SilentSaveFailureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_update_path_throws_when_asset_save_fails_validation(): void
    {
        // Trigger a save-time validation failure via the asset_tag
        // unique_undeleted rule. Create two pre-existing assets, then
        // sync a record that tries to overwrite one asset's tag with
        // a value already taken by the other. The save-time
        // ValidatingObserver aborts the save with return false, and
        // pre-fix syncFromRecord swallowed the boolean and counted
        // the record as processed. Uses no custom fields, so no
        // ALTER TABLE fires inside the test transaction (which
        // implicitly commits on MySQL / MariaDB and corrupts the
        // savepoint state under LazilyRefreshDatabase).
        $model = AssetModel::factory()->create(['name' => 'Generic Laptop']);
        Asset::factory()->create(['asset_tag' => 'COLLIDE-ME', 'model_id' => $model->id]);
        $target = Asset::factory()->create(['asset_tag' => 'ORIG-TAG', 'model_id' => $model->id]);

        $this->configuredFleetInstance();
        AssetExternalSource::create([
            'asset_id' => $target->id,
            'source' => 'fleet',
            'external_id' => 'fleet-collide-record',
        ]);

        // Record's assetTag targets native:asset_tag by default. Writing
        // "COLLIDE-ME" onto the target asset trips unique_undeleted
        // against the first asset created above.
        $record = new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'fleet-collide-record',
            hostname: 'target-host',
            hardwareSerial: 'SN-TARGET',
            hardwareModel: 'Generic Laptop',
            assetTag: 'COLLIDE-ME',
        );

        $thrown = null;
        try {
            SyncAdapter::syncFromRecord($record);
        } catch (\Throwable $e) {
            $thrown = $e;
        }

        $this->assertNotNull($thrown, 'syncFromRecord must surface a save-failure on the update path so the pull loop counts it as an error rather than silently succeeding.');
        // The RuntimeException wraps the underlying validation
        // failure so the pull loop's log line names the offending
        // record and the reason. Prior to the fix, no exception
        // reached this point.
        $this->assertStringContainsString('could not update asset for fleet record fleet-collide-record', $thrown->getMessage());

        // Duplicate tag must not have been persisted onto the target.
        $target->refresh();
        $this->assertSame('ORIG-TAG', $target->asset_tag);
    }

    public function test_valid_update_path_still_persists(): void
    {
        // Sanity check that the guard did not turn valid updates into
        // errors. A record that would pass validation completes the
        // update and lands its mapped values.
        $model = AssetModel::factory()->create(['name' => 'Generic Laptop']);
        $asset = Asset::factory()->create([
            'name' => 'pre-existing-clean',
            'model_id' => $model->id,
        ]);

        $this->configuredFleetInstance();
        AssetExternalSource::create([
            'asset_id' => $asset->id,
            'source' => 'fleet',
            'external_id' => 'fleet-clean-update',
        ]);

        $record = new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: 'fleet-clean-update',
            hostname: 'now-renamed',
            hardwareSerial: 'SN-EXIST',
            hardwareModel: 'Generic Laptop',
        );

        SyncAdapter::syncFromRecord($record);

        $asset->refresh();
        $this->assertSame('now-renamed', $asset->name);
    }

    private function configuredFleetInstance(): SyncAdapterInstance
    {
        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://example.com/fleet');
        SyncAdapterConfig::put($instance->id, 'token', Crypt::encrypt('fake-token'));

        return $instance->fresh();
    }
}
