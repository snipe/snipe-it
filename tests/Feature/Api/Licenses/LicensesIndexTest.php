<?php

namespace Tests\Feature\Api\Licenses;

use App\Models\Company;
use App\Models\License;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class LicensesIndexTest extends TestCase
{
    use InteractsWithResponses;
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
        $this->assertResponseContainsInRows($response, $licenseA);
        $this->assertResponseContainsInRows($response, $licenseB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContainsInRows($response, $licenseA);
        $this->assertResponseContainsInRows($response, $licenseB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContainsInRows($response, $licenseA);
        $this->assertResponseContainsInRows($response, $licenseB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContainsInRows($response, $licenseA);
        $this->assertResponseContainsInRows($response, $licenseB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseContainsInRows($response, $licenseA);
        $this->assertResponseDoesNotContainInRows($response, $licenseB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.licenses.index'));
        $this->assertResponseDoesNotContainInRows($response, $licenseA);
        $this->assertResponseContainsInRows($response, $licenseB);
    }
}
