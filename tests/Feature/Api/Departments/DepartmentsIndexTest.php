<?php

namespace Tests\Feature\Api\Departments;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DepartmentsIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testDepartmentsIndexAdheresToCompanyScoping()
    {
        $this->markTestIncomplete(
            'Waiting for removal of Company::scopeCompanyables in DepartmentsController@index'
        );

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $departmentA = Department::factory()->for($companyA)->create();
        $departmentB = Department::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewDepartments()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewDepartments()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $this->getJson(route('api.departments.index'))
            ->assertResponseContainsInRows($departmentA)
            ->assertResponseContainsInRows($departmentB);

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.departments.index'))
            ->assertResponseContainsInRows($departmentA)
            ->assertResponseContainsInRows($departmentB);

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.departments.index'))
            ->assertResponseContainsInRows($departmentA)
            ->assertResponseContainsInRows($departmentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $this->getJson(route('api.departments.index'))
            ->assertResponseContainsInRows($departmentA)
            ->assertResponseContainsInRows($departmentB);

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.departments.index'))
            ->assertResponseContainsInRows($departmentA)
            ->assertResponseDoesNotContainInRows($departmentB);

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.departments.index'))
            ->assertResponseDoesNotContainInRows($departmentA)
            ->assertResponseContainsInRows($departmentB);
    }
}
