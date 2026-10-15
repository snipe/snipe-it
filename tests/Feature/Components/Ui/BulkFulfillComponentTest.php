<?php

namespace Tests\Feature\Components\Ui;

use App\Actions\CheckoutRequests\FulfillCheckoutRequestAction;
use App\Enums\CheckoutRequestState;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\Component;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Bulk-fulfill flow for Components. Distinct from the user-target
 * qty-tracked types (accessory/consumable/license) because a
 * component checkout targets an Asset (not a User) - the component
 * gets installed INTO an asset belonging to the requester. The
 * per-row picker is scoped to the requester's assigned assets.
 *
 * The state-machine listener only fires fulfillment for User-
 * target checkouts, so this controller closes the request
 * explicitly via FulfillCheckoutRequestAction after each row
 * commits. Partial-fulfillment tracking rides through via the
 * qty argument.
 */
class BulkFulfillComponentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_requires_checkout_permission_on_components(): void
    {
        $component = Component::factory()->create(['qty' => 10]);

        $this->actingAs(User::factory()->create())
            ->get(route('components.fulfill-requests.create', $component))
            ->assertForbidden();
    }

    public function test_row_disabled_for_requester_with_no_assigned_assets(): void
    {
        // Component installs INTO an asset the requester owns. A
        // requester with zero assigned assets has no target to
        // install into, so their row surfaces with an empty
        // available-asset set (view renders disabled with an
        // explanatory message).
        $admin = User::factory()->checkoutComponents()->create();
        $component = Component::factory()->create(['qty' => 10]);
        $noAssetsRequester = User::factory()->create();

        CheckoutRequest::factory()->create([
            'user_id' => $noAssetsRequester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
        ]);

        $this->actingAs($admin)
            ->get(route('components.fulfill-requests.create', $component))
            ->assertOk()
            ->assertViewHas('rowContext', function ($ctx) use ($noAssetsRequester) {
                $req = CheckoutRequest::where('user_id', $noAssetsRequester->id)->first();

                return isset($ctx[$req->id])
                    && $ctx[$req->id]['availableAssets']->isEmpty();
            });
    }

    public function test_fulfills_ticked_row_and_closes_request_explicitly(): void
    {
        // Component targets an Asset, and the state-machine
        // listener only fires for User-target checkouts. Verify
        // the controller closes the request explicitly (the
        // listener would silently skip it).
        $admin = User::factory()->checkoutComponents()->create();
        $component = Component::factory()->create(['qty' => 10]);
        $requester = User::factory()->create();
        $targetAsset = Asset::factory()->assignedToUser($requester)->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'quantity' => 2,
        ]);

        $this->actingAs($admin)
            ->post(route('components.fulfill-requests.store', $component), [
                'enabled_requests' => [$request->id => '1'],
                'asset_id' => [$request->id => $targetAsset->id],
                'qty' => [$request->id => 2],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->fresh()->state);
        $this->assertSame(2, $request->fresh()->fulfilled_quantity);
    }

    public function test_asset_not_belonging_to_requester_is_rejected(): void
    {
        // Requester-scoping guard: hand-crafted POST pointing at
        // an asset that belongs to a DIFFERENT user must not
        // install the component into that other user's asset.
        $admin = User::factory()->checkoutComponents()->create();
        $component = Component::factory()->create(['qty' => 10]);
        $requester = User::factory()->create();
        $someoneElse = User::factory()->create();
        $someoneElsesAsset = Asset::factory()->assignedToUser($someoneElse)->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'quantity' => 1,
        ]);

        $this->actingAs($admin)
            ->post(route('components.fulfill-requests.store', $component), [
                'enabled_requests' => [$request->id => '1'],
                'asset_id' => [$request->id => $someoneElsesAsset->id],
                'qty' => [$request->id => 1],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(CheckoutRequestState::Pending, $request->fresh()->state);
    }

    public function test_partial_qty_leaves_row_pending_with_counter_advanced(): void
    {
        $admin = User::factory()->checkoutComponents()->create();
        $component = Component::factory()->create(['qty' => 10]);
        $requester = User::factory()->create();
        $targetAsset = Asset::factory()->assignedToUser($requester)->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'quantity' => 5,
        ]);

        $this->actingAs($admin)
            ->post(route('components.fulfill-requests.store', $component), [
                'enabled_requests' => [$request->id => '1'],
                'asset_id' => [$request->id => $targetAsset->id],
                'qty' => [$request->id => 2],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $fresh = $request->fresh();
        $this->assertSame(CheckoutRequestState::Pending, $fresh->state);
        $this->assertSame(2, $fresh->fulfilled_quantity);
        $this->assertSame(3, $fresh->remainingQuantity());
    }
}
