<?php
use App\Models\Asset;
use App\Models\AssetModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class AssetModelTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testAssetModelAdd()
    // {
    //     $assetmodel = factory(AssetModel::class)->make();
    //     $values = [
    //     'name' => $assetmodel->name,
    //     'manufacturer_id' => $assetmodel->manufacturer_id,
    //     'category_id' => $assetmodel->category_id,
    //     'eol' => $assetmodel->eol,
    //     ];

    //     AssetModel::create($values);
    //     $this->tester->seeRecord('models', $values);
    // }

    // public function testAnAssetModelRequiresAttributes()
    // {
    //     // An Asset Model requires a name, a category_id, and a manufacturer_id.
    //     $a = AssetModel::create();
    //     $this->assertFalse($a->isValid());
    //     $fields = [
    //         'name' => 'name',
    //         'manufacturer_id' => 'manufacturer id',
    //         'category_id' => 'category id'
    //     ];
    //     $errors = $a->getErrors();
    //     foreach ($fields as $field => $fieldTitle) {
    //         $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
    //     }
    // }

    // public function testAnAssetModelZerosOutBlankEols()
    // {
    //     $am = new AssetModel;
    //     $am->eol = '';
    //     $this->assertTrue($am->eol === 0);
    //     $am->eol = '4';
    //     $this->assertTrue($am->eol==4);
    // }

    // public function testAnAssetModelContainsAssets()
    // {
    //     $assetmodel = factory(AssetModel::class)->create();
    //     $asset = factory(Asset::class)->create([
    //         'model_id' => $assetmodel->id,
    //     ]);
    //     $this->assertEquals(1,$assetmodel->assets()->count());
    // }

    // public function testAnAssetModelHasACategory()
    // {
    //     $assetmodel = factory(AssetModel::class)->create();
    //     $this->assertInstanceOf(App\Models\Category::class, $assetmodel->category);
    // }

    // public function anAssetModelHasADepreciation()
    // {
    //     $assetmodel = factory(AssetModel::class)->create();
    //     $this->assertInstanceOf(App\Models\Depreciation::class, $assetmodel->depreciation);
    // }

    // public function testAnAssetModelHasAManufacturer()
    // {
    //     $assetmodel = factory(AssetModel::class)->create();
    //     $this->assertInstanceOf(App\Models\Manufacturer::class, $assetmodel->manufacturer);
    // }
}
