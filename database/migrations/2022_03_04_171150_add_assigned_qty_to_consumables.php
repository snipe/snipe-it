<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedQtyToConsumables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumables_users', function (Blueprint $table) {
            $table->integer('assigned_qty')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables_users', function (Blueprint $table) {
            if (Schema::hasColumn('consumables_users', 'assigned_qty')) {
                $table->dropColumn('assigned_qty');
            }
        });
    }
}
