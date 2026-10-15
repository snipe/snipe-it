<?php

namespace Tests\Feature\Consumables\Ui;

use App\Models\Accessory;
use App\Models\CheckoutRequest;
use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

/**
 * Consumable-checkout screen reached from /requests: the right column
 * gains a "Requested" box + optional "Also Requested By" box so the
 * admin sees who asked and who else is waiting. Wiring lives in
 * ConsumableCheckoutController::create (calls CheckoutRequest::
 * contextForCheckout for URL-twiddle guards) and is rendered by the
 * shared <x-checkout-request-context> component. Full guard matrix
 * is covered in ComponentCheckoutRequestingUserTest; these tests
 * just prove the wiring reaches this view.
 */
class ConsumableCheckoutRequestContextTest extends TestCase
{
    public function test_view_receives_checkout_request_when_request_id_is_valid(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $consumable = Consumable::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
        ]);

        $this->actingAs($admin)
            ->get(route('consumables.checkout.show', [
                'consumablesID' => $consumable->id,
                'request_id' => $checkoutRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', fn ($r) => $r?->id === $checkoutRequest->id);
    }

    public function test_view_receives_null_when_request_id_absent(): void
    {
        $admin = User::factory()->superuser()->create();
        $consumable = Consumable::factory()->create();

        $this->actingAs($admin)
            ->get(route('consumables.checkout.show', ['consumablesID' => $consumable->id]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null)
            ->assertViewHas('otherPendingRequests', fn ($p) => collect($p)->isEmpty());
    }

    public function test_forged_request_id_for_a_different_requestable_type_is_ignored(): void
    {
        // Cross-type guard: an Accessory's request_id passed to the
        // consumable screen must not hydrate an off-scope requester.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $consumable = Consumable::factory()->create();
        $accessory = Accessory::factory()->create();

        $accessoryRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $this->actingAs($admin)
            ->get(route('consumables.checkout.show', [
                'consumablesID' => $consumable->id,
                'request_id' => $accessoryRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null);
    }

    public function test_view_receives_other_pending_requests_excluding_the_current_row(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $other = User::factory()->create();
        $consumable = Consumable::factory()->create();

        $currentRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
        ]);
        $otherOpen = CheckoutRequest::factory()->create([
            'user_id' => $other->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
        ]);
        // Canceled row must not appear.
        CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
            'canceled_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('consumables.checkout.show', [
                'consumablesID' => $consumable->id,
                'request_id' => $currentRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('otherPendingRequests', function ($pending) use ($otherOpen, $currentRequest) {
                $ids = collect($pending)->pluck('id')->all();

                return count($ids) === 1
                    && in_array($otherOpen->id, $ids, true)
                    && ! in_array($currentRequest->id, $ids, true);
            });
    }
}
