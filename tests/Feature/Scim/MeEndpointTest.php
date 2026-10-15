<?php

namespace Tests\Feature\Scim;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;


class MeEndpointTest extends TestCase
{
    public function test_scim_me_returns_the_authenticated_user()
    {
        $me = User::factory()->superuser()->create([
            'email' => 'me@example.com',
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
        ]);
        Passport::actingAs($me);

        $response = $this->getJson('/scim/v2/Me')->assertOk();
        $this->assertSame((string) $me->id, $response->json('id'));

        $this->assertSame('me@example.com', $response->json('emails.0.value'));
    }

    public function test_scim_me_matches_users_endpoint_for_same_subject()
    {

        $me = User::factory()->superuser()->create();
        Passport::actingAs($me);

        $meBody = $this->getJson('/scim/v2/Me')->assertOk()->json();
        $userBody = $this->getJson('/scim/v2/Users/'.$me->id)->assertOk()->json();

        $this->assertSame($userBody['id'], $meBody['id']);
        $this->assertSame($userBody['userName'] ?? null, $meBody['userName'] ?? null);
    }
}
