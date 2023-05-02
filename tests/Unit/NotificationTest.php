<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use Carbon\Carbon;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use InteractsWithSettings;

    public function testAUserIsEmailedIfTheyCheckoutAnAssetWithEULA()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create();
        $asset = Asset::factory()
        ->create(
            [
                'model_id' => AssetModel::factory()
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory()->create()->id
                        ]
                )->id,
                'warranty_months' => 24,
                'purchase_date' =>   Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0)->format('Y-m-d')
            ]);

        Notification::fake();
        $asset->checkOut($user, $admin->id);
        Notification::assertSentTo($user, CheckoutAssetNotification::class);
    }
}
