<?php

namespace Tests\Unit\Models\Company;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_a_company_can_have_users()
    {
        $company = Company::factory()->create();
        User::factory()->forCompany($company)->create();

        $this->assertCount(1, $company->users);
    }
}
