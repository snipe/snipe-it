<?php

use App\Enums\ActionType;
use App\Models\Asset;
use App\Models\License;
use App\Models\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * One-shot reconciliation of parent `qty` against the action_logs
 * ledger for the three inventory models with qty adjustments
 * (Accessory, Consumable, Component). Runs the invariant:
 *
 *   parent.qty = SUM(action_logs.quantity WHERE item = parent
 *                    AND action_type IN ('create', 'qty_adjust'))
 *
 * Any row where the parent column disagrees with the ledger sum gets
 * corrected to the ledger value. The AdjustsQuantity trait wraps its
 * qty writes in a DB transaction so from this migration forward the
 * two stay in sync. This migration catches historical drift that
 * pre-dates the trait (direct `$model->qty = ...` writes that skipped
 * the log).
 *
 * License is deliberately excluded. License.seats reconciliation
 * would also need to create or destroy LicenseSeat pivot rows to keep
 * the seat-tracking invariants, which is beyond a data-only fix.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Filter OrderItem::ITEM_TYPES down to the models with a scalar
        // `qty` column that this reconciliation actually operates on.
        // Asset is 1:1 (no qty column, one row per unit), and License
        // is excluded per the note above.
        $qtyModels = array_diff(OrderItem::ITEM_TYPES, [Asset::class, License::class]);

        foreach ($qtyModels as $modelClass) {
            $this->reconcileFor($modelClass);
        }
    }

    public function down(): void
    {
        // No-op. We can't restore whatever drift existed before the
        // reconciliation because the ledger IS the correct value.
    }

    private function reconcileFor(string $modelClass): void
    {
        $create = ActionType::Create->value;
        $qtyAdjust = ActionType::QuantityAdjust->value;

        $modelClass::query()->chunkById(500, function ($rows) use ($modelClass, $create, $qtyAdjust) {
            foreach ($rows as $model) {
                // Guard against clobbering rows the AdjustsQuantity trait
                // never touched. A row with zero qty_adjust entries is
                // definitionally pre-trait: every post-trait qty change
                // writes a qty_adjust log, so the absence of any means
                // this row's current qty was maintained by direct writes
                // that never fed the ledger. The ledger sum for such a
                // row is whatever legacy code happened to record on the
                // create entry (often quantity=1 on pre-replenish
                // deployments), which will not match the true on-hand
                // count. Trusting the ledger here silently clobbers qty
                // (see issue #19474: legacy accessories all reset to 1
                // after v8.7.0 upgrade). Skip the row - qty stays as the
                // human admin last set it, and legacy_qty (captured by
                // the snapshot migration) is the rollback lever.
                $qtyAdjustCount = DB::table('action_logs')
                    ->where('item_type', $modelClass)
                    ->where('item_id', $model->id)
                    ->where('action_type', $qtyAdjust)
                    ->whereNull('deleted_at')
                    ->count();

                if ($qtyAdjustCount === 0) {
                    continue;
                }

                $expected = (int) DB::table('action_logs')
                    ->where('item_type', $modelClass)
                    ->where('item_id', $model->id)
                    ->whereIn('action_type', [$create, $qtyAdjust])
                    ->whereNull('deleted_at')
                    ->sum('quantity');

                $actual = (int) $model->qty;

                if ($expected === $actual) {
                    continue;
                }

                // Redundant with the qty_adjust guard above (a row with
                // no qty_adjust entries and only a legacy zero-quantity
                // create event would trip both), but kept as a
                // belt-and-braces defense for any lingering edge shape
                // - e.g. a create entry that was soft-deleted and
                // filtered out of $expected but not out of the trait's
                // own write path.
                if ($expected === 0 && $actual > 0) {
                    continue;
                }

                $inUse = method_exists($model, 'currentlyInUseCount')
                    ? (int) $model->currentlyInUseCount()
                    : 0;

                if ($expected < $inUse) {
                    Log::info(sprintf(
                        'Skipping reconcile of %s#%d: ledger sum %d < in-use count %d (probably stale pre-replenish action_logs)',
                        $modelClass,
                        $model->id,
                        $expected,
                        $inUse,
                    ));

                    continue;
                }

                Log::info(sprintf(
                    'Reconciling %s#%d qty: %d -> %d (ledger sum)',
                    $modelClass,
                    $model->id,
                    $actual,
                    $expected,
                ));

                // Direct DB update to bypass observers and events. The
                // AdjustsQuantity trait would try to write another
                // action_log entry, which would defeat the "sum equals
                // the ledger" invariant we just calculated.
                DB::table((new $modelClass)->getTable())
                    ->where('id', $model->id)
                    ->update(['qty' => $expected]);
            }
        });
    }
};
