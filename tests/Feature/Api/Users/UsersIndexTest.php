<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersIndexTest extends TestCase
{
    use InteractsWithResponses;
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

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseContainsInRows($response, $userA, 'first_name');
        $this->assertResponseContainsInRows($response, $userB, 'first_name');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseContainsInRows($response, $userA, 'first_name');
        $this->assertResponseContainsInRows($response, $userB, 'first_name');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseContainsInRows($response, $userA, 'first_name');
        $this->assertResponseContainsInRows($response, $userB, 'first_name');

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseContainsInRows($response, $userA, 'first_name');
        $this->assertResponseContainsInRows($response, $userB, 'first_name');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseContainsInRows($response, $userA, 'first_name');
        $this->assertResponseDoesNotContainInRows($response, $userB, 'first_name');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.users.index'));
        $this->assertResponseDoesNotContainInRows($response, $userA, 'first_name');
        $this->assertResponseContainsInRows($response, $userB, 'first_name');
    }
}
