<?php

namespace Tests\Feature\Api\Departments;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DepartmentsIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testDepartmentsIndexAdheresToCompanyScoping()
    {
        $this->markTestIncomplete();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $departmentA = Department::factory()->for($companyA)->create();
        $departmentB = Department::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewDepartments()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewDepartments()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContains($response, $departmentA);
        $this->assertResponseContains($response, $departmentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContains($response, $departmentA);
        $this->assertResponseContains($response, $departmentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContains($response, $departmentA);
        $this->assertResponseContains($response, $departmentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContains($response, $departmentA);
        $this->assertResponseContains($response, $departmentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseContains($response, $departmentA);
        $this->assertResponseDoesNotContain($response, $departmentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.departments.index'));
        $this->assertResponseDoesNotContain($response, $departmentA);
        $this->assertResponseContains($response, $departmentB);
    }

    private function assertResponseContains(TestResponse $response, Department $department)
    {
        $this->assertTrue(collect($response['rows'])->pluck('name')->contains($department->name));
    }

    private function assertResponseDoesNotContain(TestResponse $response, Department $department)
    {
        $this->assertFalse(collect($response['rows'])->pluck('name')->contains($department->name));
    }
}
