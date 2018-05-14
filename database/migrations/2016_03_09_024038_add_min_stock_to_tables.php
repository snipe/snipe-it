<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinStockToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('accessories', function (Blueprint $table) {
        $table->integer('min_amt')->nullable()->default(NULL);
      });
      Schema::table('consumables', function (Blueprint $table) {
        $table->integer('min_amt')->nullable()->default(NULL);
      });
      Schema::table('components', function (Blueprint $table) {
        $table->integer('min_amt')->nullable()->default(NULL);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('accessories', function ($table) {
          $table->dropColumn('min_amt');
      });
      Schema::table('components', function ($table) {
          $table->dropColumn('min_amt');
      });
      Schema::table('consumables', function ($table) {
          $table->dropColumn('min_amt');
      });
    }
}
