<?php

namespace Tests\Feature\CheckoutAcceptances\Ui;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use App\Notifications\AcceptanceAssetAcceptedNotification;
use App\Notifications\AcceptanceAssetDeclinedNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AccessoryAcceptanceTest extends TestCase
{
    /**
     * This can be absorbed into a bigger test
     */
    public function testUsersNameIsIncludedInAccessoryAcceptedNotification()
    {
        Notification::fake();

        $this->settings->enableAlertEmail();

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for(Accessory::factory()->appleMouse(), 'checkoutable')
            ->create();

        $this->actingAs($acceptance->assignedTo)
            ->post(route('account.store-acceptance', $acceptance), ['asset_acceptance' => 'accepted'])
            ->assertSessionHasNoErrors();

        $this->assertNotNull($acceptance->fresh()->accepted_at);

        Notification::assertSentTo(
            $acceptance,
            function (AcceptanceAssetAcceptedNotification $notification) use ($acceptance) {
                $this->assertStringContainsString(
                    $acceptance->assignedTo->present()->fullName,
                    $notification->toMail()->render()
                );

                return true;
            }
        );
    }

    /**
     * This can be absorbed into a bigger test
     */
    public function testUsersNameIsIncludedInAccessoryDeclinedNotification()
    {
        Notification::fake();

        $this->settings->enableAlertEmail();

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for(Accessory::factory()->appleMouse(), 'checkoutable')
            ->create();

        $this->actingAs($acceptance->assignedTo)
            ->post(route('account.store-acceptance', $acceptance), ['asset_acceptance' => 'declined'])
            ->assertSessionHasNoErrors();

        $this->assertNotNull($acceptance->fresh()->declined_at);

        Notification::assertSentTo(
            $acceptance,
            function (AcceptanceAssetDeclinedNotification $notification) use ($acceptance) {
                $this->assertStringContainsString(
                    $acceptance->assignedTo->present()->fullName,
                    $notification->toMail($acceptance)->render()
                );

                return true;
            }
        );
    }

    public function testUserIsNotAbleToAcceptAnAssetAssignedToADifferentUser()
    {
        Notification::fake();

        $otherUser = User::factory()->create();

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for(Asset::factory()->laptopMbp(), 'checkoutable')
            ->create();

        $this->actingAs($otherUser)
            ->post(route('account.store-acceptance', $acceptance), ['asset_acceptance' => 'accepted'])
            ->assertSessionHas(['error' => trans('admin/users/message.error.incorrect_user_accepted')]);

        $this->assertNull($acceptance->fresh()->accepted_at);
    }
}
