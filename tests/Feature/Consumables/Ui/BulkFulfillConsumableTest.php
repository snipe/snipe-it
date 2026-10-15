<?php

namespace Tests\Feature\Consumables\Ui;

use App\Enums\CheckoutRequestState;
use App\Models\CheckoutRequest;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Bulk-fulfill flow for Consumables. Same per-row/partial-success
 * contract every user-target bulk-fulfill controller uses; see
 * BulkFulfillAccessoryTest for the canonical shape.
 */
class BulkFulfillConsumableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_requires_checkout_permission_on_consumables(): void
    {
        $consumable = Consumable::factory()->create(['qty' => 10]);

        $this->actingAs(User::factory()->create())
            ->get(route('consumables.fulfill-requests.create', $consumable))
            ->assertForbidden();
    }

    public function test_fulfills_only_ticked_rows(): void
    {
        $admin = User::factory()->checkoutConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 10]);
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        $aliceRequest = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
            'quantity' => 2,
        ]);
        $bobRequest = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
            'quantity' => 3,
        ]);

        $this->actingAs($admin)
            ->post(route('consumables.fulfill-requests.store', $consumable), [
                'enabled_requests' => [$aliceRequest->id => '1'],
                'user_id' => [$aliceRequest->id => $alice->id],
                'qty' => [$aliceRequest->id => 2],
                'notes' => [$aliceRequest->id => ''],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(CheckoutRequestState::Fulfilled, $aliceRequest->fresh()->state);
        $this->assertSame(CheckoutRequestState::Pending, $bobRequest->fresh()->state);
    }

    public function test_partial_qty_leaves_row_pending_with_counter_advanced(): void
    {
        $admin = User::factory()->checkoutConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 10]);
        $requester = User::factory()->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $consumable->id,
            'requestable_type' => Consumable::class,
            'quantity' => 4,
        ]);

        $this->actingAs($admin)
            ->post(route('consumables.fulfill-requests.store', $consumable), [
                'enabled_requests' => [$request->id => '1'],
                'user_id' => [$request->id => $requester->id],
                'qty' => [$request->id => 2],
                'notes' => [$request->id => ''],
            ])
            ->assertRedirect(route('requests.index'));

        $fresh = $request->fresh();
        $this->assertSame(CheckoutRequestState::Pending, $fresh->state);
        $this->assertSame(2, $fresh->fulfilled_quantity);
        $this->assertSame(2, $fresh->remainingQuantity());
    }
}
