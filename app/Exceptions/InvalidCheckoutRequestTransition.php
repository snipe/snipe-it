<?php

namespace App\Exceptions;

use App\Enums\CheckoutRequestState;
use App\Models\CheckoutRequest;
use Exception;

/**
 * Thrown by CheckoutRequest state-machine actions
 * (FulfillCheckoutRequestAction, CancelCheckoutRequestAction,
 * ExpireCheckoutRequestAction) when the caller tries to move a
 * request from a state that doesn't permit the target transition:
 * canceling a fulfilled row, fulfilling an expired row, etc.
 *
 * Terminal states (fulfilled, canceled, expired) are irreversible.
 * The exception carries the current + attempted states so
 * controllers can map to a useful 422 body instead of a generic
 * "something went wrong".
 */
class InvalidCheckoutRequestTransition extends Exception
{
    public function __construct(
        public readonly CheckoutRequest $request,
        public readonly CheckoutRequestState $from,
        public readonly CheckoutRequestState $to,
    ) {
        parent::__construct(
            "Cannot transition CheckoutRequest #{$request->id} from {$from->value} to {$to->value}."
        );
    }
}
