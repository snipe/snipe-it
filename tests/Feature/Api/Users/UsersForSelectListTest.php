<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
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
        Setting::factory()->withMultipleFullCompanySupport()->create();

        [$jedi, $sith] = Company::factory()->count(2)->create();

        User::factory()
            ->for($sith)
            ->create(['first_name' => 'Darth', 'last_name' => 'Vader']);

        User::factory()
            ->for($jedi)
            ->count(3)
            ->sequence(
                ['first_name' => 'Luke', 'last_name' => 'Skywalker'],
                ['first_name' => 'Obi-Wan', 'last_name' => 'Kenobi'],
                ['first_name' => 'Anakin', 'last_name' => 'Skywalker'],
            )
            ->create();

        Passport::actingAs($jedi->users->first());
        $response = $this->getJson(route('api.users.selectlist'));
        $response->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals($jedi->users->count(), $results->count());

        $this->assertTrue(
            $results->pluck('text')->contains(fn($text) => str_contains($text, $jedi->users->first()->first_name))
        );

        $this->assertFalse(
            $results->pluck('text')->contains(fn($text) => str_contains($text, $sith->users->first()->first_name))
        );
    }

    public function testUsersScopedToCompanyDuringSearchWhenMultipleFullCompanySupportEnabled()
    {
        
    }
}
