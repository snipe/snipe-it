<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Rename `order_number` to `legacy_order_number` on the aggregate
 * inventory tables that moved to Orders / OrderItems. Preserves the
 * historical row-level value as a fallback under a new name. The
 * backfill migration has already copied non-null values into Order
 * rows, but keeping the raw column lets reports and audits reach it
 * if the polymorphic path ever needs to be cross-checked.
 *
 * Assets keep their own `order_number` column as the canonical
 * single-value acquisition reference — assets are 1:1 with a
 * transaction, and the column is still authoritative for that shape.
 *
 * Licenses are intentionally out of scope for this rename — the
 * License model isn't participating in the Orders flow yet
 * (per-seat product-key semantics need their own design pass).
 */
return new class extends Migration
{
    private const TABLES = [
        'accessories',
        'consumables',
        'components',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            if (! Schema::hasColumn($table, 'order_number')) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) {
                $t->renameColumn('order_number', 'legacy_order_number');
            });
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            if (! Schema::hasColumn($table, 'legacy_order_number')) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) {
                $t->renameColumn('legacy_order_number', 'order_number');
            });
        }
    }
};
