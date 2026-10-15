<?php

namespace App\Models\Traits;

use App\Enums\ActionType;
use App\Models\Actionlog;
use DomainException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * Adds a shared "adjust the on-hand quantity by N" API to
 * inventory-style models (Accessory, Consumable, Component, License).
 *
 * The consuming model tells the trait which integer column represents
 * its on-hand count via getAdjustableQuantityColumn() — qty for
 * accessories/consumables/components, seats for licenses.
 *
 * Every adjustment writes one ActionType::QuantityAdjust entry to
 * action_logs with:
 *   - quantity = signed delta (positive for replenish, negative for decrement)
 *   - note = the operator's reason (required by the controller)
 *   - order_item_id = optional FK to the specific OrderItem line this
 *     event produced. The parent Order is reachable via the OrderItem.
 *     The caller creates / looks up the OrderItem and passes the id;
 *     the trait does not touch the Orders / OrderItems tables itself.
 *
 * License overrides adjustQuantity() so that adding or removing
 * seats also creates or destroys the matching LicenseSeat pivot rows.
 */
trait AdjustsQuantity
{
    /**
     * Which integer column on this model represents its on-hand
     * quantity. Default matches accessories / consumables / components.
     */
    public function getAdjustableQuantityColumn(): string
    {
        return 'qty';
    }

    /**
     * How many units of this item are currently checked out / in use
     * (accessory checkouts, consumable distributions, component ->asset
     * assignments). Models override; default 0 means "nothing in use"
     * and only zero is a hard floor.
     */
    public function currentlyInUseCount(): int
    {
        return 0;
    }

    /**
     * Every QuantityAdjust action_log row for this model. Used by the
     * history tab to render replenishment / decrement events in
     * chronological order alongside the other action types.
     *
     * Explicitly NOT wired into $searchableRelations — free-text search
     * on order-number strings goes through the HasOrders trait's
     * orders() HasManyThrough into the Orders table instead, since the
     * action_logs row no longer carries the raw order-number string.
     */
    public function quantityAdjustLogs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'item')
            ->where('action_type', ActionType::QuantityAdjust->value);
    }

    /**
     * Apply a signed delta to the on-hand quantity and log the change.
     *
     * Uses Eloquent's increment/decrement so the write is atomic against
     * concurrent adjusters (SQL UPDATE ... SET qty = qty + ?, not a
     * PHP-side read-modify-write). Wrapped in a transaction so the log
     * entry and the quantity change either both happen or both roll back.
     *
     * A delta of zero is a valid audit-only submission: no qty change
     * happens but the log entry still writes, so a user can record a
     * physical count that confirms the DB value without also logging a
     * spurious increment or decrement.
     *
     * Rejects any adjustment that would leave the on-hand quantity below
     * the number of units currently in use — decrementing below what's
     * already checked out to users/assets would leave the DB inconsistent
     * (checkouts pointing at inventory that supposedly doesn't exist).
     *
     * @throws DomainException when the resulting quantity would go
     *                         below the in-use count. Controllers should
     *                         convert this to a user-visible flash error.
     *                         Uses DomainException specifically so callers
     *                         don't accidentally swallow QueryException
     *                         (which extends RuntimeException) as a
     *                         below-floor violation.
     */
    public function adjustQuantity(int $delta, string $note, ?int $orderItemId = null, ?string $filename = null): void
    {
        $column = $this->getAdjustableQuantityColumn();

        DB::transaction(function () use ($delta, $column, $note, $orderItemId, $filename) {
            // TOCTOU-safe path: SELECT ... FOR UPDATE on this row so
            // concurrent adjusters serialize. Read + floor-check +
            // decrement all live under the same lock, otherwise two
            // requests each read the same pre-decrement quantity, each
            // pass the floor check independently, and each apply their
            // delta - aggregate effect drives on-hand below in-use even
            // though each request looked valid on its own. The pattern
            // matches the pessimistic lock LicenseCheckoutController
            // already uses on seat checkout for the same reason.
            $locked = static::query()->lockForUpdate()->find($this->id);
            if ($locked === null) {
                // Row went away between the caller loading it and the
                // trait entering the transaction. Rare (would require
                // a concurrent forceDelete) but bail cleanly rather
                // than hit a null-deref two lines below.
                throw new DomainException("Row {$this->id} not found during adjustQuantity lock");
            }
            $current = (int) ($locked->{$column} ?? 0);
            $inUse = max(0, (int) $locked->currentlyInUseCount());

            if ($current + $delta < $inUse) {
                throw new DomainException(
                    "Adjustment would take on-hand quantity ({$current}) below the {$inUse} unit(s) currently in use (delta={$delta})"
                );
            }

            // Use the query builder directly (not $this->increment) so
            // the model's `updated` event doesn't fire. Firing it would
            // write a second "update" action_log entry (with log_meta of
            // {qty:{old,new}}) alongside our QuantityAdjust log. Keep
            // the in-memory attribute in sync so any downstream code
            // reading $this->qty after the call sees the new value.
            // Gate the actual UPDATE on delta !== 0 so audit-only
            // submissions (delta = 0) skip the round-trip.
            if ($delta > 0) {
                $this->newQuery()->where('id', $this->id)->increment($column, $delta);
                $this->{$column} = $current + $delta;
                $this->syncOriginalAttribute($column);
            } elseif ($delta < 0) {
                $this->newQuery()->where('id', $this->id)->decrement($column, abs($delta));
                $this->{$column} = $current + $delta;
                $this->syncOriginalAttribute($column);
            }

            $log = new Actionlog;
            $log->item_type = static::class;
            $log->item_id = $this->id;
            $log->created_by = auth()->id();
            $log->note = $note;
            $log->order_item_id = $orderItemId;
            $log->quantity = $delta;
            // Feed the history-tab's "changed" column so QuantityAdjust
            // entries render qty diffs the same way an update-type log
            // renders a name change. Only populated on non-zero deltas
            // - audit-only (delta = 0) submissions carry their reason
            // in `note` and leaving log_meta null keeps the "changed"
            // column empty for them (no field actually changed, so
            // nothing to diff).
            if ($delta !== 0) {
                $log->log_meta = json_encode([
                    $column => ['old' => $current, 'new' => $current + $delta],
                ]);
            }
            // Receipt/invoice attaches to the same log row rather than a
            // separate 'uploaded' entry, so the history table shows one
            // consolidated line per replenishment. The caller handles the
            // actual file save via UploadFileRequest::handleFile and just
            // passes the returned filename through.
            $log->filename = $filename;
            $log->logaction(ActionType::QuantityAdjust->value);
        });
    }
}
