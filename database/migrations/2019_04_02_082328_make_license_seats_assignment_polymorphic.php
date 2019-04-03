<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLicenseSeatsAssignmentPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Add type field
        Schema::table('license_seats', function (Blueprint $table) {
            $table->string('assigned_type')->nullable();
        });

        # Migrate old structure to new polymorphic structure
        DB::table('license_seats')
            ->whereNotNull('assigned_to')
            ->update(['assigned_type' => App\Models\User::class]);

        DB::table('license_seats')
            ->whereNotNull('asset_id')
            ->update(['assigned_type' => App\Models\Asset::class, 'assigned_to' => DB::raw('asset_id')]);

        # Remove unnecessary field asset_id
        Schema::table('license_seats', function (Blueprint $table) {
            $table->dropColumn('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        # Add field for assets
        Schema::table('license_seats', function (Blueprint $table) {
            $table->integer('asset_id')->nullable()->default(NULL);
        });

        # Migrate polymorphic structure to old structure
        DB::table('license_seats')
            ->where('assigned_type', '=', App\Models\Asset::class)
            ->update(['asset_id' => DB::raw('assigned_to')]);

        DB::table('license_seats')
            ->where('assigned_type', '=', App\Models\Asset::class)
            ->update(['assigned_to' => NULL]);

        # Remove unnecessary field assigned_type
        Schema::table('license_seats', function (Blueprint $table) {
            $table->dropColumn('assigned_type');
        });
    }
}
