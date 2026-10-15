<?php

use App\Enums\ActionType;
use App\Models\Accessory;
use App\Models\Component;
use App\Models\Consumable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Data-recovery migration for installs that upgraded to v8.7.0 before
 * the reconcile guard in 2026_08_03_144000 was tightened.
 *
 * The v8.7.0 reconcile migration had a guard for rows whose ledger sum
 * came out to 0 but nothing for the common legacy pattern of a single
 * pre-trait `create` action_log entry with quantity=1. Rows matching
 * that pattern (legacy accessory / consumable / component with any
 * on-hand count, whose only ledger event was a stray quantity=1 create
 * log) got their real qty overwritten with 1. The follow-up repair
 * migration at 2026_08_03_148000 only lifts qty back up when it fell
 * below the currently-in-use count, so rows with zero units checked out
 * stayed stuck at 1. Reported in #19474.
 *
 * The snapshot migration at 2026_08_03_143500 preserved the pre-
 * reconcile qty in a companion `legacy_qty` column exactly for this
 * kind of rollback. This migration restores qty from that snapshot
 * only for rows where:
 *
 *   - qty is currently below legacy_qty (evidence of the clobber -
 *     if the admin has since re-adjusted qty back up to or past the
 *     original value, this is a no-op), AND
 *   - the row has zero qty_adjust action_log entries (evidence that
 *     the AdjustsQuantity trait has never been used on this row -
 *     if the admin has been actively managing qty through the
 *     replenish/decrement UI, those adjustments generated qty_adjust
 *     entries and we do not want to roll their intentional changes
 *     back to the snapshot value).
 *
 * Idempotent: on installs where the reconcile did no damage, every
 * row already has qty >= legacy_qty and this is a full no-op. Same
 * story on installs that ran the tightened reconcile migration and
 * never had the clobber happen in the first place.
 *
 * License is not in scope. License.seats was excluded from both the
 * snapshot and reconcile migrations, so there's nothing to restore.
 */
return new class extends Migration
{
    private const RESTORE_MODELS = [
        Accessory::class,
        Consumable::class,
        Component::class,
    ];

    public function up(): void
    {
        foreach (self::RESTORE_MODELS as $modelClass) {
            $this->restoreFor($modelClass);
        }
    }

    public function down(): void
    {
        // No-op. Reversing the restore would put qty back to the
        // clobbered value that this migration exists to fix.
    }

    private function restoreFor(string $modelClass): void
    {
        $qtyAdjust = ActionType::QuantityAdjust->value;
        $table = (new $modelClass)->getTable();

        $modelClass::query()
            ->whereNotNull('legacy_qty')
            ->whereColumn('qty', '<', 'legacy_qty')
            ->chunkById(500, function ($rows) use ($modelClass, $qtyAdjust, $table) {
                foreach ($rows as $model) {
                    $qtyAdjustCount = DB::table('action_logs')
                        ->where('item_type', $modelClass)
                        ->where('item_id', $model->id)
                        ->where('action_type', $qtyAdjust)
                        ->whereNull('deleted_at')
                        ->count();

                    if ($qtyAdjustCount > 0) {
                        continue;
                    }

                    Log::info(sprintf(
                        'Restoring %s#%d qty: %d -> %d (from legacy_qty snapshot, no qty_adjust events since)',
                        $modelClass,
                        $model->id,
                        (int) $model->qty,
                        (int) $model->legacy_qty,
                    ));

                    DB::table($table)
                        ->where('id', $model->id)
                        ->update(['qty' => $model->legacy_qty]);
                }
            });
    }
};
