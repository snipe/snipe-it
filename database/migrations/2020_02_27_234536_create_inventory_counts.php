<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryCounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_counts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item_type')->index();
            $table->integer('item_id')->index();
            $table->string('state')->index();
            $table->integer('stock_location_id')->default(0)->index();
            $table->integer('qty');
            $table->dateTime('occurred_at')->index();
            $table->timestamps();
            $table->index(['item_type', 'item_id']);  
            $table->index(['item_type', 'item_id', 'state', 'stock_location_id'], 'index_item_location_state_index');
            $table->unique(['item_type', 'item_id', 'state', 'stock_location_id', 'occurred_at'], 'unique_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_counts');
    }
}
