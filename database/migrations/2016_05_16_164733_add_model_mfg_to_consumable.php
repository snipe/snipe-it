<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModelMfgToConsumable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumables', function (Blueprint $table) {
            $table->integer('model_no')->nullable()->default(NULL);
            $table->integer('manufacturer_id')->nullable()->default(NULL);
            $table->string('item_no')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables', function ($table) {
            $table->dropColumn(
                'model_no',
                'manufacturer_id',
                'item_no'
            );
        });
    }
}
