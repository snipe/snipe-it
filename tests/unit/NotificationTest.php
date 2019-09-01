<?php
use App\Exceptions\CheckoutNotAllowed;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class NotificationTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

     public function testAUserIsEmailedIfTheyCheckoutAnAssetWithEULA()
     {
         $admin = factory(User::class)->states('superuser')->create();
         Auth::login($admin);
         $cat = $this->createValidCategory('asset-laptop-category', ['require_acceptance' => true]);
         $model = $this->createValidAssetModel('mbp-13-model', ['category_id' => $cat->id]);
         $asset = $this->createValidAsset(['model_id' => $model->id]);
         $user = factory(User::class)->create();
         Notification::fake();
         $asset->checkOut($user, 1);

         Notification::assertSentTo($user, CheckoutAssetNotification::class);
     }
}
