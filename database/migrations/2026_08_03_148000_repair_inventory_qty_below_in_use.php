<?php

use App\Models\Accessory;
use App\Models\Component;
use App\Models\Consumable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Data-repair pass for installs that already ran the pre-fix version
 * of `2026_08_03_144000_reconcile_inventory_qty_from_action_logs.php`.
 *
 * The pre-fix reconcile migration overwrote `qty` on legacy
 * accessories / consumables / components with `SUM(action_logs.quantity)`
 * for `create` + `qty_adjust` events. Pre-replenish deployments never
 * populated that column for `create` events, so the sum came out at 0
 * or a stray small value, and the migration blindly wrote it. Rows
 * with existing checkouts got dragged below the in-use count and
 * rendered as "-N Remaining" in the UI (issue observed on the
 * grokability.com production instance post-upgrade).
 *
 * This migration is a floor-restorer. For every accessory / consumable
 * / component where the current `qty` is below the count of units
 * currently in use, `qty` is bumped up to that in-use count so the UI
 * stops rendering negative remaining. This does not recover the true
 * pre-upgrade qty — that data was overwritten and there's no ledger
 * to reconstruct from — the admin still needs to run adjust-quantity
 * per item to re-establish an accurate count.
 *
 * The repair is idempotent: on installs where the fixed reconcile
 * migration has run and no drift exists, every row has qty >= in-use
 * and this is a no-op.
 *
 * License is deliberately excluded, matching the scope of the
 * reconcile migration that caused the damage.
 */
return new class extends Migration
{
    private const REPAIR_MODELS = [
        Accessory::class,
        Consumable::class,
        Component::class,
    ];

    public function up(): void
    {
        foreach (self::REPAIR_MODELS as $modelClass) {
            $this->repairFor($modelClass);
        }
    }

    public function down(): void
    {
        // No-op. Reversing the repair would set qty back to a value
        // that renders as negative remaining, which is the bug this
        // migration exists to fix.
    }

    private function repairFor(string $modelClass): void
    {
        $modelClass::query()->chunkById(500, function ($rows) use ($modelClass) {
            foreach ($rows as $model) {
                $inUse = method_exists($model, 'currentlyInUseCount')
                    ? (int) $model->currentlyInUseCount()
                    : 0;

                $actual = (int) $model->qty;

                if ($actual >= $inUse) {
                    continue;
                }

                Log::info(sprintf(
                    'Repairing %s#%d qty: %d -> %d (below in-use count)',
                    $modelClass,
                    $model->id,
                    $actual,
                    $inUse,
                ));

                // Direct DB update, same rationale as the reconcile
                // migration: bypass the AdjustsQuantity trait so no
                // spurious `qty_adjust` action_log is written for a
                // data-integrity repair the admin didn't request.
                DB::table((new $modelClass)->getTable())
                    ->where('id', $model->id)
                    ->update(['qty' => $inUse]);
            }
        });
    }
};
