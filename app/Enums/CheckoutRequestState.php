<?php

namespace App\Enums;

/**
 * Lifecycle for a CheckoutRequest.
 *
 *   pending    Created by a requester, still open, not yet resolved.
 *   fulfilled  A matching checkout has been recorded. The request
 *              closes automatically via the fulfillment hook wired
 *              into every checkout controller.
 *   canceled   Explicit cancel by the requester or an admin.
 *
 * Approval is deliberately not included here. Snipe-IT ships without
 * an approval step in this pass. Requests move straight from
 * pending to fulfilled or canceled. If admin approval gets added later,
 * `approved` slots between pending and fulfilled.
 *
 * The state column is a varchar so `expired` / `approved` / etc.
 * can be added later without a schema migration - only the enum
 * needs a new case and the actions need transition wiring.
 */
enum CheckoutRequestState: string
{
    case Pending = 'pending';
    case Fulfilled = 'fulfilled';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => trans('admin/hardware/general.pending'),
            self::Fulfilled => trans('admin/hardware/general.fulfilled'),
            self::Canceled => trans('button.cancel'),
        };
    }

    /**
     * Bootstrap 3 label color class. Used by badge renderers on the
     * admin queue + requester tab so the state read is at-a-glance.
     */
    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Fulfilled => 'success',
            self::Canceled => 'default',
        };
    }

    /**
     * "Open" = still awaiting resolution. Anything that hasn't been
     * fulfilled or canceled counts as open. Used by
     * Requestable::isRequestedBy() and the openRequests scope.
     */
    public function isOpen(): bool
    {
        return $this === self::Pending;
    }

    /**
     * Terminal states are irreversible. Actions gate transitions
     * against them so a canceled request can't be re-fulfilled and
     * a fulfilled request can't be re-canceled.
     */
    public function isTerminal(): bool
    {
        return in_array($this, [self::Fulfilled, self::Canceled], true);
    }
}
