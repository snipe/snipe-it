<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testUsersIndexAdheresToCompanyScoping()
    {
        $this->markTestIncomplete(
            'Waiting for removal of Company::scopeCompanyables in UsersController@index'
        );

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $userA = User::factory()->for($companyA)->create();
        $userB = User::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewUsers()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewUsers()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAsForApi($superUser)
            ->getJson(route('api.users.index'))
            ->assertResponseContainsInRows($userA, 'first_name')
            ->assertResponseContainsInRows($userB, 'first_name');

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.users.index'))
            ->assertResponseContainsInRows($userA, 'first_name')
            ->assertResponseContainsInRows($userB, 'first_name');

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.users.index'))
            ->assertResponseContainsInRows($userA, 'first_name')
            ->assertResponseContainsInRows($userB, 'first_name');

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($superUser)
            ->getJson(route('api.users.index'))
            ->assertResponseContainsInRows($userA, 'first_name')
            ->assertResponseContainsInRows($userB, 'first_name');

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.users.index'))
            ->assertResponseContainsInRows($userA, 'first_name')
            ->assertResponseDoesNotContainInRows($userB, 'first_name');

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.users.index'))
            ->assertResponseDoesNotContainInRows($userA, 'first_name')
            ->assertResponseContainsInRows($userB, 'first_name');
    }
}
