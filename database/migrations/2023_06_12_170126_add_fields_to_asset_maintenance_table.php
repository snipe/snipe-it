<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAssetMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_maintenances', function (Blueprint $table) {
            $table->integer('assigned_to')->after('user_id')->default(null)->nullable();
            $table->integer('repairer')->after('assigned_to')->default(null)->nullable();
            $table->integer('asset_maintenance_location')->after('asset_maintenance_type')->default(null)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('to_asset_maintenance', function (Blueprint $table) {
            $table->dropColumn('assigned_to');
            $table->dropColumn('repairer');
            $table->dropColumn('asset_maintenance_location');
        });
    }
}
