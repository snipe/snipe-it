<?php

namespace Modules\RentOrders\Tests\Unit;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Modules\RentOrders\Entities\RentOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\RentOrders\System\RentOrderSystem;
use Tests\Unit\BaseTest;

class PersistNewRentOrdersTest extends BaseTest
{
    use RefreshDatabase;

    protected $system;


    protected function setUp(): void
    {
        parent::setUp();
        $this->system = $this->app->make(RentOrderSystem::class);
    }

    public function testCanCreateARestOrders()
    {
        $operatorUser = User::factory()->firstAdmin()->create();
        $aUser = User::factory()->create();

        $model = \App\Models\AssetModel::factory()->create([
            'category_id' => Category::factory()->assetLaptopCategory(),
        ]);

        $asset = $this->createValidAsset(['model_id' => $model->id, 'status_id' => 2, 'assigned_to' => null]);
        $asset2 = $this->createValidAsset(['model_id' => $model->id, 'status_id' => 2, 'assigned_to' => null]);

        $this->system->send($operatorUser->id, $aUser->id, [
            $asset->id,
            $asset2->id,
        ]);

        $this->assertTrue(RentOrder::all()->count() == 1);
        $this->assertTrue(RentOrder::all()->first()->assigned_to == $aUser->id);
        $this->assertTrue(Asset::find($asset->id)->assigned_to == $aUser->id);
        $this->assertTrue(Asset::find($asset2->id)->assigned_to == $aUser->id);
    }
}
