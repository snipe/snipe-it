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

    // public function testDepreciationAdd()
    // {
    //   $depreciations = factory(Depreciation::class)->make();
    //   $values = [
    //     'name' => $depreciations->name,
    //     'months' => $depreciations->months,
    //   ];

    //   Depreciation::create($values);
    //   $this->tester->seeRecord('depreciations', $values);
    // }

    // public function testFailsEmptyValidation()
    // {
    //    // An Asset requires a name, a qty, and a category_id.
    //     $a = Depreciation::create();
    //     $this->assertFalse($a->isValid());

    //     $fields = [
    //         'name' => 'name',
    //         'months' => 'months',
    //     ];
    //     $errors = $a->getErrors();
    //     foreach ($fields as $field => $fieldTitle) {
    //         $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
    //     }
    // }

    // public function testADepreciationHasModels()
    // {
    //     $depreciation = factory(Depreciation::class)->create();
    //     factory(App\Models\AssetModel::class, 5)->create(['depreciation_id'=>$depreciation->id]);
    //     $this->assertEquals(5,$depreciation->has_models());
    // }

    // public function testADepreciationHasLicenses()
    // {
    //     $depreciation = factory(Depreciation::class)->create();
    //     factory(App\Models\License::class, 5)->create(['depreciation_id'=>$depreciation->id]);
    //     $this->assertEquals(5,$depreciation->has_licenses());
    // }
}
