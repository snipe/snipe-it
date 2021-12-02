<?php
namespace Tests\Unit;

use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\Unit\BaseTest;
use Auth;

class NotificationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAUserIsEmailedIfTheyCheckoutAnAssetWithEULA()
    {
        $admin = User::factory()->superuser()->create();
        Auth::login($admin);
        $cat = $this->createValidCategory('asset-laptop-category', ['require_acceptance' => true]);
        $model = $this->createValidAssetModel('mbp-13-model', ['category_id' => $cat->id]);
        $asset = $this->createValidAsset(['model_id' => $model->id]);
        $user = $this->createValidUser();

        Notification::fake();
        $asset->checkOut($user, 1);
        Notification::assertSentTo($user, CheckoutAssetNotification::class);
    }
}
