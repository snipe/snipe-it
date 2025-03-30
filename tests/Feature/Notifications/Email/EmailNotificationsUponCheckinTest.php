<?php

namespace Tests\Feature\Notifications\Email;

use App\Mail\CheckinAssetMail;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Group;
use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CheckinAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

#[Group('notifications')]
class EmailNotificationsUponCheckinTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    public function testCheckInEmailSentToUserIfSettingEnabled()
    {
        Mail::fake();

        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkin_email' => true]);

        $this->fireCheckInEvent($asset, $user);

        Mail::assertSent(CheckinAssetMail::class, function($mail) use ($user) {
                return $mail->hasTo($user->email);
        });

    }

    public function testCheckInEmailNotSentToUserIfSettingDisabled()
    {
        Mail::fake();

        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update([
            'checkin_email' => false,
            'eula_text' => null,
            'require_acceptance' => false,
        ]);

        $this->fireCheckInEvent($asset, $user);

        Mail::assertNotSent(CheckinAssetMail::class, function($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }

    private function fireCheckInEvent($asset, $user): void
    {
        event(new CheckoutableCheckedIn(
            $asset,
            $user,
            User::factory()->checkinAssets()->create(),
            ''
        ));
    }
}
