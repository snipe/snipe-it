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
    use DatabaseMigrations;

    public function testAssetAdd()
    {
      $company = factory(Company::class, 'company')->make();
      $values = [
        'name' => $company->name,
      ];

      Company::create($values);
      $this->tester->seeRecord('companies', $values);
    }

}
