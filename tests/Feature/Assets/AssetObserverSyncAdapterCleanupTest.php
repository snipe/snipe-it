<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * AssetObserver::deleting cascades a hard delete to
 * asset_external_sources so a soft-deleted asset does not leave the
 * sync loop crashing on the next run. Without this, the still-
 * present identity row keeps the vendor's (source, external_id)
 * pair locked, and provisionAsset's fresh-asset path violates the
 * unique constraint on that pair.
 */
class AssetObserverSyncAdapterCleanupTest extends TestCase
{
    public function test_soft_deleting_an_asset_removes_its_sync_adapter_identity_rows(): void
    {
        $asset = Asset::factory()->create();

        DB::table('asset_external_sources')->insert([
            'asset_id' => $asset->id,
            'source' => 'fleet',
            'external_id' => 'ext-42',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $asset->delete();

        // Soft-delete leaves the asset row in place with a deleted_at
        // timestamp, but the identity row is gone so the next sync
        // does not trip the unique(source, external_id) constraint.
        $this->assertDatabaseHas('assets', ['id' => $asset->id]);
        $this->assertNotNull($asset->fresh()->deleted_at);
        $this->assertDatabaseMissing('asset_external_sources', ['asset_id' => $asset->id]);
    }

    public function test_deleting_an_asset_with_multiple_source_rows_removes_all_of_them(): void
    {
        // An asset synced from more than one vendor (Fleet + Landscape,
        // say) has one identity row per source. All get cleaned up.
        $asset = Asset::factory()->create();

        foreach (['fleet' => 'ext-1', 'landscape' => 'lscape-99'] as $source => $externalId) {
            DB::table('asset_external_sources')->insert([
                'asset_id' => $asset->id,
                'source' => $source,
                'external_id' => $externalId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $asset->delete();

        $this->assertSame(0, DB::table('asset_external_sources')->where('asset_id', $asset->id)->count());
    }
}
