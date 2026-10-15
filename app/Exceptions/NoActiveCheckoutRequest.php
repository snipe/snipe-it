<?php

namespace App\Exceptions;

use Exception;

/**
 * Thrown by CancelCheckoutRequestAction when the caller has no active
 * (not-yet-canceled) CheckoutRequest to cancel. Prevents the shared
 * requests_counter from being decremented on no-op cancellations,
 * which used to drive it negative and out of sync with the admin
 * queue.
 */
class NoActiveCheckoutRequest extends Exception {}
