<?php

namespace App\Exceptions;

use Exception;

/**
 * Thrown by CreateCheckoutRequestAction when the caller already has an
 * active (not-yet-canceled) CheckoutRequest for the same requestable.
 * Enforces the one-active-request-per-user-per-asset invariant so the
 * shared requests_counter and admin queue stay 1:1 with real active
 * rows.
 */
class DuplicateCheckoutRequest extends Exception {}
