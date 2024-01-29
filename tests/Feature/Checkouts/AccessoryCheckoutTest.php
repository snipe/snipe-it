<?php

namespace Tests\Feature\Checkouts;

use App\Models\Accessory;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AccessoryCheckoutTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingOutAccessoryRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('accessories.checkout.store', Accessory::factory()->create()))
            ->assertForbidden();
    }

    public function testValidation()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', $accessory), [
                // missing assigned_to
            ])
            ->assertSessionHas('error');
    }

    public function testAccessoryMustBeAvailableWhenCheckingOut()
    {
        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', Accessory::factory()->withoutItemsRemaining()->create()), [
                'assigned_to' => User::factory()->create()->id,
            ])
            ->assertSessionHas('error');
    }

    public function testAccessoryCanBeCheckedOut()
    {
        $accessory = Accessory::factory()->create();

        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => $user->id,
            ]);

        $this->assertTrue($accessory->users->contains($user));
    }

    public function testUserSentEulaUponCheckoutIfAcceptanceRequired()
    {
        $this->markTestIncomplete();
    }

    public function testActionLogCreatedUponCheckout()
    {
        $this->markTestIncomplete();

        // check 'note' is saved in action_logs
        // check 'action_source' is saved in action_logs as gui
    }
}
