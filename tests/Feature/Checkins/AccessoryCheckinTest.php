<?php

namespace Tests\Feature\Checkins;

use App\Events\CheckoutableCheckedIn;
use App\Models\Accessory;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckinAssetNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AccessoryCheckinTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingInAccessoryRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('accessories.checkin.store', Accessory::factory()->checkedOut()->create()))
            ->assertForbidden();
    }

    public function testAccessoryCanBeCheckedIn()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $user = User::factory()->create();
        $accessory = Accessory::factory()->checkedOut($user)->create();

        $this->assertTrue($accessory->users->contains($user));

        $this->actingAs(User::factory()->checkinAccessories()->create())
            ->post(route('accessories.checkin.store', $accessory->users->first()->pivot->id));

        $this->assertFalse($accessory->fresh()->users->contains($user));

        Event::assertDispatched(CheckoutableCheckedIn::class, 1);
    }

    public function testEmailSentToUserIfSettingEnabled()
    {
        Notification::fake();

        $user = User::factory()->create();
        $accessory = Accessory::factory()->checkedOut($user)->create();

        $accessory->category->update(['checkin_email' => true]);

        event(new CheckoutableCheckedIn(
            $accessory,
            $user,
            User::factory()->checkinAccessories()->create(),
            '',
        ));

        Notification::assertSentTo(
            [$user],
            function (CheckinAccessoryNotification $notification, $channels) {
                return in_array('mail', $channels);
            },
        );
    }

    public function testEmailNotSentToUserIfSettingDisabled()
    {
        Notification::fake();

        $user = User::factory()->create();
        $accessory = Accessory::factory()->checkedOut($user)->create();

        $accessory->category->update(['checkin_email' => false]);

        event(new CheckoutableCheckedIn(
            $accessory,
            $user,
            User::factory()->checkinAccessories()->create(),
            '',
        ));

        Notification::assertNotSentTo(
            [$user],
            function (CheckinAccessoryNotification $notification, $channels) {
                return in_array('mail', $channels);
            },
        );
    }
}