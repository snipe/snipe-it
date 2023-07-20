<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedOut;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutConsumableNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ConsumableWebhookTest extends TestCase
{
    use InteractsWithSettings;

    public function testConsumableCheckoutSendsWebhookNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableWebhook();

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

    public function testConsumableCheckoutDoesNotSendWebhookNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableWebhook();

        event(new CheckoutableCheckedOut(
            Consumable::factory()->cardstock()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutConsumableNotification::class);
    }
}
