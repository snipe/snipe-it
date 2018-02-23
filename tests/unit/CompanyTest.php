<?php
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testCompanyAdd()
    // {
    //     $company = factory(Company::class)->make();
    //     $values = [
    //     'name' => $company->name,
    //     ];

    //     Company::create($values);
    //     $this->tester->seeRecord('companies', $values);
    // }

    // public function testFailsEmptyValidation()
    // {
    //    // An Company requires a name, a qty, and a category_id.
    //     $a = Company::create();
    //     $this->assertFalse($a->isValid());

    //     $fields = [
    //         'name' => 'name',
    //     ];
    //     $errors = $a->getErrors();
    //     foreach ($fields as $field => $fieldTitle) {
    //         $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
    //     }
    // }

    // public function testACompanyCanHaveUsers()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\User::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->users);
    // }

    // public function testACompanyCanHaveAssets()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\Asset::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->assets);
    // }

    // public function testACompanyCanHaveLicenses()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\License::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->licenses);
    // }

    // public function testACompanyCanHaveAccessories()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\Accessory::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->accessories);
    // }

    // public function testACompanyCanHaveConsumables()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\Consumable::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->consumables);
    // }

    // public function testACompanyCanHaveComponents()
    // {
    //     $company = factory(Company::class)->create();
    //     factory(App\Models\Component::class, 1)->create(['company_id'=>$company->id]);
    //     $this->assertCount(1, $company->components);
    // }
}
