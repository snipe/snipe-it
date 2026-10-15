<?php

namespace App\Actions\CheckoutRequests;

use App\Enums\CheckoutRequestState;
use App\Exceptions\InvalidCheckoutRequestTransition;
use App\Models\Actionlog;
use App\Models\CheckoutRequest;
use Illuminate\Support\Carbon;

/**
 * Close (or partially close) the fulfillment between a
 * checkout event and the CheckoutRequest it satisfied. Called from
 * the fulfillment hook inside every checkout controller (asset /
 * accessory / consumable / component / license, web + API) after
 * the checkout write commits and the checkout Actionlog row is
 * written.
 *
 * Partial fulfillment: a request for 5 pens that admin only has 3
 * of currently fulfills 3, stays pending, and lets the admin come
 * back for the remaining 2 later. Original `quantity` is
 * immutable so the audit trail preserves what the requester asked
 * for; `fulfilled_quantity` is the running counter of what's
 * actually been delivered. State only flips to `fulfilled` when
 * fulfilled_quantity catches up to quantity.
 *
 * This deliberately silent on the notification side. The requester
 * already gets the standard checkout notification via
 * CheckoutableListener when the checkout event fires. A second
 * "your request was fulfilled" mail would double-notify for one
 * action.
 *
 * This also deliberately does not write its own Actionlog either. Same
 * rationale as the notification skip. The checkout event's
 * actionlog IS the audit trail. The CheckoutRequest row's own new
 * columns (state=fulfilled, fulfilled_at, fulfilled_by,
 * checkout_actionlog_id pointing back at that same actionlog)
 * close the loop without doubling the item's history tab.
 *
 * Idempotent: no-op when the request is already fulfilled or the
 * incoming qty is 0. Safe to fire twice (retry, request-cycle
 * re-entry).
 */
class FulfillCheckoutRequestAction
{
    /**
     * @param  CheckoutRequest  $request  The request to fulfill (or partially fulfill)
     * @param  Actionlog|null  $checkoutActionlog  Actionlog row for the checkout that triggered this fulfillment
     * @param  int|null  $qty  How many units this fulfillment delivered. null = "assume the full remainder"
     *                         (matches how the single-target checkout flow works — one checkout event
     *                         handles the whole request). Overfulfill (qty > remaining) is capped at
     *                         remaining so an accidental large qty upstream can't push fulfilled_quantity
     *                         past quantity.
     * @param  int|null  $fulfilledByUserId  Admin who did the checkout. Falls back to auth()->id().
     *
     * @throws InvalidCheckoutRequestTransition when the request is
     *                                          canceled or in some other non-pending terminal state.
     */
    public static function run(
        CheckoutRequest $request,
        ?Actionlog $checkoutActionlog = null,
        ?int $qty = null,
        ?int $fulfilledByUserId = null,
    ): void {
        // Idempotency: an already-fulfilled row silently no-ops so
        // callers don't have to gate the hook on "did we already
        // fulfill this in this same POST cycle?".
        if ($request->state === CheckoutRequestState::Fulfilled) {
            return;
        }

        // Only pending rows are eligible. Canceled rows throw so
        // the caller can decide (usually log + skip).
        if ($request->state !== CheckoutRequestState::Pending) {
            throw new InvalidCheckoutRequestTransition(
                $request,
                $request->state,
                CheckoutRequestState::Fulfilled,
            );
        }

        $remaining = $request->remainingQuantity();
        if ($remaining <= 0) {
            // Row is pending but already fully counted. Flip to
            // fulfilled to reconcile the state with the counter.
            self::markFullyFulfilled($request, $checkoutActionlog, $fulfilledByUserId);

            return;
        }

        // Default: this fulfillment covers the whole remaining
        // amount (single-target checkout flow, or an admin who
        // opted in without editing qty). Overfulfill caps at
        // remaining so accidental large qtys upstream don't push
        // fulfilled_quantity past quantity.
        $delta = $qty === null ? $remaining : max(0, min($qty, $remaining));
        if ($delta === 0) {
            return;
        }

        $request->fulfilled_quantity = (int) $request->fulfilled_quantity + $delta;

        if ($request->fulfilled_quantity >= $request->quantity) {
            self::markFullyFulfilled($request, $checkoutActionlog, $fulfilledByUserId);

            return;
        }

        // Partial: counter advanced, state stays pending. Row
        // stays on the admin queue for the remainder.
        $request->save();
    }

    private static function markFullyFulfilled(
        CheckoutRequest $request,
        ?Actionlog $checkoutActionlog,
        ?int $fulfilledByUserId,
    ): void {
        $request->state = CheckoutRequestState::Fulfilled;
        $request->fulfilled_at = Carbon::now();
        $request->fulfilled_by = $fulfilledByUserId ?? auth()->id();
        $request->checkout_actionlog_id = $checkoutActionlog?->id;
        if ($request->fulfilled_quantity < $request->quantity) {
            // Belt: the caller reached here without incrementing
            // fulfilled_quantity past quantity (e.g. remainingQuantity
            // returned 0 branch). Set it to the requested amount so
            // downstream reads never see fulfilled with a lower
            // counter.
            $request->fulfilled_quantity = $request->quantity;
        }
        $request->save();
    }
}
