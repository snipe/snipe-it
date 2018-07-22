<?php
use App\Models\Depreciation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepreciationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

     public function testFailsEmptyValidation()
     {
        // An Asset requires a name, a qty, and a category_id.
         $a = Depreciation::create();
         $this->assertFalse($a->isValid());

         $fields = [
             'name' => 'name',
             'months' => 'months',
         ];
         $errors = $a->getErrors();
         foreach ($fields as $field => $fieldTitle) {
             $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
         }
     }

     public function testADepreciationHasModels()
     {
         $this->createValidAssetModel();
         $depreciation = $this->createValidDepreciation('computer', ['name' => 'New Depreciation']);
         $models = factory(App\Models\AssetModel::class, 5)->states('mbp-13-model')->create(['depreciation_id'=>$depreciation->id]);
         $this->assertEquals(5,$depreciation->has_models());
     }

     public function testADepreciationHasLicenses()
     {
         $category = $this->createValidCategory('license-graphics-category');
         $depreciation = $this->createValidDepreciation('computer', ['name' => 'New Depreciation']);
         $licenses = factory(App\Models\License::class, 5)->states('photoshop')->create([
             'depreciation_id'=>$depreciation->id,
             'category_id' => $category->id
         ]);

         $this->assertEquals(5,$depreciation->has_licenses());
     }
}
