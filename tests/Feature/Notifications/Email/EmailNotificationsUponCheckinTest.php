<?php

namespace Tests\Feature\Notifications\Email;

use App\Mail\CheckinAssetMail;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Group;
use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\User;
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
        $this->settings->disableAdminCC();
        Mail::fake();

        $user = User::factory()->create();
        $checkoutables = collect([
            Asset::factory()->assignedToUser($user)->create(),
            LicenseSeat::factory()->assignedToUser($user)->create(),
            Accessory::factory()->checkedOutToUser($user)->create(),
            Consumable::factory()->checkedOutToUser($user)->create(),
        ]);

        foreach ($checkoutables as $checkoutable) {

            if ($checkoutable instanceof Asset) {
                $checkoutable->model->category->update([
                    'checkin_email' => false,
                    'eula_text' => null,
                    'require_acceptance' => false,
                ]);
                $checkoutable = $checkoutable->fresh(['model.category']);
            }

            if ($checkoutable instanceof Accessory || $checkoutable instanceof Consumable) {
                $checkoutable->category->update([
                    'checkin_email' => false,
                    'eula_text' => null,
                    'require_acceptance' => false,
                ]);
                $checkoutable = $checkoutable->fresh(['category']);
            }

            if ($checkoutable instanceof LicenseSeat) {
                $checkoutable->license->category->update([
                    'checkin_email' => false,
                    'eula_text' => null,
                    'require_acceptance' => false,
                ]);
                $checkoutable = $checkoutable->fresh(['license.category']);
            }

            // Fire event manually
            $this->fireCheckInEvent($checkoutable, $user);
        }

        Mail::assertNotSent(CheckinAssetMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function testAdminCCEmailStillSentWhenCategoryEmailIsNotSetToSendEmailToUser()
    {
        $this->settings->enableAdminCC('cc@example.com');

        $category = Category::factory()->create(['checkin_email' => false]);
        $assetModel = AssetModel::factory()->create(['category_id' => $category->id]);
        $asset = Asset::factory()->create(['model_id' => $assetModel->id]);

        $this->fireCheckInEvent($asset, User::factory()->create());

        Mail::assertSent(CheckinAssetMail::class, function ($mail) {
            return $mail->hasTo('cc@example.com');
        });
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
