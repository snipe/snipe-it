<?php

use App\Enums\CheckoutRequestState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Give CheckoutRequest a real state machine. Prior shape was a
 * two-state model (open vs. canceled_at) with a dangling
 * `fulfilled_at` column added in 2018 that nothing ever wrote. The
 * new state column drives every lifecycle decision (rendering, gate
 * checks, scheduler, admin queue) so there's a single source of
 * truth for "where is this request in its life."
 *
 * canceled_at + fulfilled_at stay in the schema. They now write in
 * lock-step with state transitions - the datetime says WHEN, the
 * state column says WHAT. Existing rows backfill in three passes:
 *   1. Default: state=pending (schema-side default).
 *   2. canceled_at set: state=canceled.
 *   3. fulfilled_at OR fulfilled_by set: state=fulfilled.
 * Fulfilled runs last so a row with both a canceled_at and evidence
 * of fulfillment (edge case, but real if someone was manually
 * poking data via tinker or an import) resolves to fulfilled - the
 * semantic being "actually received the item" trumps an earlier
 * cancel intent.
 *
 * checkout_actionlog_id is the audit link back to the checkout that
 * fulfilled the request. Without this column the item's history tab
 * would need a separate "request fulfilled" actionlog row per
 * fulfillment, doubling every checkout in the timeline for
 * requested items. See CheckoutRequestState + FulfillCheckoutRequestAction
 * for the wiring.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table): void {
            if (! Schema::hasColumn('checkout_requests', 'state')) {
                $table->string('state', 20)
                    ->default(CheckoutRequestState::Pending->value)
                    ->after('notes');
            }
            if (! Schema::hasColumn('checkout_requests', 'fulfilled_by')) {
                $table->unsignedBigInteger('fulfilled_by')
                    ->nullable()
                    ->after('fulfilled_at');
            }
            if (! Schema::hasColumn('checkout_requests', 'checkout_actionlog_id')) {
                $table->unsignedBigInteger('checkout_actionlog_id')
                    ->nullable()
                    ->after('fulfilled_by');
            }
        });

        // Backfill BEFORE indexing so the composite index covers real
        // values instead of the default-string writes for every row.
        // Order matters: cancel first, then fulfilled - a row with
        // both set resolves to fulfilled (see class docblock).
        DB::table('checkout_requests')
            ->whereNotNull('canceled_at')
            ->where('state', CheckoutRequestState::Pending->value)
            ->update(['state' => CheckoutRequestState::Canceled->value]);

        DB::table('checkout_requests')
            ->where(function ($q) {
                $q->whereNotNull('fulfilled_at')
                    ->orWhereNotNull('fulfilled_by');
            })
            ->update(['state' => CheckoutRequestState::Fulfilled->value]);

        Schema::table('checkout_requests', function (Blueprint $table): void {
            // Composite index for the "open request for this
            // requestable" lookup that every checkout-hook + admin-
            // queue query hits. Guard against re-add on partial
            // re-runs.
            $indexes = collect(Schema::getIndexes('checkout_requests'))
                ->pluck('name')
                ->all();

            if (! in_array('checkout_requests_requestable_state_index', $indexes, true)) {
                $table->index(
                    ['requestable_type', 'requestable_id', 'state'],
                    'checkout_requests_requestable_state_index'
                );
            }

            if (! in_array('checkout_requests_fulfilled_by_index', $indexes, true)) {
                $table->index('fulfilled_by');
            }

            if (! in_array('checkout_requests_checkout_actionlog_id_index', $indexes, true)) {
                $table->index('checkout_actionlog_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table): void {
            $indexes = collect(Schema::getIndexes('checkout_requests'))
                ->pluck('name')
                ->all();

            if (in_array('checkout_requests_requestable_state_index', $indexes, true)) {
                $table->dropIndex('checkout_requests_requestable_state_index');
            }
            if (in_array('checkout_requests_fulfilled_by_index', $indexes, true)) {
                $table->dropIndex('checkout_requests_fulfilled_by_index');
            }
            if (in_array('checkout_requests_checkout_actionlog_id_index', $indexes, true)) {
                $table->dropIndex('checkout_requests_checkout_actionlog_id_index');
            }

            if (Schema::hasColumn('checkout_requests', 'checkout_actionlog_id')) {
                $table->dropColumn('checkout_actionlog_id');
            }
            if (Schema::hasColumn('checkout_requests', 'fulfilled_by')) {
                $table->dropColumn('fulfilled_by');
            }
            if (Schema::hasColumn('checkout_requests', 'state')) {
                $table->dropColumn('state');
            }
        });
    }
};
