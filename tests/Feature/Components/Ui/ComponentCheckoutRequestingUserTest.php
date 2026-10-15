<?php

namespace Tests\Feature\Components\Ui;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\Component;
use App\Models\User;
use Tests\TestCase;

/**
 * Component-checkout screen reached from /requests: the target-asset
 * picker pre-scopes to the requesting user's assigned assets so the
 * admin can install the part without hunting, and an info callout
 * above the form surfaces the request context (who asked for it and
 * who else is still waiting).
 *
 * Wiring: `checkoutRequestActionsFormatter` appends ?request_id={id}
 * for Component rows; ComponentCheckoutController::create loads the
 * CheckoutRequest, validates it targets THIS component (guarded
 * against URL-twiddling), and exposes requestingUserId +
 * checkoutRequest + otherPendingRequests to the view; the asset
 * select2 forwards requestingUserId as assignedTo which
 * AssetsController::selectlist honors unconditionally (empty picker
 * when the requester has no assigned assets, so the admin sees the
 * scoping instead of a silent fallback to the full fleet).
 */
class ComponentCheckoutRequestingUserTest extends TestCase
{
    public function test_view_receives_requesting_user_id_from_valid_request_id(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $component = Component::factory()->create(['qty' => 5]);
        Asset::factory()->assignedToUser($requester)->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
        ]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => $checkoutRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('requestingUserId', $requester->id);
    }

    public function test_view_falls_back_to_null_when_request_id_absent(): void
    {
        $admin = User::factory()->superuser()->create();
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', ['componentID' => $component->id]))
            ->assertOk()
            ->assertViewHas('requestingUserId', null);
    }

    public function test_forged_request_id_targeting_different_component_is_ignored(): void
    {
        // Admin twiddles the URL to reference a CheckoutRequest that
        // targets a DIFFERENT component. Guard must ignore it so an
        // admin can't see which users have open requests on
        // components they aren't currently working with.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();

        $component = Component::factory()->create(['qty' => 5]);
        $otherComponent = Component::factory()->create(['qty' => 5]);

        $requestForOther = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $otherComponent->id,
            'requestable_type' => Component::class,
        ]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => $requestForOther->id,
            ]))
            ->assertOk()
            ->assertViewHas('requestingUserId', null);
    }

    public function test_forged_request_id_of_different_requestable_type_is_ignored(): void
    {
        // Same guard, non-Component requestable_type. An accessory
        // request-id passed to a component checkout must not hydrate
        // the picker from an unrelated request's user.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $component = Component::factory()->create(['qty' => 5]);
        $accessory = Accessory::factory()->create();

        $accessoryRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => $accessoryRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('requestingUserId', null);
    }

    public function test_canceled_request_is_ignored(): void
    {
        // Stale canceled rows shouldn't influence live checkout UX.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $component = Component::factory()->create(['qty' => 5]);
        $canceledRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'canceled_at' => now()->subMinute(),
        ]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => $canceledRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('requestingUserId', null);
    }

    public function test_nonexistent_request_id_is_ignored(): void
    {
        $admin = User::factory()->superuser()->create();
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => 999999,
            ]))
            ->assertOk()
            ->assertViewHas('requestingUserId', null);
    }

    public function test_selectlist_scopes_to_users_assigned_assets_when_assigned_to_is_set(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $otherUser = User::factory()->create();

        $assignedToRequester = Asset::factory()->assignedToUser($requester)->create();
        $assignedToOther = Asset::factory()->assignedToUser($otherUser)->create();

        $rows = $this->actingAsForApi($admin)
            ->getJson(route('assets.selectlist', ['assignedTo' => $requester->id]))
            ->assertOk()
            ->json('results');

        $ids = collect($rows)->pluck('id')->all();
        $this->assertContains($assignedToRequester->id, $ids);
        $this->assertNotContains($assignedToOther->id, $ids);
    }

    public function test_view_receives_checkout_request_and_other_pending_requests(): void
    {
        // The info callout above the form reads from two view vars:
        // $checkoutRequest (the row we came in on) and
        // $otherPendingRequests (anyone else still waiting on the same
        // component). Both must resolve when the request_id is valid;
        // the other-pending list must exclude the current row and any
        // canceled rows so the admin sees an accurate waiting list.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $anotherRequester = User::factory()->create();
        $thirdRequester = User::factory()->create();
        $component = Component::factory()->create(['qty' => 5]);

        $currentRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'quantity' => 2,
        ]);
        $otherOpen = CheckoutRequest::factory()->create([
            'user_id' => $anotherRequester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'quantity' => 1,
        ]);
        // Canceled row shouldn't appear in the waiting list.
        CheckoutRequest::factory()->create([
            'user_id' => $thirdRequester->id,
            'requestable_id' => $component->id,
            'requestable_type' => Component::class,
            'canceled_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->get(route('components.checkout.show', [
                'componentID' => $component->id,
                'request_id' => $currentRequest->id,
            ]))
            ->assertOk();

        $response->assertViewHas('checkoutRequest', fn ($request) => $request?->id === $currentRequest->id);
        $response->assertViewHas('otherPendingRequests', function ($pending) use ($otherOpen, $currentRequest) {
            $ids = collect($pending)->pluck('id')->all();

            return count($ids) === 1
                && in_array($otherOpen->id, $ids, true)
                && ! in_array($currentRequest->id, $ids, true);
        });
    }

    public function test_view_falls_back_to_empty_pending_list_when_request_id_absent(): void
    {
        $admin = User::factory()->superuser()->create();
        $component = Component::factory()->create(['qty' => 5]);

        $response = $this->actingAs($admin)
            ->get(route('components.checkout.show', ['componentID' => $component->id]))
            ->assertOk();

        $response->assertViewHas('checkoutRequest', null);
        $response->assertViewHas('otherPendingRequests', fn ($pending) => collect($pending)->isEmpty());
    }

    public function test_selectlist_returns_empty_when_target_user_has_no_assigned_assets(): void
    {
        // When the requester has nothing assigned to them, the picker
        // returns an empty list rather than falling through to the
        // full fleet. Showing every asset would defeat the point of
        // scoping ("install this into one of the requester's assets")
        // and misleads the admin about who owns what.
        $admin = User::factory()->superuser()->create();
        $userWithNoAssets = User::factory()->create();
        Asset::factory()->create();

        $rows = $this->actingAsForApi($admin)
            ->getJson(route('assets.selectlist', ['assignedTo' => $userWithNoAssets->id]))
            ->assertOk()
            ->json('results');

        $this->assertSame([], $rows);
    }
}
