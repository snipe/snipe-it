<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\Accessory;
use App\Models\CheckoutRequest;
use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

/**
 * Accessory-checkout screen reached from /requests: the right column
 * gains a "Requested" box + optional "Also Requested By" box so the
 * admin sees who asked and who else is waiting before deciding how
 * much to hand out. Wiring lives in AccessoryCheckoutController::
 * create (calls CheckoutRequest::contextForCheckout for URL-twiddle
 * guards) and is rendered by the shared <x-checkout-request-context>
 * component. The full guard matrix is exercised through the
 * Components equivalent (ComponentCheckoutRequestingUserTest); these
 * tests just prove the wiring reaches the accessory checkout view.
 */
class AccessoryCheckoutRequestContextTest extends TestCase
{
    public function test_view_receives_checkout_request_when_request_id_is_valid(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $this->actingAs($admin)
            ->get(route('accessories.checkout.show', [
                'accessory' => $accessory->id,
                'request_id' => $checkoutRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', fn ($r) => $r?->id === $checkoutRequest->id);
    }

    public function test_view_receives_null_when_request_id_absent(): void
    {
        $admin = User::factory()->superuser()->create();
        $accessory = Accessory::factory()->create();

        $this->actingAs($admin)
            ->get(route('accessories.checkout.show', ['accessory' => $accessory->id]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null)
            ->assertViewHas('otherPendingRequests', fn ($p) => collect($p)->isEmpty());
    }

    public function test_forged_request_id_for_a_different_requestable_type_is_ignored(): void
    {
        // Cross-type guard: a Consumable's request_id passed to the
        // accessory screen must not hydrate an off-scope requester
        // into the accessory checkout context.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $consumable = Consumable::factory()->create();

        $consumableRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
        ]);

        $this->actingAs($admin)
            ->get(route('accessories.checkout.show', [
                'accessory' => $accessory->id,
                'request_id' => $consumableRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null);
    }

    public function test_view_receives_other_pending_requests_ordered_oldest_first(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $earlier = User::factory()->create();
        $later = User::factory()->create();
        $accessory = Accessory::factory()->create();

        // Waiting-list ordering: created_at then id. Persist rows in
        // reverse to confirm the helper sorts, doesn't rely on insert
        // order.
        $currentRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);
        $laterOther = CheckoutRequest::factory()->create([
            'user_id' => $later->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'created_at' => now()->subMinutes(2),
        ]);
        $earlierOther = CheckoutRequest::factory()->create([
            'user_id' => $earlier->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'created_at' => now()->subHours(2),
        ]);

        $this->actingAs($admin)
            ->get(route('accessories.checkout.show', [
                'accessory' => $accessory->id,
                'request_id' => $currentRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('otherPendingRequests', function ($pending) use ($earlierOther, $laterOther, $currentRequest) {
                $ids = collect($pending)->pluck('id')->all();

                return $ids === [$earlierOther->id, $laterOther->id]
                    && ! in_array($currentRequest->id, $ids, true);
            });
    }
}
