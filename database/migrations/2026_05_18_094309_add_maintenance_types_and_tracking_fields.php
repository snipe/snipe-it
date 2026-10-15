<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       
        if (!Schema::hasTable('maintenance_types')) {
            Schema::create('maintenance_types', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

            // Seed with the 8 built-in types. Only runs on the fresh-create
            // path so we don't duplicate rows when the table already existed.
            $now = now();
            $types = [
                'Maintenance',
                'Repair',
                'Upgrade',
                'PAT Test',
                'Calibration',
                'Software Support',
                'Hardware Support',
                'Configuration Change',
            ];

            foreach ($types as $name) {
                DB::table('maintenance_types')->insert([
                    'name' => $name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Add new tracking columns and the maintenance_type FK to maintenances
        if (!Schema::hasColumn('maintenances', 'maintenance_type_id')) {
            Schema::table('maintenances', function (Blueprint $table) {
                $table->unsignedBigInteger('maintenance_type_id')->nullable();
                $table->unsignedBigInteger('checked_out_to_id')->nullable();
                $table->string('checked_out_to_type')->nullable();
                $table->unsignedBigInteger('responsible_party_id')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->unsignedBigInteger('completed_by')->nullable();
            });
        }

        // Map existing asset_maintenance_type strings to the new FK.
        // The stored values are the same strings we just seeded into maintenance_types.
        // `whereNull('maintenance_type_id')` keeps this safe to re-run.
        $types = DB::table('maintenance_types')->pluck('id', 'name');

        foreach ($types as $name => $id) {
            DB::table('maintenances')
                ->whereNull('maintenance_type_id')
                ->where('asset_maintenance_type', $name)
                ->update(['maintenance_type_id' => $id]);
        }
    }

    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'maintenance_type_id',
                'checked_out_to_id',
                'checked_out_to_type',
                'responsible_party_id',
                'completed_at',
                'completed_by',
            ]);
        });

        Schema::dropIfExists('maintenance_types');
    }
};
