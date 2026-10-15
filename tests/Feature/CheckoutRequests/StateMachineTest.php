<?php

namespace Tests\Feature\CheckoutRequests;

use App\Actions\CheckoutRequests\FulfillCheckoutRequestAction;
use App\Enums\CheckoutRequestState;
use App\Exceptions\InvalidCheckoutRequestTransition;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\User;
use Tests\TestCase;

/**
 * Codifies which state transitions are legal + which throw. The
 * state column drives every lifecycle decision downstream (admin
 * queue filters, requester tab, Requestable::isRequestedBy gate,
 * withCount('openRequests') for the requests_counter replacement)
 * so a regression here silently corrupts the queue.
 *
 * Terminal states (fulfilled, canceled) are irreversible. Same-
 * state writes (fulfill an already-fulfilled row) no-op silently so
 * the fulfillment hook is safe to fire twice on a rapid retry.
 */
class StateMachineTest extends TestCase
{
    public function test_new_request_defaults_to_pending(): void
    {
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Asset::factory()->create()->id,
            'requestable_type' => Asset::class,
        ]);

        $this->assertSame(CheckoutRequestState::Pending, $request->state);
    }

    public function test_pending_transitions_to_fulfilled_via_action(): void
    {
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Asset::factory()->create()->id,
            'requestable_type' => Asset::class,
        ]);

        FulfillCheckoutRequestAction::run($request);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->state);
        $this->assertNotNull($request->fulfilled_at);
    }

    public function test_pending_transitions_to_canceled_via_cancel_request(): void
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $affected = $asset->cancelRequest($user->id);
        $request->refresh();

        $this->assertSame(1, $affected);
        $this->assertSame(CheckoutRequestState::Canceled, $request->state);
        $this->assertNotNull($request->canceled_at);
    }

    public function test_canceled_cannot_be_fulfilled(): void
    {
        // Terminal-state guard: a canceled row is done, and the
        // fulfillment hook must not resurrect it if the same user
        // later gets a checkout for the same item.
        $user = User::factory()->create();
        $asset = Asset::factory()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        $asset->cancelRequest($user->id);
        $request->refresh();

        $this->expectException(InvalidCheckoutRequestTransition::class);
        FulfillCheckoutRequestAction::run($request);
    }

    public function test_fulfilled_is_idempotent(): void
    {
        // The fulfillment hook can fire twice (retry, tests). A
        // second call on a fulfilled row must no-op instead of
        // throwing so the checkout controller doesn't 500 on a
        // benign re-entry.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Asset::factory()->create()->id,
            'requestable_type' => Asset::class,
        ]);
        FulfillCheckoutRequestAction::run($request);
        $request->refresh();
        $firstFulfilledAt = $request->fulfilled_at;

        FulfillCheckoutRequestAction::run($request);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->state);
        // Second call didn't overwrite the original timestamp,
        // which would happen if the guard was missing.
        $this->assertEquals($firstFulfilledAt->timestamp, $request->fulfilled_at->timestamp);
    }

    public function test_cancel_request_only_touches_pending_rows(): void
    {
        // If a user's request is already fulfilled (e.g. auto-
        // fulfilled by a prior checkout), a later cancel by the
        // same user for the same item must not flip the fulfilled
        // row back to canceled - the pending-state filter in
        // Requestable::cancelRequest gates on state, not just
        // canceled_at.
        $user = User::factory()->create();
        $asset = Asset::factory()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        FulfillCheckoutRequestAction::run($request);

        $affected = $asset->cancelRequest($user->id);

        $this->assertSame(0, $affected);
        $this->assertSame(CheckoutRequestState::Fulfilled, $request->fresh()->state);
    }

    public function test_open_scope_excludes_terminal_states(): void
    {
        $asset = Asset::factory()->create();
        $accessory = Accessory::factory()->create();

        // Pending: counts as open.
        CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        // Fulfilled: does not count as open.
        $fulfilled = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        FulfillCheckoutRequestAction::run($fulfilled);
        // Canceled: does not count as open.
        $canceledUser = User::factory()->create();
        CheckoutRequest::factory()->create([
            'user_id' => $canceledUser->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
        ]);
        $accessory->cancelRequest($canceledUser->id);

        $this->assertSame(1, CheckoutRequest::open()->count());
    }

    public function test_is_requested_by_returns_null_for_fulfilled_row(): void
    {
        // Requestable::isRequestedBy is what gates the "you already
        // have an open request" duplicate check + the request/
        // cancel button-swap on the requestable-tab. A fulfilled row
        // must not count so the user can request the same item
        // again after their previous request closed.
        $user = User::factory()->create();
        $asset = Asset::factory()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        FulfillCheckoutRequestAction::run($request);

        $this->assertNull($asset->isRequestedBy($user));
    }

    public function test_partial_fulfillment_advances_counter_and_leaves_pending(): void
    {
        // Admin fulfills 3 of a 5-requested row. State stays
        // pending because there's still 2 outstanding; counter
        // advances so the next fulfillment knows how much is left.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Accessory::factory()->create()->id,
            'requestable_type' => Accessory::class,
            'quantity' => 5,
        ]);

        FulfillCheckoutRequestAction::run($request, null, 3);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Pending, $request->state);
        $this->assertSame(3, $request->fulfilled_quantity);
        $this->assertSame(2, $request->remainingQuantity());
        $this->assertNull($request->fulfilled_at);
        $this->assertTrue($request->isPartiallyFulfilled());
    }

    public function test_full_fulfillment_across_multiple_partial_calls_closes_the_row(): void
    {
        // Two partial fulfillments that together hit the requested
        // qty flip the row to fulfilled. fulfilled_at is set only
        // on the pass that pushes the counter past the threshold.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Accessory::factory()->create()->id,
            'requestable_type' => Accessory::class,
            'quantity' => 4,
        ]);

        FulfillCheckoutRequestAction::run($request, null, 1);
        $request->refresh();
        $this->assertSame(CheckoutRequestState::Pending, $request->state);
        $this->assertNull($request->fulfilled_at);

        FulfillCheckoutRequestAction::run($request, null, 3);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->state);
        $this->assertSame(4, $request->fulfilled_quantity);
        $this->assertSame(0, $request->remainingQuantity());
        $this->assertNotNull($request->fulfilled_at);
        $this->assertFalse($request->isPartiallyFulfilled());
    }

    public function test_overfulfill_caps_at_requested_quantity(): void
    {
        // Admin somehow submits a qty larger than what was
        // requested (misclicked, hand-crafted POST). The action
        // caps at the remainder so fulfilled_quantity never
        // exceeds quantity - the audit trail preserves the
        // original ask exactly.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Accessory::factory()->create()->id,
            'requestable_type' => Accessory::class,
            'quantity' => 2,
        ]);

        FulfillCheckoutRequestAction::run($request, null, 99);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->state);
        $this->assertSame(2, $request->fulfilled_quantity);
    }

    public function test_zero_qty_fulfillment_is_a_noop(): void
    {
        // Belt: an event with qty=0 (edge case, shouldn't happen
        // from a real checkout but callers might slip a 0 through)
        // must not advance the counter or flip the state.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Accessory::factory()->create()->id,
            'requestable_type' => Accessory::class,
            'quantity' => 3,
        ]);

        FulfillCheckoutRequestAction::run($request, null, 0);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Pending, $request->state);
        $this->assertSame(0, $request->fulfilled_quantity);
    }

    public function test_null_qty_fulfillment_consumes_the_full_remainder(): void
    {
        // Backwards compat: single-target checkout controllers that
        // predate partial-fulfillment tracking call the action
        // without a qty. The action assumes "this fulfillment
        // covers the whole thing" so the request closes in one
        // pass. Keeps the old behavior for callers not opting into
        // the new partial semantics.
        $request = CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => Accessory::factory()->create()->id,
            'requestable_type' => Accessory::class,
            'quantity' => 7,
        ]);

        FulfillCheckoutRequestAction::run($request);
        $request->refresh();

        $this->assertSame(CheckoutRequestState::Fulfilled, $request->state);
        $this->assertSame(7, $request->fulfilled_quantity);
    }

    public function test_partial_row_still_counts_as_requested_by_for_duplicate_guard(): void
    {
        // Requestable::isRequestedBy gates the "you already have an
        // open request" duplicate check. A partially-fulfilled row
        // is still open (state=pending), so it must still count -
        // otherwise the user could file a new request while the
        // partial is outstanding and end up with two open rows for
        // the same item.
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $request = CheckoutRequest::factory()->create([
            'user_id' => $user->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => Accessory::class,
            'quantity' => 5,
        ]);

        FulfillCheckoutRequestAction::run($request, null, 2);

        $this->assertNotNull($accessory->isRequestedBy($user));
    }
}
