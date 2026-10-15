<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Raised when a sync-adapter vendor call returned a response the
 * adapter can't consume even though the transport layer didn't
 * signal an error. Typical trigger: base URL points at the vendor's
 * web console instead of their API, so the response is a 200 OK
 * carrying an HTML SPA shell instead of the expected JSON.
 *
 * SettingsController::sanitizeSyncErrorSummary handles this class
 * specially so the flash shows the exception's message instead of
 * the class-basename fallback.
 */
class SyncAdapterVendorException extends RuntimeException {}
