<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('item_id');
            $table->string('item_type');
            $table->unsignedInteger('target_id');
            $table->string('target_type');
            $table->unsignedInteger('location_id');
            $table->text('notes')->nullable();
            $table->dateTime('expected_checkin')->nullable();
            $table->dateTime('checkout_at');
            $table->dateTime('checkin_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Checkout');
    }
}
