<?php

namespace Tests\Feature\Api\Consumables;

use App\Models\Company;
use App\Models\Consumable;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ConsumablesIndexTest extends TestCase
{
    use InteractsWithResponses;
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
        $this->assertResponseContainsInRows($response, $consumableA);
        $this->assertResponseContainsInRows($response, $consumableB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContainsInRows($response, $consumableA);
        $this->assertResponseContainsInRows($response, $consumableB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContainsInRows($response, $consumableA);
        $this->assertResponseContainsInRows($response, $consumableB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContainsInRows($response, $consumableA);
        $this->assertResponseContainsInRows($response, $consumableB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseContainsInRows($response, $consumableA);
        $this->assertResponseDoesNotContainInRows($response, $consumableB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.consumables.index'));
        $this->assertResponseDoesNotContainInRows($response, $consumableA);
        $this->assertResponseContainsInRows($response, $consumableB);
    }
}
