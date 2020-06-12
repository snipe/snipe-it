<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryReconciles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_reconciles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item_type')->index();
            $table->integer('item_id')->index();
            $table->string('state')->index();
            $table->integer('stock_location_id')->default(0)->index();
            $table->integer('qty');
            $table->dateTime('occurred_at', 3)->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('source_id')->index()->nullable()->default(null);
            $table->integer('reference_id')->index()->nullable()->default(null);
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
        Schema::dropIfExists('inventory_reconciles');
    }

}
