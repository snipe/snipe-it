<?php

namespace Tests\Feature\Api\Licenses;

use App\Models\Company;
use App\Models\License;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class LicensesIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testLicensesIndexAdheresToCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $licenseA = License::factory()->for($companyA)->create();
        $licenseB = License::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewLicenses()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewLicenses()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContains($response, $licenseA);
        $this->assertResponseContains($response, $licenseB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContains($response, $licenseA);
        $this->assertResponseContains($response, $licenseB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContains($response, $licenseA);
        $this->assertResponseContains($response, $licenseB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContains($response, $licenseA);
        $this->assertResponseContains($response, $licenseB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContains($response, $licenseA);
        $this->assertResponseDoesNotContain($response, $licenseB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseDoesNotContain($response, $licenseA);
        $this->assertResponseContains($response, $licenseB);
    }

    private function assertResponseContains(TestResponse $response, License $license)
    {
        $this->assertTrue(collect($response['rows'])->pluck('name')->contains($license->name));
    }

    private function assertResponseDoesNotContain(TestResponse $response, License $license)
    {
        $this->assertFalse(collect($response['rows'])->pluck('name')->contains($license->name));
    }
}
