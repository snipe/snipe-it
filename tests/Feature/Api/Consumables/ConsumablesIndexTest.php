<?php

namespace Tests\Feature\Api\Consumables;

use App\Models\Company;
use App\Models\Consumable;
use App\Models\User;
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

        $this->actingAsForApi($superUser)
            ->getJson(route('api.consumables.index'))
            ->assertResponseContainsInRows($consumableA)
            ->assertResponseContainsInRows($consumableB);

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.consumables.index'))
            ->assertResponseContainsInRows($consumableA)
            ->assertResponseContainsInRows($consumableB);

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.consumables.index'))
            ->assertResponseContainsInRows($consumableA)
            ->assertResponseContainsInRows($consumableB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($superUser)
            ->getJson(route('api.consumables.index'))
            ->assertResponseContainsInRows($consumableA)
            ->assertResponseContainsInRows($consumableB);

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.consumables.index'))
            ->assertResponseContainsInRows($consumableA)
            ->assertResponseDoesNotContainInRows($consumableB);

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.consumables.index'))
            ->assertResponseDoesNotContainInRows($consumableA)
            ->assertResponseContainsInRows($consumableB);
    }
}
