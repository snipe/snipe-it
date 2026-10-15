<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Track partial fulfillment of qty-tracked CheckoutRequests. A
 * request for 5 pens that admin only has 3 of currently should
 * fulfill 3, stay pending, and let the admin come back to knock
 * out the remaining 2 later.
 *
 * Original `quantity` stays immutable so the audit trail preserves
 * what the requester actually asked for; the new
 * `fulfilled_quantity` is a running counter of how much has been
 * delivered so far. State stays `pending` until fulfilled_quantity
 * >= quantity, at which point FulfillCheckoutRequestAction flips
 * it to `fulfilled` and sets fulfilled_at + fulfilled_by.
 *
 * Backfill: existing fulfilled rows get fulfilled_quantity = quantity
 * (they were fully delivered, we just weren't tracking the counter).
 * Pending + canceled rows stay at 0 (nothing delivered yet).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table): void {
            if (! Schema::hasColumn('checkout_requests', 'fulfilled_quantity')) {
                $table->unsignedInteger('fulfilled_quantity')
                    ->default(0)
                    ->after('quantity');
            }
        });

        // Reconcile existing rows: a row currently marked fulfilled
        // was delivered in full under the pre-partial-tracking
        // behavior, so backfill its counter to match the requested
        // quantity. Pending + canceled rows stay at the default 0.
        DB::table('checkout_requests')
            ->where('state', 'fulfilled')
            ->update(['fulfilled_quantity' => DB::raw('quantity')]);
    }

    public function down(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table): void {
            if (Schema::hasColumn('checkout_requests', 'fulfilled_quantity')) {
                $table->dropColumn('fulfilled_quantity');
            }
        });
    }
};
