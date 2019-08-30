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
         factory(App\Models\User::class, 1)->create(['company_id'=>$company->id]);
         $this->assertCount(1, $company->users);
     }

     public function testACompanyCanHaveAssets()
     {
         $company = $this->createValidCompany();
         factory(App\Models\Asset::class, 1)->states('laptop-mbp')->create([
            'company_id' => $company->id,
            'model_id' => $this->createValidAssetModel()->id
         ]);
         $this->assertCount(1, $company->assets);
     }

     public function testACompanyCanHaveLicenses()
     {
         $company = $this->createValidCompany();
         factory(App\Models\License::class, 1)->states('acrobat')->create([
             'company_id'=>$company->id,
             'manufacturer_id' => factory(App\Models\Manufacturer::class)->states('adobe')->create()->id,
             'category_id' => factory(App\Models\Category::class)->states('license-office-category')->create()->id
         ]);
         $this->assertCount(1, $company->licenses);
     }

     public function testACompanyCanHaveAccessories()
     {
         $company = $this->createValidCompany();
         $a = factory(App\Models\Accessory::class)->states('apple-bt-keyboard')->create([
             'category_id' => factory(App\Models\Category::class)->states('accessory-keyboard-category')->create()->id,
             'company_id' => $company->id
         ]);

         $this->assertCount(1, $company->accessories);
     }

     public function testACompanyCanHaveConsumables()
     {
         $company = $this->createValidCompany();
         factory(App\Models\Consumable::class, 1)->states('cardstock')->create([
             'company_id' => $company->id,
             'category_id' => factory(App\Models\Category::class)->states('consumable-paper-category')->create()->id
         ]);
         $this->assertCount(1, $company->consumables);
     }

     public function testACompanyCanHaveComponents()
     {
         $company = $this->createValidCompany();
         factory(App\Models\Component::class, 1)->states('ram-crucial4')->create([
             'company_id'=>$company->id,
             'category_id' => factory(App\Models\Category::class)->states('component-ram-category')->create()->id
         ]);
         $this->assertCount(1, $company->components);
     }
}
