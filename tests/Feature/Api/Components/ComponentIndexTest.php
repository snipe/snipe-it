<?php

namespace Tests\Feature\Api\Components;

use App\Models\Company;
use App\Models\Component;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ComponentIndexTest extends TestCase
{
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
        $this->assertResponseContains($response, $componentA);
        $this->assertResponseContains($response, $componentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->sendRequest();
        $this->assertResponseContains($response, $componentA);
        $this->assertResponseContains($response, $componentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->sendRequest();
        $this->assertResponseContains($response, $componentA);
        $this->assertResponseContains($response, $componentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->sendRequest();
        $this->assertResponseContains($response, $componentA);
        $this->assertResponseContains($response, $componentB);

        Passport::actingAs($userInCompanyA);
        $response = $this->sendRequest();
        $this->assertResponseContains($response, $componentA);
        $this->assertResponseDoesNotContain($response, $componentB);

        Passport::actingAs($userInCompanyB);
        $response = $this->sendRequest();
        $this->assertResponseDoesNotContain($response, $componentA);
        $this->assertResponseContains($response, $componentB);
    }

    private function sendRequest(): TestResponse
    {
        return $this->getJson(route('api.components.index'));
    }

    private function assertResponseContains(TestResponse $response, Component $component)
    {
        $this->assertTrue(collect($response['rows'])->pluck('name')->contains($component->name));
    }

    private function assertResponseDoesNotContain(TestResponse $response, Component $component)
    {
        $this->assertFalse(collect($response['rows'])->pluck('name')->contains($component->name));
    }
}
