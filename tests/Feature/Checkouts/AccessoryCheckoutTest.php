<?php

namespace Tests\Feature\Checkouts;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use Illuminate\Support\Facades\Notification;
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

    public function testValidationWhenCheckingOutAccessory()
    {
        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', Accessory::factory()->create()), [
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

    public function testUserSentNotificationUponCheckout()
    {
        Notification::fake();

        $accessory = Accessory::factory()->requiringAcceptance()->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => $user->id,
            ]);

        Notification::assertSentTo($user, CheckoutAccessoryNotification::class);
    }

    public function testActionLogCreatedUponCheckout()
    {
        $accessory = Accessory::factory()->create();
        $actor = User::factory()->checkoutAccessories()->create();
        $user = User::factory()->create();

        $this->actingAs($actor)
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => $user->id,
                'note' => 'oh hi there',
            ]);

        $this->assertEquals(
            1,
            Actionlog::where([
                'action_type' => 'checkout',
                'target_id' => $user->id,
                'target_type' => User::class,
                'item_id' => $accessory->id,
                'item_type' => Accessory::class,
                'user_id' => $actor->id,
                'note' => 'oh hi there',
            ])->count(),
            'Log entry either does not exist or there are more than expected'
        );
    }
}
