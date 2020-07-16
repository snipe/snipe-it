<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumablesLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumables_locations', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('consumable_id')->nullable()->default(NULL);
            $table->integer('assigned_to')->nullable()->default(NULL);
            $table->integer('quantity')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('consumables_locations');
    }
}
