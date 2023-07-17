<?php

namespace Tests\Feature\Api\Users;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersSearchTest extends TestCase
{
    use InteractsWithSettings;

    public function testCanSearchByUserFirstAndLastName()
    {
        User::factory()->create(['first_name' => 'Luke', 'last_name' => 'Skywalker']);
        User::factory()->create(['first_name' => 'Darth', 'last_name' => 'Vader']);

        Passport::actingAs(User::factory()->viewUsers()->create());
        $response = $this->getJson(route('api.users.index', ['search' => 'luke sky']))->assertOk();

        $results = collect($response->json('rows'));

        $this->assertEquals(1, $results->count());
        $this->assertTrue($results->pluck('name')->contains(fn($text) => str_contains($text, 'Luke')));
        $this->assertFalse($results->pluck('name')->contains(fn($text) => str_contains($text, 'Darth')));
    }

    public function testResultsWhenSearchingForActiveUsers()
    {
        User::factory()->create(['first_name' => 'Active', 'last_name' => 'User']);
        User::factory()->create(['first_name' => 'Deleted', 'last_name' => 'User'])->delete();

        $response = $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.users.index', [
                'deleted' => 'false',
                'company_id' => '',
                'search' => 'user',
                'order' => 'asc',
                'offset' => '0',
                'limit' => '20',
            ]))
            ->assertOk();

        $firstNames = collect($response->json('rows'))->pluck('first_name');

        $this->assertTrue(
            $firstNames->contains('Active'),
            'Expected user does not appear in results'
        );

        $this->assertFalse(
            $firstNames->contains('Deleted'),
            'Unexpected deleted user appears in results'
        );
    }

    public function testResultsWhenSearchingForDeletedUsers()
    {
        User::factory()->create(['first_name' => 'Active', 'last_name' => 'User']);
        User::factory()->create(['first_name' => 'Deleted', 'last_name' => 'User'])->delete();

        $response = $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.users.index', [
                'deleted' => 'true',
                'company_id' => '',
                'search' => 'user',
                'order' => 'asc',
                'offset' => '0',
                'limit' => '20',
            ]))
            ->assertOk();

        $firstNames = collect($response->json('rows'))->pluck('first_name');

        $this->assertFalse(
            $firstNames->contains('Active'),
            'Unexpected active user appears in results'
        );

        $this->assertTrue(
            $firstNames->contains('Deleted'),
            'Expected deleted user does not appear in results'
        );
    }
}
