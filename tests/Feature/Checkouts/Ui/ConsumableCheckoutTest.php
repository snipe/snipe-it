<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\Actionlog;
use App\Models\Consumable;
use App\Models\User;
use App\Notifications\CheckoutConsumableNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ConsumableCheckoutTest extends TestCase
{
    public function testCheckingOutConsumableRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('consumables.checkout.store', Consumable::factory()->create()))
            ->assertForbidden();
    }

    public function testValidationWhenCheckingOutConsumable()
    {
        $this->actingAs(User::factory()->checkoutConsumables()->create())
            ->post(route('consumables.checkout.store', Consumable::factory()->create()), [
                // missing assigned_to
            ])
            ->assertSessionHas('error');
    }

    public function testConsumableMustBeAvailableWhenCheckingOut()
    {
        $this->actingAs(User::factory()->checkoutConsumables()->create())
            ->post(route('consumables.checkout.store', Consumable::factory()->withoutItemsRemaining()->create()), [
                'assigned_to' => User::factory()->create()->id,
            ])
            ->assertSessionHas('error');
    }

    public function testConsumableCanBeCheckedOut()
    {
        $consumable = Consumable::factory()->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutConsumables()->create())
            ->post(route('consumables.checkout.store', $consumable), [
                'assigned_to' => $user->id,
            ]);

        $this->assertTrue($user->consumables->contains($consumable));
    }

    public function testUserSentNotificationUponCheckout()
    {
        Notification::fake();

        $consumable = Consumable::factory()->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->checkoutConsumables()->create())
            ->post(route('consumables.checkout.store', $consumable), [
                'assigned_to' => $user->id,
            ]);

        Notification::assertSentTo($user, CheckoutConsumableNotification::class);
    }

    public function testActionLogCreatedUponCheckout()
    {
        $consumable = Consumable::factory()->create();
        $actor = User::factory()->checkoutConsumables()->create();
        $user = User::factory()->create();

        $this->actingAs($actor)
            ->post(route('consumables.checkout.store', $consumable), [
                'assigned_to' => $user->id,
                'note' => 'oh hi there',
            ]);

        $this->assertEquals(
            1,
            Actionlog::where([
                'action_type' => 'checkout',
                'target_id' => $user->id,
                'target_type' => User::class,
                'item_id' => $consumable->id,
                'item_type' => Consumable::class,
                'user_id' => $actor->id,
                'note' => 'oh hi there',
            ])->count(),
            'Log entry either does not exist or there are more than expected'
        );
    }
}
