<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UsersForSelectListTest extends TestCase
{
    public function testUsersAreReturned()
    {
        Setting::factory()->create();

        User::factory()->count(3)->create();

        Passport::actingAs(User::factory()->firstAdmin()->create());
        $this->getJson(route('api.users.selectlist'))
            ->assertOk()
            ->assertJsonStructure([
                'results',
                'pagination',
                'total_count',
                'page',
                'page_count',
            ])
            ->assertJson(fn(AssertableJson $json) => $json->has('results', 4)->etc());
    }

    public function testUsersScopedToCompanyWhenMultipleFullCompanySupportEnabled()
    {
        Setting::factory()->withMultipleFullCompanySupport()->create();

        $jedi = Company::factory()->has(User::factory()->count(3)->sequence(
            ['first_name' => 'Luke', 'last_name' => 'Skywalker', 'username' => 'lskywalker'],
            ['first_name' => 'Obi-Wan', 'last_name' => 'Kenobi', 'username' => 'okenobi'],
            ['first_name' => 'Anakin', 'last_name' => 'Skywalker', 'username' => 'askywalker'],
        ))->create();

        $sith = Company::factory()
            ->has(User::factory()->state(['first_name' => 'Darth', 'last_name' => 'Vader', 'username' => 'dvader']))
            ->create();

        Passport::actingAs($jedi->users->first());
        $response = $this->getJson(route('api.users.selectlist'))->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(3, $results->count());
        $this->assertTrue(
            $results->pluck('text')->contains(fn($text) => str_contains($text, 'Luke'))
        );
        $this->assertFalse(
            $results->pluck('text')->contains(fn($text) => str_contains($text, 'Darth'))
        );
    }

    public function testUsersScopedToCompanyDuringSearchWhenMultipleFullCompanySupportEnabled()
    {
        Setting::factory()->withMultipleFullCompanySupport()->create();

        $jedi = Company::factory()->has(User::factory()->count(3)->sequence(
            ['first_name' => 'Luke', 'last_name' => 'Skywalker', 'username' => 'lskywalker'],
            ['first_name' => 'Obi-Wan', 'last_name' => 'Kenobi', 'username' => 'okenobi'],
            ['first_name' => 'Anakin', 'last_name' => 'Skywalker', 'username' => 'askywalker'],
        ))->create();

        Company::factory()
            ->has(User::factory()->state(['first_name' => 'Darth', 'last_name' => 'Vader', 'username' => 'dvader']))
            ->create();

        Passport::actingAs($jedi->users->first());
        $response = $this->getJson(route('api.users.selectlist', ['search' => 'a']))->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(3, $results->count());
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, 'Luke')));
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, 'Anakin')));

        $response = $this->getJson(route('api.users.selectlist', ['search' => 'v']))->assertOk();
        $this->assertEquals(0, collect($response->json('results'))->count());
    }
}
