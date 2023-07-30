<?php
namespace Tests\Unit;

use App\Models\Depreciation;
use App\Models\Category;
use App\Models\License;
use App\Models\AssetModel;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DepreciationTest extends TestCase
{
    use InteractsWithSettings;

    public function testADepreciationHasModels()
    {
        $depreciation = Depreciation::factory()->create();

        AssetModel::factory()
                    ->mbp13Model()
                    ->count(5)
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory()->create(),
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
                            'category_id' => Category::factory()->licenseGraphicsCategory()->create(),
                            'depreciation_id' => $depreciation->id               
                        ]);

        $this->assertEquals(5, $depreciation->licenses()->count());
    }
}
