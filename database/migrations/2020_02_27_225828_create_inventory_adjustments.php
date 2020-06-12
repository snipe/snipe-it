<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item_type')->index();
            $table->integer('item_id')->index();
            $table->string('from_state')->index();
            $table->string('to_state')->index();
            $table->integer('stock_location_id')->default(0)->index();
            $table->integer('qty');
            $table->dateTime('occurred_at', 3)->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('source_id')->index()->nullable()->default(null);
            $table->integer('reference_id')->index()->nullable()->default(null);
            $table->decimal('price',  20, 2)->nullable()->default(null);
            $table->text('notes')->nullable()->default(NULL);
            $table->timestamps();
            $table->index(['item_type', 'item_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_adjustments');
    }
}
