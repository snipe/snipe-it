<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedOut;
use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AccessoryWebhookTest extends TestCase
{
    public function testAccessoryCheckoutSendsWebhookNotificationWhenSettingEnabled()
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAccessoryNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testAccessoryCheckoutDoesNotSendWebhookNotificationWhenSettingDisabled()
    {
        Notification::fake();

        Setting::factory()->withWebhookDisabled()->create();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAccessoryNotification::class);
    }
}
