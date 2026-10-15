<?php

namespace Tests\Feature\Accessories\Ui;

use App\Enums\CheckoutRequestState;
use App\Models\Accessory;
use App\Models\CheckoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Bulk-fulfill flow for the Accessory type. Same per-row/partial-
 * success contract every user-target bulk-fulfill controller uses
 * (consumables and licenses have their own mirror tests since the
 * qty semantics differ slightly). Screen is reached from the
 * "Fulfill Multiple" button on /requests when >=2 pending requests
 * exist for the same accessory.
 */
class BulkFulfillAccessoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_requires_checkout_permission_on_accessories(): void
    {
        // Endpoint gate: caller without checkoutAccessories should
        // be blocked before they can see the pending queue.
        $accessory = Accessory::factory()->create(['qty' => 10]);

        $this->actingAs(User::factory()->create())
            ->get(route('accessories.fulfill-requests.create', $accessory))
            ->assertForbidden();
    }

    public function test_show_lists_all_pending_requests_for_the_accessory(): void
    {
        $admin = User::factory()->checkoutAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        $aliceRequest = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 2,
        ]);
        $bobRequest = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 3,
        ]);

        $this->actingAs($admin)
            ->get(route('accessories.fulfill-requests.create', $accessory))
            ->assertOk()
            ->assertViewHas('pendingRequests', function ($pending) use ($aliceRequest, $bobRequest) {
                $ids = collect($pending)->pluck('id')->all();

                return count($ids) === 2
                    && in_array($aliceRequest->id, $ids, true)
                    && in_array($bobRequest->id, $ids, true);
            });
    }

    public function test_fulfills_only_ticked_rows_and_leaves_others_pending(): void
    {
        // Opt-in semantics: rows admin didn't check stay pending
        // on the queue for a later pass.
        $admin = User::factory()->checkoutAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        $aliceRequest = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 2,
        ]);
        $bobRequest = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 3,
        ]);

        $this->actingAs($admin)
            ->post(route('accessories.fulfill-requests.store', $accessory), [
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
        // Admin fulfills 1 of a 3-request. State stays pending;
        // fulfilled_quantity advances so the next pass knows what's
        // still owed. Original quantity stays immutable.
        $admin = User::factory()->checkoutAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        $requester = User::factory()->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 3,
        ]);

        $this->actingAs($admin)
            ->post(route('accessories.fulfill-requests.store', $accessory), [
                'enabled_requests' => [$request->id => '1'],
                'user_id' => [$request->id => $requester->id],
                'qty' => [$request->id => 1],
                'notes' => [$request->id => ''],
            ])
            ->assertRedirect(route('requests.index'));

        $fresh = $request->fresh();
        $this->assertSame(CheckoutRequestState::Pending, $fresh->state);
        $this->assertSame(3, $fresh->quantity);
        $this->assertSame(1, $fresh->fulfilled_quantity);
        $this->assertSame(2, $fresh->remainingQuantity());
    }

    public function test_stale_or_already_fulfilled_row_is_silently_skipped(): void
    {
        // Between page load and submit, another admin already
        // fulfilled or canceled the request. The bulk-fulfill
        // controller should skip that row (per-row partial success)
        // without failing the whole batch.
        $admin = User::factory()->checkoutAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        $canceledRequest = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 1,
            'canceled_at' => now(),
        ]);
        $stillPending = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 1,
        ]);

        $this->actingAs($admin)
            ->post(route('accessories.fulfill-requests.store', $accessory), [
                'enabled_requests' => [
                    $canceledRequest->id => '1',
                    $stillPending->id => '1',
                ],
                'user_id' => [
                    $canceledRequest->id => $alice->id,
                    $stillPending->id => $bob->id,
                ],
                'qty' => [
                    $canceledRequest->id => 1,
                    $stillPending->id => 1,
                ],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(CheckoutRequestState::Canceled, $canceledRequest->fresh()->state);
        $this->assertSame(CheckoutRequestState::Fulfilled, $stillPending->fresh()->state);
    }

    public function test_empty_selection_redirects_back_with_error(): void
    {
        // Submit without ticking any rows: nothing to do. Redirect
        // back to the fulfill screen with a "no rows selected"
        // flash rather than confusing the admin with a bare
        // success redirect.
        $admin = User::factory()->checkoutAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 1,
        ]);

        $this->actingAs($admin)
            ->post(route('accessories.fulfill-requests.store', $accessory), [
                // no enabled_requests
                'user_id' => [],
                'qty' => [],
                'notes' => [],
            ])
            ->assertRedirect(route('accessories.fulfill-requests.create', $accessory))
            ->assertSessionHas('error');
    }
}
