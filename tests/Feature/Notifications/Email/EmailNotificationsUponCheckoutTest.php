<?php

namespace Tests\Feature\Notifications\Email;

use App\Events\CheckoutableCheckedOut;
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
    private Asset $asset;
    private AssetModel $assetModel;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->category = Category::factory()->create([
            'checkin_email' => false,
            'eula_text' => null,
            'require_acceptance' => false,
            'use_default_eula' => false,
        ]);

        $this->assetModel = AssetModel::factory()->for($this->category)->create();
        $this->asset = Asset::factory()->for($this->assetModel, 'model')->create();
    }

    public function test_email_sent_to_user_when_category_requires_acceptance()
    {
        $this->markTestIncomplete();

        // require_acceptance = true
    }

    public function test_email_sent_to_user_when_category_using_default_eula()
    {
        $this->markTestIncomplete();
    }

    public function test_email_sent_to_user_when_category_using_local_eula()
    {
        $this->markTestIncomplete();
    }

    public function test_email_sent_to_user_when_category_set_to_explicitly_send_email()
    {
        $this->markTestIncomplete();

        // checkin_email = true
    }

    public function test_admin_cc_email_still_sent_when_category_email_is_not_set_to_send_email_to_user()
    {
        $this->settings->enableAdminCC('cc@example.com');

        $category = Category::factory()->create([
            'checkin_email' => false,
            'eula_text' => null,
            'use_default_eula' => false,
        ]);
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
