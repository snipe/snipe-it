<?php

namespace Tests\Feature\Notifications\Email;

use App\Events\CheckoutableCheckedOut;
use App\Mail\CheckinAssetMail;
use App\Mail\CheckoutAssetMail;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('notifications')]
class EmailNotificationsUponCheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    public function testAdminCCEmailStillSentWhenCategoryEmailIsNotSetToSendEmailToUser()
    {
        $this->settings->enableAdminCC('cc@example.com');

        $category = Category::factory()->create(['checkin_email' => false]);
        $assetModel = AssetModel::factory()->create(['category_id' => $category->id]);
        $asset = Asset::factory()->create(['model_id' => $assetModel->id]);

        event(new CheckoutableCheckedOut(
            $asset,
            User::factory()->create(),
            User::factory()->superuser()->create(),
            '',
        ));

        Mail::assertSent(CheckoutAssetMail::class, function ($mail) {
            return $mail->hasTo('cc@example.com');
        });
    }
}
