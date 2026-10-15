<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Snapshot the current `qty` on the three inventory tables (accessories,
 * consumables, components) into a companion `legacy_qty` column, so we
 * have a rollback lever if the replenish + reconcile flow that landed
 * in the same release turns out to have miscalculated any install's
 * on-hand quantity.
 *
 * Timestamped 143500 so it runs BEFORE the reconciliation migration
 * (2026_08_03_144000) that rewrites qty from the action_logs ledger.
 * That order matters for fresh installs upgrading through both
 * migrations in the same batch: the snapshot captures the pre-
 * reconciliation qty that a human admin had been maintaining, not the
 * ledger-derived value. Historical action_logs were incomplete on
 * early Snipe-IT versions, so the ledger sum can drift from the value
 * humans had been directly editing on the parent row.
 *
 * legacy_qty is intentionally not surfaced in the API, presenters,
 * exports, or UI. It's a safety-net column intended for a later
 * release to drop once we're confident the reconciliation + replenish
 * flow is producing correct values across all installs.
 */
return new class extends Migration
{
    private const TABLES = ['accessories', 'consumables', 'components'];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            if (! Schema::hasColumn($table, 'legacy_qty')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->integer('legacy_qty')->nullable();
                });
            }

            // Copy the current qty into legacy_qty for every row. Runs
            // once per install per Laravel's migration tracking.
            DB::table($table)->update(['legacy_qty' => DB::raw('qty')]);
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            if (Schema::hasColumn($table, 'legacy_qty')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('legacy_qty');
                });
            }
        }
    }
};
