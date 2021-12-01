<?php
namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\BaseTest;

class CompanyTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testFailsEmptyValidation()
    {
        // An Company requires a name, a qty, and a category_id.
        $a = Company::create();
        $this->assertFalse($a->isValid());

        $fields = [
             'name' => 'name',
         ];
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
        }
    }

    public function testACompanyCanHaveUsers()
    {
        $company = $this->createValidCompany();
        $user = $this->createValidUser(['company_id'=>$company->id]);
        $this->assertCount(1, $company->users);
    }

    public function testACompanyCanHaveAssets()
    {
        $company = $this->createValidCompany();
        $this->createValidAsset(['company_id' => $company->id]);
        $this->assertCount(1, $company->assets);
    }

    public function testACompanyCanHaveLicenses()
    {
        $company = $this->createValidCompany();
        \App\Models\License::factory()->count(1)->acrobat()->create([
             'company_id'=>$company->id,
             'manufacturer_id' => \App\Models\Manufacturer::factory()->adobe()->create()->id,
             'category_id' => \App\Models\Category::factory()->licenseOfficeCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->licenses);
    }

    public function testACompanyCanHaveAccessories()
    {
        $company = $this->createValidCompany();
        $a = \App\Models\Accessory::factory()->appleBtKeyboard()->create([
             'category_id' => \App\Models\Category::factory()->accessoryKeyboardCategory()->create()->id,
             'company_id' => $company->id,
         ]);

        $this->assertCount(1, $company->accessories);
    }

    public function testACompanyCanHaveConsumables()
    {
        $company = $this->createValidCompany();
        \App\Models\Consumable::factory()->count(1)->cardstock()->create([
             'company_id' => $company->id,
             'category_id' => \App\Models\Category::factory()->consumablePaperCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->consumables);
    }

    public function testACompanyCanHaveComponents()
    {
        $company = $this->createValidCompany();
        \App\Models\Component::factory()->count(1)->ramCrucial4()->create([
             'company_id'=>$company->id,
             'category_id' => \App\Models\Category::factory()->componentRamCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->components);
    }
}
