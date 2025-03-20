<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Mail\CheckoutAssetMail;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\TestCase;

class BulkAssetCheckoutTest extends TestCase
{
    public function testHandleMissingModelBeingIncluded()
    {
        Mail::fake();

        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('hardware.bulkcheckout.store'), [
                'selected_assets' => [
                    Asset::factory()->requiresAcceptance()->create()->id,
                    9999999,
                ],
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create(['email' => 'someone@example.com'])->id,
                'assigned_asset' => null,
                'checkout_at' => null,
                'expected_checkin' => null,
                'note' => null,
            ])
            ->assertSessionHas('error', trans_choice('admin/hardware/message.multi-checkout.error', 2));

        try {
            Mail::assertNotSent(CheckoutAssetMail::class);
        } catch (ExpectationFailedException $e) {
            $this->fail('Asset checkout email was sent when the entire checkout failed.');
        }
    }
}
