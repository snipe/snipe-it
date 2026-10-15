<?php

use App\Enums\ActionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Backfill created_by on legacy request + cancel action_logs rows.
 *
 * Both CreateCheckoutRequestAction and ViewAssetsController's request
 * paths historically wrote the Actionlog row without setting
 * created_by, so the activity report's "created by" column landed
 * blank for anything logged as 'requested' or 'request canceled'
 * before the follow-up fix.
 *
 * target_id was always set to auth()->id() by those callers, so it
 * is the correct value for created_by on backfilled rows. Guarded on
 * target_type = App\Models\User to skip any exotic historical rows
 * whose target isn't a user (defensive - the request paths only ever
 * targeted users).
 *
 * Only touches rows where created_by IS NULL so re-running the
 * migration is a no-op and rows the fix already wrote correctly stay
 * untouched. Chunked per-row copy rather than one big cross-column
 * UPDATE so large install histories don't hold a single row-level
 * lock across the full backfill.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('action_logs')
            ->whereIn('action_type', [
                ActionType::Requested->value,
                ActionType::RequestCanceled->value,
            ])
            ->whereNull('created_by')
            ->whereNotNull('target_id')
            ->where('target_type', \App\Models\User::class)
            ->orderBy('id')
            ->chunkById(500, function ($rows): void {
                foreach ($rows as $row) {
                    DB::table('action_logs')
                        ->where('id', $row->id)
                        ->update(['created_by' => $row->target_id]);
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
