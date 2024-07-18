<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AccessoryCheckoutTest extends TestCase
{
    public function testCheckingOutAccessoryRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('accessories.checkout.store', Accessory::factory()->create()))
            ->assertForbidden();
    }

    public function testValidationWhenCheckingOutAccessory()
    {
        $accessory = Accessory::factory()->create();
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('accessories.checkout.show', $accessory))
            ->post(route('accessories.checkout.store', $accessory), [
                // missing assigned_to
            ])
            ->assertStatus(302)
            ->assertSessionHas('errors')
            ->assertRedirect(route('accessories.checkout.store', $accessory));

        $this->followRedirects($response)->assertSee(trans('general.error'));
    }

    public function testAccessoryMustHaveAvailableItemsForCheckoutWhenCheckingOut()
    {

        $accessory = Accessory::factory()->withoutItemsRemaining()->create();
        $response = $this->actingAs(User::factory()->viewAccessories()->checkoutAccessories()->create())
            ->from(route('accessories.checkout.show', $accessory))
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => User::factory()->create()->id,
            ])
            ->assertStatus(302)
            ->assertSessionHas('errors')
            ->assertRedirect(route('accessories.checkout.store', $accessory));
        $response->assertInvalid(['checkout_qty']);
        $this->followRedirects($response)->assertSee(trans('general.error'));
    }

    public function testAccessoryCanBeCheckedOutWithoutQuantity()
    {
        $accessory = Accessory::factory()->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => $user->id,
                'note' => 'oh hi there',
            ]);

        $this->assertTrue($accessory->users->contains($user));

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $user->id,
            'target_type' => User::class,
            'item_id' => $accessory->id,
            'item_type' => Accessory::class,
            'note' => 'oh hi there',
        ]);
    }

    public function testAccessoryCanBeCheckedOutWithQuantity()
    {
        $accessory = Accessory::factory()->create(['qty'=>5]);
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->from(route('accessories.checkout.show', $accessory))
            ->post(route('accessories.checkout.store', $accessory), [
                'assigned_to' => $user->id,
                'checkout_qty' => 3,
                'note' => 'oh hi there',
            ]);

        $this->assertTrue($accessory->users->contains($user));

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $user->id,
            'target_type' => User::class,
            'item_id' => $accessory->id,
            'item_type' => Accessory::class,
            'note' => 'oh hi there',
        ]);
    }

    public function testUserSentNotificationUponCheckout()
    {
        Notification::fake();

        $accessory = Accessory::factory()->requiringAcceptance()->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutAccessories()->create())
            ->from(route('accessories.checkout.show', $accessory))
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
            ->from(route('accessories.checkout.show', $accessory))
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
