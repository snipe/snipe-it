<?php

namespace App\Exceptions;

use Exception;

/**
 * Thrown by Loggable::logCheckout when the caller couldn't hand it a valid
 * target (missing entirely, or a hollow object with no id). Kept as a typed
 * exception so callers wrapping their work in a DB::transaction can catch
 * this specifically to roll back the transaction and return a real 4xx
 * response body, instead of letting it bubble up as an unhandled 500.
 */
class MissingLogTarget extends Exception
{
    //
}
