<?php

namespace Tests\Feature\Api\Users;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UsersForSelectListTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersAreReturned()
    {
        Setting::factory()->create();

        $actor = User::factory()->firstAdmin()->create();
        User::factory()->count(3)->create();

        Passport::actingAs($actor);
        $response = $this->getJson(route('api.users.selectlist'));
        $response->assertOk();

        $response->assertJsonStructure([
            'results',
            'pagination',
            'total_count',
            'page',
            'page_count',
        ]);

        $response->assertJson(fn(AssertableJson $json) => $json->has('results', 4)->etc());
    }

    public function testUsersScopedToCompanyWhenMultipleFullCompanySupportEnabled()
    {
        $this->markTestIncomplete();

    }

    public function testUsersScopedToCompanyDuringSearchWhenMultipleFullCompanySupportEnabled()
    {
        $this->markTestIncomplete();


    }
}
