<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedIn;
use App\Events\CheckoutableCheckedOut;
use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckoutAccessoryNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AccessoryWebhookTest extends TestCase
{
    use InteractsWithSettings;

    public function testAccessoryCheckoutSendsWebhookNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableWebhook();

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

        $this->settings->disableWebhook();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAccessoryNotification::class);
    }

    public function testAccessoryCheckinSendsWebhookNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableWebhook();

        event(new CheckoutableCheckedIn(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckinAccessoryNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testAccessoryCheckinDoesNotSendWebhookNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableWebhook();

        event(new CheckoutableCheckedIn(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAccessoryNotification::class);
    }
}
