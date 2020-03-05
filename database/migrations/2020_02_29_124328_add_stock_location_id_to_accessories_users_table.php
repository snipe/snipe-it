<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockLocationIdToAccessoriesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('accessories_users', function (Blueprint $table) {
          $table->integer('stock_location_id')->default(0);
        });
        DB::update('UPDATE `accessories_users` inner join `accessories` on `accessories`.`id` = `accessories_users`.`accessory_id` SET `accessories_users`.`stock_location_id` = `accessories`.`location_id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessories_users', function (Blueprint $table) {
            $table->dropColumn('stock_location_id');
        });
    }
}
