<?php

namespace Tests\Feature\Requests;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use Tests\TestCase;

/**
 * Cascade rules for CheckoutRequest rows when their requestable is
 * force-deleted or purged. Soft-delete deliberately leaves history
 * intact (a restore should bring the requests back); only a real
 * hard-delete wipes them.
 *
 * Two hooks cover the two entry points:
 *   - snipeit:purge iterates raw query-builder DELETEs (bypasses
 *     Eloquent events), so Purge::$childTables has its own explicit
 *     cascade entry.
 *   - Direct forceDelete() bypasses the purge command; the trait's
 *     bootRequestable() forceDeleted listener handles it.
 */
class PurgePendingRequestsTest extends TestCase
{
    public function test_direct_force_delete_of_asset_wipes_its_pending_requests(): void
    {
        $asset = Asset::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $asset->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $req->id]);
    }

    public function test_direct_force_delete_of_accessory_wipes_its_pending_requests(): void
    {
        $accessory = Accessory::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $accessory->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $req->id]);
    }

    public function test_direct_force_delete_of_consumable_wipes_its_pending_requests(): void
    {
        $consumable = Consumable::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
        ]);

        $consumable->forceDelete();

        // Sanity check: the consumable itself is genuinely gone. If
        // ConsumableObserver::deleting aborted mid-flight (a common
        // trap since it calls users()->detach() and $consumable->save()
        // during the deleting event), the row would still be here and
        // the request-cascade assertion below would be a false negative.
        $this->assertDatabaseMissing('consumables', ['id' => $consumable->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $req->id]);
    }

    public function test_direct_force_delete_of_component_wipes_its_pending_requests(): void
    {
        $component = Component::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
        ]);

        $component->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $req->id]);
    }

    public function test_direct_force_delete_of_license_wipes_its_pending_requests(): void
    {
        $license = License::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);

        $license->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $req->id]);
    }

    public function test_soft_delete_does_not_wipe_pending_requests(): void
    {
        // The request stays around after a soft-delete so admins can
        // still see the intent + restore recovers cleanly. Only
        // forceDelete / purge should nuke.
        $asset = Asset::factory()->create();
        $req = CheckoutRequest::factory()->create([
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $asset->delete();

        $this->assertDatabaseHas('checkout_requests', ['id' => $req->id]);
    }

    public function test_snipeit_purge_cascades_pending_requests_for_every_requestable_type(): void
    {
        // Purge walks raw query-builder DELETEs (no model events), so
        // this pins the explicit Purge::$childTables entry for every
        // Requestable model. One trashed row per type, one pending
        // request per row, plus a live control row per type that must
        // survive the purge.
        $trashedAsset = Asset::factory()->create();
        $trashedAsset->delete();
        $trashedAssetRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $liveAsset = Asset::factory()->create();
        $liveAssetRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $liveAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $trashedAccessory = Accessory::factory()->create();
        $trashedAccessory->delete();
        $trashedAccessoryRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedAccessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $trashedConsumable = Consumable::factory()->create();
        $trashedConsumable->delete();
        $trashedConsumableRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedConsumable->id,
            'requestable_type' => Consumable::class,
        ]);

        $trashedComponent = Component::factory()->create();
        $trashedComponent->delete();
        $trashedComponentRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedComponent->id,
            'requestable_type' => Component::class,
        ]);

        $trashedAssetModel = AssetModel::factory()->create();
        $trashedAssetModel->delete();
        $trashedAssetModelRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedAssetModel->id,
            'requestable_type' => AssetModel::class,
        ]);

        $trashedLicense = License::factory()->create();
        $trashedLicense->delete();
        $trashedLicenseRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $trashedLicense->id,
            'requestable_type' => License::class,
        ]);

        $this->artisan('snipeit:purge', ['--force' => 'true'])->assertExitCode(0);

        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedAssetRequest->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedAccessoryRequest->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedConsumableRequest->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedComponentRequest->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedAssetModelRequest->id]);
        $this->assertDatabaseMissing('checkout_requests', ['id' => $trashedLicenseRequest->id]);

        // Control row: live asset's request must survive the purge.
        $this->assertDatabaseHas('checkout_requests', ['id' => $liveAssetRequest->id]);
    }
}
