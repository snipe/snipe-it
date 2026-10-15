<?php

namespace Tests\Feature\Checkouts\Api;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CheckoutRequestCounterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_cancel_without_active_request_returns_404_and_does_not_touch_counter()
    {
        // Reg-test for the cancel-request counter drift: hitting the cancel
        // endpoint when the caller has no active CheckoutRequest used to
        // unconditionally decrement requests_counter, which drove the
        // counter negative and misrepresented pending admin work.
        $asset = Asset::factory()->requestable()->create(['requests_counter' => 0]);
        $user = User::factory()->create();

        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.destroy', $asset))
            ->assertStatus(404)
            ->assertStatusMessageIs('error');

        $this->assertEquals(0, $asset->fresh()->requests_counter);
    }

    public function test_duplicate_active_request_returns_409_and_increments_counter_only_once()
    {
        // Reg-test for duplicate-active-request counter drift: a second
        // POST from the same caller used to add a second CheckoutRequest
        // row AND bump requests_counter a second time. On cancel only one
        // decrement fired, so the counter and the pending queue drifted
        // apart.
        $asset = Asset::factory()->requestable()->create(['requests_counter' => 0]);
        $user = User::factory()->create();

        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.store', $asset))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.store', $asset))
            ->assertStatus(409)
            ->assertStatusMessageIs('error');

        $this->assertEquals(1, $asset->fresh()->requests_counter);
        $this->assertEquals(
            1,
            $asset->openRequests()->where('user_id', $user->id)->count(),
            'Second request should not have created a second active CheckoutRequest row.'
        );
    }

    public function test_cancel_after_active_request_decrements_counter_by_exactly_one()
    {
        // Companion to the two above: a legitimate request-then-cancel
        // round trip must leave the counter at 0.
        $asset = Asset::factory()->requestable()->create(['requests_counter' => 0]);
        $user = User::factory()->create();

        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.store', $asset))
            ->assertOk();

        $this->assertEquals(1, $asset->fresh()->requests_counter);

        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.destroy', $asset))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertEquals(0, $asset->fresh()->requests_counter);
    }

    public function test_double_cancel_only_decrements_counter_once()
    {
        // Combined regression: request once, cancel twice. The second
        // cancel must 404 without dragging the counter below zero.
        $asset = Asset::factory()->requestable()->create(['requests_counter' => 0]);
        $user = User::factory()->create();

        $this->actingAsForApi($user)->postJson(route('api.assets.requests.store', $asset))->assertOk();
        $this->actingAsForApi($user)->postJson(route('api.assets.requests.destroy', $asset))->assertOk();
        $this->actingAsForApi($user)
            ->postJson(route('api.assets.requests.destroy', $asset))
            ->assertStatus(404);

        $this->assertEquals(0, $asset->fresh()->requests_counter);
    }
}
