<?php

use App\Enums\ActionType;
use App\Models\Accessory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Backfill action_logs.quantity for legacy accessory bulk-checkout
 * rows.
 *
 * Before commits 06224371b3 (API, 2025-12-15) and ea4374a855 (web,
 * 2026-04-14), AccessoriesController and AccessoryCheckoutController
 * fired CheckoutableCheckedOut without a $quantity argument. Bulk
 * checkouts wrote N accessories_checkout pivot rows correctly but
 * one action_logs row with quantity=1, so history tables under-
 * reported checkout qty on every bulk event. Snipe-IT installs
 * upgraded from a version predating those commits carry the
 * mis-recorded rows and inventory reconciliations run off history
 * come out short.
 *
 * Reconciliation:
 *   - Candidate: action_logs where item_type=Accessory,
 *     action_type=checkout, quantity=1.
 *   - Match: accessories_checkout rows with the same
 *     (accessory_id, target, note, created_by) tuple whose
 *     created_at falls within a 15-second window centered on the
 *     log's created_at.
 *   - Fix: set action_logs.quantity to the matched pivot count when
 *     that count > 1.
 *
 * The pre-fix write path called Carbon::now() per pivot-loop
 * iteration and again when the event fired, so pivot created_at is
 * slightly earlier than log created_at. A 15-second window absorbs
 * that drift plus any wall-clock skew without merging two
 * legitimate rapid-fire manual checkouts to the same target with
 * the same note.
 *
 * Idempotent. Re-running finds no candidates left because every
 * previously-fixed row has quantity>1 and is filtered out.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('action_logs')
            ->where('item_type', Accessory::class)
            ->where('action_type', ActionType::Checkout->value)
            ->where('quantity', 1)
            ->whereNotNull('created_at')
            ->whereNotNull('item_id')
            ->whereNotNull('target_id')
            ->whereNotNull('target_type')
            ->orderBy('id')
            ->chunkById(500, function ($rows): void {
                foreach ($rows as $row) {
                    $logTs = strtotime($row->created_at);
                    $windowStart = date('Y-m-d H:i:s', $logTs - 15);
                    $windowEnd = date('Y-m-d H:i:s', $logTs + 15);

                    $pivotCount = DB::table('accessories_checkout')
                        ->where('accessory_id', $row->item_id)
                        ->where('assigned_to', $row->target_id)
                        ->where('assigned_type', $row->target_type)
                        ->where(function ($query) use ($row) {
                            if ($row->created_by === null) {
                                $query->whereNull('created_by');
                            } else {
                                $query->where('created_by', $row->created_by);
                            }
                        })
                        ->where(function ($query) use ($row) {
                            if ($row->note === null || $row->note === '') {
                                $query->whereNull('note')->orWhere('note', '');
                            } else {
                                $query->where('note', $row->note);
                            }
                        })
                        ->whereBetween('created_at', [$windowStart, $windowEnd])
                        ->count();

                    if ($pivotCount > 1) {
                        DB::table('action_logs')
                            ->where('id', $row->id)
                            ->update(['quantity' => $pivotCount]);
                    }
                }
            });
    }

    public function down(): void
    {
        // No-op. Rows we backfilled here are indistinguishable from
        // rows that were correctly populated at write time, so a
        // targeted revert isn't possible without a marker column we
        // don't need in production.
    }
};
