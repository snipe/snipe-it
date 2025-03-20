<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\User;
use Tests\TestCase;

class BulkAssetCheckoutTest extends TestCase
{
    public function testHandleMissingModelBeingIncluded()
    {
        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('hardware.bulkcheckout.store'), [
                'selected_assets' => [
                    1,
                    9999999,
                ],
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
                'assigned_asset' => null,
                'checkout_at' => null,
                'expected_checkin' => null,
                'note' => null,
            ])
            ->assertSessionHas('error', trans_choice('admin/hardware/message.multi-checkout.error', 2));
    }
}
