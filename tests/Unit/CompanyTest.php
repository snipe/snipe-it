<?php
namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;
use App\Models\Component;
use App\Models\Asset;
use App\Models\Consumable;

class CompanyTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testFailsEmptyValidation()
    {
        // An Company requires a name, a qty, and a category_id.
        $company = Company::factory()->assetDesktopCategory()->create();
        $this->assertFalse($company->isValid());

        $fields = [
             'name' => 'name',
         ];
        $errors = $company->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
        }
    }

    public function testACompanyCanHaveUsers()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        $user = $this->createValidUser(['company_id'=>$company->id]);
        $this->assertCount(1, $company->users);
    }

    public function testACompanyCanHaveAssets()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        $this->createValidAsset(['company_id' => $company->id]);
        $this->assertCount(1, $company->assets);
    }

    public function testACompanyCanHaveLicenses()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        \App\Models\License::factory()->count(1)->acrobat()->create([
             'company_id'=>$company->id,
             'manufacturer_id' => \App\Models\Manufacturer::factory()->adobe()->create()->id,
             'category_id' => \App\Models\Category::factory()->licenseOfficeCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->licenses);
    }

    public function testACompanyCanHaveAccessories()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        $a = \App\Models\Accessory::factory()->appleBtKeyboard()->create([
             'category_id' => \App\Models\Category::factory()->accessoryKeyboardCategory()->create()->id,
             'company_id' => $company->id,
         ]);

        $this->assertCount(1, $company->accessories);
    }

    public function testACompanyCanHaveConsumables()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        \App\Models\Consumable::factory()->count(1)->cardstock()->create([
             'company_id' => $company->id,
             'category_id' => \App\Models\Category::factory()->consumablePaperCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->consumables);
    }

    public function testACompanyCanHaveComponents()
    {
        $company = Company::factory()->assetDesktopCategory()->create();
        Component::factory()->count(1)->ramCrucial4()->create([
             'company_id'=>$company->id,
             'category_id' => \App\Models\Category::factory()->componentRamCategory()->create()->id,
         ]);
        $this->assertCount(1, $company->components);
    }
}
