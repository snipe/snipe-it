<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Turns maintenances into a polymorphic child so it can be attached
 * to accessories (and any other checkoutable) in future, not just
 * assets:
 *
 *   asset_id (int) -> item_id (int)
 *   [new] item_type (string, default App\Models\Asset)
 *
 * Existing rows all belong to assets, so item_type is backfilled to
 * the Asset FQCN in the same migration and then indexed together
 * with item_id for polymorphic lookup speed.
 *
 * The Maintenance model keeps ->asset() and $maintenance->asset_id
 * working as legacy accessors on top of the new columns so callers
 * (view templates, transformers, controller filters, external API
 * consumers) don't break. New callers should use ->item() / item_id
 * / item_type directly.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Rename first, add the type column second, backfill third.
        // Splitting rename into its own Schema::table() call avoids
        // MySQL "cannot rename a column that's about to be indexed"
        // combined-DDL edge cases.
        Schema::table('maintenances', function (Blueprint $table) {
            if (Schema::hasColumn('maintenances', 'asset_id') && ! Schema::hasColumn('maintenances', 'item_id')) {
                $table->renameColumn('asset_id', 'item_id');
            }
        });

        Schema::table('maintenances', function (Blueprint $table) {
            if (! Schema::hasColumn('maintenances', 'item_type')) {
                $table->string('item_type')->after('item_id')->nullable();
            }
        });

        // Backfill: every pre-existing maintenance is against an
        // asset. Do this before adding the composite index so index
        // build sees the final values.
        DB::table('maintenances')
            ->whereNull('item_type')
            ->update(['item_type' => \App\Models\Asset::class]);

        Schema::table('maintenances', function (Blueprint $table) {
            $table->index(['item_type', 'item_id'], 'maintenances_item_type_item_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropIndex('maintenances_item_type_item_id_index');
        });

        Schema::table('maintenances', function (Blueprint $table) {
            if (Schema::hasColumn('maintenances', 'item_type')) {
                $table->dropColumn('item_type');
            }
        });

        Schema::table('maintenances', function (Blueprint $table) {
            if (Schema::hasColumn('maintenances', 'item_id') && ! Schema::hasColumn('maintenances', 'asset_id')) {
                $table->renameColumn('item_id', 'asset_id');
            }
        });
    }
};
