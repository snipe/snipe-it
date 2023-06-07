<?php

namespace Tests\Feature\Api\Components;

use App\Models\Company;
use App\Models\Component;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ComponentIndexTest extends TestCase
{
    use InteractsWithResponses;
    use InteractsWithSettings;

    public function testComponentIndexAdheresToCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $componentA = Component::factory()->for($companyA)->create();
        $componentB = Component::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewComponents()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewComponents()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->sendRequest();
        $this->assertResponseContainsInRows($response, $componentA);
        $this->assertResponseContainsInRows($response, $componentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->sendRequest();
        $this->assertResponseContainsInRows($response, $componentA);
        $this->assertResponseContainsInRows($response, $componentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->sendRequest();
        $this->assertResponseContainsInRows($response, $componentA);
        $this->assertResponseContainsInRows($response, $componentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->sendRequest();
        $this->assertResponseContainsInRows($response, $componentA);
        $this->assertResponseContainsInRows($response, $componentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->sendRequest();
        $this->assertResponseContainsInRows($response, $componentA);
        $this->assertResponseDoesNotContainInRows($response, $componentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->sendRequest();
        $this->assertResponseDoesNotContainInRows($response, $componentA);
        $this->assertResponseContainsInRows($response, $componentB);
    }

    private function sendRequest(): TestResponse
    {
        return $this->getJson(route('api.components.index'));
    }
}
