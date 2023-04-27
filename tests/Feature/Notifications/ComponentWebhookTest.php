<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedIn;
use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\Component;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ComponentWebhookTest extends TestCase
{

    use InteractsWithSettings;

    public function testComponentCheckoutDoesNotSendWebhookNotification()
    {
        Notification::fake();

        $this->settings->enableWebhook();

        event(new CheckoutableCheckedOut(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }

    public function testComponentCheckinDoesNotSendWebhookNotification()
    {
        Notification::fake();

        $this->settings->enableWebhook();

        event(new CheckoutableCheckedIn(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }
}
