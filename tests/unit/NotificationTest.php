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

    // public function testAUserIsEmailedIfTheyCheckoutAnAssetWithEULA()
    // {
    //     $admin = factory(User::class)->states('superuser')->create();
    //     Auth::login($admin);
    //     $cat = factory(Category::class)->states('asset-category', 'requires-acceptance')->create();
    //     $model = factory(AssetModel::class)->create(['category_id' => $cat->id]);
    //     $asset = factory(Asset::class)->create(['model_id' => $model->id]);

    //     $user = factory(User::class)->create();
    //     Notification::fake();
    //     $asset->checkOut($user, 1);

    //     Notification::assertSentTo($user, CheckoutNotification::class);
    // }

    // public function testAnAssetRequiringAEulaDoesNotExplodeWhenCheckedOutToALocation()
    // {
    //     $this->signIn();
    //     $asset = factory(Asset::class)->states('requires-acceptance')->create();

    //     $this->expectException(CheckoutNotAllowed::class);
    //     $location = factory(Location::class)->create();
    //     Notification::fake();
    //     $asset->checkOut($location, 1);

    //     Notification::assertNotSentTo($location, CheckoutNotification::class);
    // }
}
