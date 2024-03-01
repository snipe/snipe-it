<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserLocationToMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_maintenances', function (Blueprint $table) {
            $table->string('assigned_type')->nullable()->default(null);
            $table->integer('assigned_to')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_maintenances', function (Blueprint $table) {
            if (Schema::hasColumn('asset_maintenances', 'assigned_type')) {
                $table->dropColumn('assigned_type');
            }

            if (Schema::hasColumn('assigned_to', 'assigned_to')) {
                $table->dropColumn('assigned_to');
            }
        });
    }
}
