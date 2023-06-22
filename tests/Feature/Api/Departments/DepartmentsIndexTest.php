<?php

namespace Tests\Feature\Api\Departments;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DepartmentsIndexTest extends TestCase
{
    use InteractsWithResponses;
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
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContainsInRows($response, $departmentA);
        $this->assertResponseContainsInRows($response, $departmentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContainsInRows($response, $departmentA);
        $this->assertResponseContainsInRows($response, $departmentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContainsInRows($response, $departmentA);
        $this->assertResponseContainsInRows($response, $departmentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContainsInRows($response, $departmentA);
        $this->assertResponseContainsInRows($response, $departmentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContainsInRows($response, $departmentA);
        $this->assertResponseDoesNotContainInRows($response, $departmentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseDoesNotContainInRows($response, $departmentA);
        $this->assertResponseContainsInRows($response, $departmentB);
    }
}
