<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item_type')->index();
            $table->integer('item_id')->index();
            $table->string('state')->index();
            $table->integer('from_stock_location_id')->nullable()->index();
            $table->integer('to_stock_location_id')->default(0)->index();
            $table->integer('qty');
            $table->dateTime('occurred_at')->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('source_id')->index()->nullable()->default(null);
            $table->integer('reference_id')->index()->nullable()->default(null);
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
        Schema::dropIfExists('inventory_transfers');
    }
}
