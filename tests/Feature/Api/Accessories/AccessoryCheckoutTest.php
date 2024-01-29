<?php

namespace Tests\Feature\Api\Accessories;

use App\Models\Accessory;
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
        $this->markTestIncomplete();
    }

    public function testValidation()
    {
        $this->markTestIncomplete();
    }

    public function testAccessoryMustBeAvailableWhenCheckingOut()
    {
        $this->markTestIncomplete();
    }

    public function testAccessoryCanBeCheckedOut()
    {
        $this->markTestIncomplete();
    }

    public function testUserSentNotificationUponCheckout()
    {
        $this->markTestIncomplete();

        $this->withoutExceptionHandling();

        Notification::fake();

        $accessory = Accessory::factory()->requiringAcceptance()->create();
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_to' => $user->id,
            ]);

        Notification::assertSentTo($user, CheckoutAccessoryNotification::class);
    }

    public function testActionLogCreatedUponCheckout()
    {
        $this->markTestIncomplete();
    }

    public function testUserSentEulaUponCheckoutIfAcceptanceRequired()
    {
        $this->markTestIncomplete();
    }
}
