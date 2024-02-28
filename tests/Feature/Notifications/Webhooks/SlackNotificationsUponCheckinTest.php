<?php

namespace Tests\Feature\Notifications\Webhooks;

use App\Events\CheckoutableCheckedIn;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SlackNotificationsUponCheckinTest extends TestCase
{
    use InteractsWithSettings;

    public function testAccessoryCheckinSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

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

    public function testAccessoryCheckinDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAccessoryNotification::class);
    }

    public function testComponentCheckinDoesNotSendSlackNotification()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }

    public function testConsumableCheckinSendSlackNotificationWhenSettingEnabled()
    {
        $this->markTestIncomplete();
    }

    public function testConsumableCheckinDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        $this->markTestIncomplete();
    }
}
