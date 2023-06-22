<?php

namespace Tests\Feature\Api\Components;

use App\Models\Company;
use App\Models\Component;
use App\Models\User;
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
        $this->getJson(route('api.components.index'))
            ->assertResponseContainsInRows($componentA)
            ->assertResponseContainsInRows($componentB);

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.components.index'))
            ->assertResponseContainsInRows($componentA)
            ->assertResponseContainsInRows($componentB);

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.components.index'))
            ->assertResponseContainsInRows($componentA)
            ->assertResponseContainsInRows($componentB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $this->getJson(route('api.components.index'))
            ->assertResponseContainsInRows($componentA)
            ->assertResponseContainsInRows($componentB);

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.components.index'))
            ->assertResponseContainsInRows($componentA)
            ->assertResponseDoesNotContainInRows($componentB);

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.components.index'))
            ->assertResponseDoesNotContainInRows($componentA)
            ->assertResponseContainsInRows($componentB);
    }
}
