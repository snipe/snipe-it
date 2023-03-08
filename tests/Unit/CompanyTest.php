<?php
namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Component;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    public function testACompanyCanHaveUsers()
    {
        $company = Company::factory()->create();
        $user = User::factory()
                ->create(
                    [
                        'company_id'=> $company->id
                    ]
        );

        $this->assertCount(1, $company->users);
    }
}
