<?php

namespace Tests\Feature\Notifications\Webhooks;

use App\Events\CheckoutableCheckedOut;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutConsumableNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SlackNotificationsUponCheckoutTest extends TestCase
{
    use InteractsWithSettings;

    public function testAccessoryCheckoutSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

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

    public function testAccessoryCheckoutDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAccessoryNotification::class);
    }

    public function testComponentCheckoutDoesNotSendSlackNotification()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }

    public function testConsumableCheckoutSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Consumable::factory()->cardstock()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutConsumableNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testConsumableCheckoutDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Consumable::factory()->cardstock()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutConsumableNotification::class);
    }
}
