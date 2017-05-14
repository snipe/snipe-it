<?php
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $company;
    use DatabaseMigrations;

    protected function _before()
    {
        Artisan::call('migrate');

        $this->company = factory(Company::class)->create();
    }

    public function testAssetAdd()
    {
        $company = factory(Company::class)->make();
        $values = [
        'name' => $company->name,
        ];

        Company::create($values);
        $this->tester->seeRecord('companies', $values);
    }

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
        $this->company = factory(Company::class)->create();
        factory(App\Models\User::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->users);
    }

    public function testACompanyCanHaveAssets()
    {
        $this->company = factory(Company::class)->create();
        factory(App\Models\Asset::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->assets);
    }

    public function testACompanyCanHaveLicenses()
    {
        $this->company = factory(Company::class)->create();
        factory(App\Models\License::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->licenses);
    }

    public function testACompanyCanHaveAccessories()
    {
        $this->company = factory(Company::class)->create();
        factory(App\Models\Accessory::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->accessories);
    }

    public function testACompanyCanHaveConsumables()
    {
        $this->company = factory(Company::class)->create();
        factory(App\Models\Consumable::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->consumables);
    }

    public function testACompanyCanHaveComponents()
    {
        $this->company = factory(Company::class)->create();
        factory(App\Models\Component::class, 1)->create(['company_id'=>$this->company->id]);
        $this->assertCount(1, $this->company->components);
    }
}
