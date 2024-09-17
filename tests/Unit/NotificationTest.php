<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use Carbon\Carbon;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
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
    public function testDefaultEulaIsSentWhenSetInCategory()
    {
        Notification::fake();

        $this->settings->setEula('My Custom EULA Text');

        $user = User::factory()->create();

        $category = Category::factory()->create([
            'use_default_eula' => 1,
            'eula_text' => 'EULA Text that should not be used',
        ]);

        $model = AssetModel::factory()->for($category)->create();
        $asset = Asset::factory()->for($model, 'model')->create();

        $asset->checkOut($user, User::factory()->superuser()->create()->id);

        Notification::assertSentTo($user, CheckoutAssetNotification::class, function ($notification) {
            $content = $notification->toMail()->render();

            return str_contains($content, 'My Custom EULA Text') && !str_contains($content, 'EULA Text that should not be used');
        });
    }
}
