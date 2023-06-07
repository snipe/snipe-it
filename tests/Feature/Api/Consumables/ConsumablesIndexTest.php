<?php

namespace Tests\Feature\Api\Consumables;

use App\Models\Company;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ConsumablesIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testConsumableIndexAdheresToCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $consumableA = Consumable::factory()->for($companyA)->create();
        $consumableB = Consumable::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewConsumables()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewConsumables()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContains($response, $consumableA);
        $this->assertResponseContains($response, $consumableB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContains($response, $consumableA);
        $this->assertResponseContains($response, $consumableB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContains($response, $consumableA);
        $this->assertResponseContains($response, $consumableB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContains($response, $consumableA);
        $this->assertResponseContains($response, $consumableB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContains($response, $consumableA);
        $this->assertResponseDoesNotContain($response, $consumableB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseDoesNotContain($response, $consumableA);
        $this->assertResponseContains($response, $consumableB);
    }

    private function assertResponseContains(TestResponse $response, Consumable $consumable)
    {
        $this->assertTrue(collect($response['rows'])->pluck('name')->contains($consumable->name));
    }

    private function assertResponseDoesNotContain(TestResponse $response, Consumable $consumable)
    {
        $this->assertFalse(collect($response['rows'])->pluck('name')->contains($consumable->name));
    }
}
