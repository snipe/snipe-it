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
}
