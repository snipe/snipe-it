<?php
namespace Tests\Unit;

use App\Models\Depreciation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;
use App\Models\Category;
use Carbon;
use App\Models\License;

class DepreciationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;



    public function testADepreciationHasModels()
    {
        $this->createValidAssetModel();
        $depreciation = $this->createValidDepreciation('computer', ['name' => 'New Depreciation']);
        $models = \App\Models\AssetModel::factory()->count(5)->mbp13Model()->create(['depreciation_id'=>$depreciation->id]);
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
