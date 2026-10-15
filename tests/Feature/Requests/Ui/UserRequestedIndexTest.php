<?php

namespace Tests\Feature\Requests\Ui;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for the "my open requests" surfaces at /account/requested
 * (the shell page) and GET /api/v1/account/requests (the data source
 * the shell page hydrates from). Adds self-cancel wiring: each row
 * carries a cancel_url and POSTing to it from the request owner
 * cancels the row without needing an admin gate.
 */
class UserRequestedIndexTest extends TestCase
{
    public function test_api_row_scopes_to_the_authed_user_and_open_requests_only(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $asset = Asset::factory()->requestable()->create();
        $accessory = Accessory::factory()->create(['requestable' => true]);

        $openOwn = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'canceled_at' => now(),
        ]);
        CheckoutRequest::factory()->create([
            'user_id' => $other->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $response = $this->actingAsForApi($user)
            ->getJson(route('api.assets.requested'))
            ->assertOk();

        $rows = $response->json('rows') ?? [];
        $this->assertCount(1, $rows, 'Only the auth user\'s single open request should surface.');
        $this->assertSame($openOwn->id, $rows[0]['id']);
        $this->assertArrayHasKey('cancel_url', $rows[0]);
        $this->assertStringContainsString('/account/request/asset/'.$asset->id, $rows[0]['cancel_url']);
    }

    public function test_posting_to_the_cancel_url_cancels_the_users_own_request(): void
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->requestable()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $this->actingAs($user)
            ->post(route('account/request-item', [
                'itemType' => 'asset',
                'itemId' => $asset->id,
            ]))
            ->assertRedirect();

        $this->assertNotNull(
            $request->fresh()->canceled_at,
            'Self-POST from the row owner must flip canceled_at.'
        );
    }

    public function test_shell_page_loads_for_authed_user(): void
    {
        // The page is API-backed so this only pins the route + view
        // wire-up. The self-cancel column contents themselves render
        // client-side via userRequestCancelFormatter (JS), which is
        // outside the test scope.
        $this->actingAs(User::factory()->create())
            ->get(route('account.requested'))
            ->assertOk();
    }
}
