<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Rename the transaction-scoped fields on the aggregate inventory
 * tables so they either serve as forward-use defaults for new orders
 * or make writes hard-fail (for the columns with no forward semantic).
 *
 * Renamed:
 *   accessories, consumables, components:
 *     supplier_id    → default_supplier_id   (parent "typical" supplier;
 *                                             pre-populates new Orders
 *                                             but overridable per-line)
 *     purchase_cost  → default_purchase_cost (parent "typical" unit cost;
 *                                             pre-populates new Orders)
 *     purchase_date  → legacy_purchase_date  (no meaningful default
 *                                             semantic for a date;
 *                                             historical only, drop
 *                                             candidate in a later version)
 *
 * The `default_*` fields shift the parent toward an AssetModel-shaped
 * "template" for future acquisitions. Editing the parent updates the
 * defaults; each Order/OrderItem still carries its own overrides so
 * lifetime acquisition history stays honest.
 *
 * Assets keep these columns as-is (1:1 with a transaction). Licenses
 * are out of scope for the current Orders PR.
 */
return new class extends Migration
{
    private const TABLES = [
        'accessories',
        'consumables',
        'components',
    ];

    private const FIELDS = [
        'supplier_id' => 'default_supplier_id',
        'purchase_date' => 'legacy_purchase_date',
        'purchase_cost' => 'default_purchase_cost',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            foreach (self::FIELDS as $current => $legacy) {
                if (Schema::hasColumn($table, $current) && ! Schema::hasColumn($table, $legacy)) {
                    Schema::table($table, function (Blueprint $t) use ($current, $legacy) {
                        $t->renameColumn($current, $legacy);
                    });
                }
            }
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            foreach (self::FIELDS as $current => $legacy) {
                if (Schema::hasColumn($table, $legacy) && ! Schema::hasColumn($table, $current)) {
                    Schema::table($table, function (Blueprint $t) use ($current, $legacy) {
                        $t->renameColumn($legacy, $current);
                    });
                }
            }
        }
    }
};
