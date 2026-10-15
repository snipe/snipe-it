<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Follow-up index coverage for the Orders / OrderItems tables that
 * the initial create migration didn't include.
 *
 * `orders(order_number, supplier_id, company_id)` composite: matches
 * the dedupe key used by every firstOrCreate on Orders (adjust-quantity
 * flow, AssetObserver::created, ItemImporter). Without it MySQL /
 * MariaDB pick one of the single-column indexes and filter the rest,
 * which gets progressively slower as the orders table grows. The
 * existing single-column indexes stay because supplier_id and
 * company_id are also filtered on their own (e.g. FMCS scoping).
 *
 * `deleted_at` indexes on both tables: every Eloquent read appends an
 * implicit `WHERE deleted_at IS NULL` from SoftDeletes. Cheap now,
 * hot spot later on any install with a heavy history of adjustments.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index(
                ['order_number', 'supplier_id', 'company_id'],
                'orders_order_number_supplier_id_company_id_index',
            );
            $table->index('deleted_at');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_order_number_supplier_id_company_id_index');
            $table->dropIndex(['deleted_at']);
        });
    }
};
