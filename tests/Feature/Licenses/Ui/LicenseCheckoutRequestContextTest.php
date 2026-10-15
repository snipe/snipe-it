<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\Accessory;
use App\Models\CheckoutRequest;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

/**
 * License-checkout screen reached from /requests: the right column
 * gains a "Requested" box + optional "Also Requested By" box so the
 * admin sees who asked and who else is waiting. Wiring lives in
 * LicenseCheckoutController::create (calls CheckoutRequest::
 * contextForCheckout for URL-twiddle guards) and is rendered by the
 * shared <x-checkout-request-context> component. Full guard matrix
 * is covered in ComponentCheckoutRequestingUserTest; these tests
 * just prove the wiring reaches this view.
 */
class LicenseCheckoutRequestContextTest extends TestCase
{
    public function test_view_receives_checkout_request_when_request_id_is_valid(): void
    {
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $license = License::factory()->create(['seats' => 5]);
        $checkoutRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);

        $this->actingAs($admin)
            ->get(route('licenses.checkout', [
                'license' => $license->id,
                'request_id' => $checkoutRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', fn ($r) => $r?->id === $checkoutRequest->id);
    }

    public function test_view_receives_null_when_request_id_absent(): void
    {
        $admin = User::factory()->superuser()->create();
        $license = License::factory()->create(['seats' => 5]);

        $this->actingAs($admin)
            ->get(route('licenses.checkout', ['license' => $license->id]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null)
            ->assertViewHas('otherPendingRequests', fn ($p) => collect($p)->isEmpty());
    }

    public function test_forged_request_id_for_a_different_requestable_type_is_ignored(): void
    {
        // Cross-type guard: an Accessory's request_id passed to the
        // license screen must not hydrate an off-scope requester.
        $admin = User::factory()->superuser()->create();
        $requester = User::factory()->create();
        $license = License::factory()->create(['seats' => 5]);
        $accessory = Accessory::factory()->create();

        $accessoryRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);

        $this->actingAs($admin)
            ->get(route('licenses.checkout', [
                'license' => $license->id,
                'request_id' => $accessoryRequest->id,
            ]))
            ->assertOk()
            ->assertViewHas('checkoutRequest', null);
    }
}
