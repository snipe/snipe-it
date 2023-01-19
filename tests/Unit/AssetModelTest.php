<?php
namespace Tests\Unit;

use App\Models\Asset;
use App\Models\Category;
use App\Models\AssetModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class AssetModelTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAnAssetModelZerosOutBlankEols()
    {
        $am = new AssetModel;
        $am->eol = '';
        $this->assertTrue($am->eol === 0);
        $am->eol = '4';
        $this->assertTrue($am->eol == 4);
    }

    public function testAnAssetModelContainsAssets()
    {
        $category = Category::factory()->create(
            ['category_type' => 'asset']
        );
        $model = AssetModel::factory()->create([
            'category_id' => $category->id,
        ]);
    
        $asset = Asset::factory()
            ->create(
                [
                    'model_id' => $model->id
                ]
            );
        $this->assertEquals(1, $model->assets()->count());
    }


}
