<?php
namespace Tests\Unit;

use App\Models\Depreciation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

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
        $models = \App\Models\AssetModel::factory()->count(5)->mbp13Model()->create(['depreciation_id'=>$depreciation->id]);
        $this->assertEquals(5, $depreciation->models->count());
    }

    public function testADepreciationHasLicenses()
    {
        $category = $this->createValidCategory('license-graphics-category');
        $depreciation = $this->createValidDepreciation('computer', ['name' => 'New Depreciation']);
        $licenses = \App\Models\License::factory()->count(5)->photoshop()->create([
             'depreciation_id'=>$depreciation->id,
             'category_id' => $category->id,
         ]);

        $this->assertEquals(5, $depreciation->licenses()->count());
    }
}
