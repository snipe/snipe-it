<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use Carbon\Carbon;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\Unit\BaseTest;


class NotificationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAUserIsEmailedIfTheyCheckoutAnAssetWithEULA()
    {

        $user = User::factory()->create();
        $asset = Asset::factory()
        ->create(
            [
                'model_id' => AssetModel::factory()
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory()->id
                        ]
                )->id,   
                'warranty_months' => 24,
                'purchase_date' =>   Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0)                  
            ]);

        //dd($asset);
        Notification::fake();
        $asset->checkOut($user, $asset->id);
        Notification::assertSentTo($user, CheckoutAssetNotification::class);
    }
}
