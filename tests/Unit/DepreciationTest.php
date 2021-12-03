<?php
namespace Tests\Unit;

use App\Models\Depreciation;
use Tests\Unit\BaseTest;
use App\Models\Category;
use App\Models\License;
use App\Models\AssetModel;

class DepreciationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;



    public function testADepreciationHasModels()
    {
        $this->createValidAssetModel();
        $depreciation = Depreciation::factory()->create();

        AssetModel::factory()
                    ->mbp13Model()
                    ->count(5)
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory(),
                            'depreciation_id' => $depreciation->id               
                        ]);


        $this->assertEquals(5, $depreciation->models->count());
    }

    public function testADepreciationHasLicenses()
    {

        $depreciation = Depreciation::factory()->create();
        License::factory()
                    ->count(5)
                    ->photoshop()
                    ->create(
                        [
                            'category_id' => Category::factory()->licenseGraphicsCategory(),
                            'depreciation_id' => $depreciation->id               
                        ]);

        $this->assertEquals(5, $depreciation->licenses()->count());
    }
}
