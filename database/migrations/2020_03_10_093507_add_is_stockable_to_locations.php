<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsStockableToLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('locations', function (Blueprint $table) {
        $table->boolean('is_stockable')->default('1');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('locations', function (Blueprint $table) {
        $table->dropColumn('is_stockable');
      });
    }
}
