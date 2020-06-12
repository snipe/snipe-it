<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemsLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('inventory_items_locations', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('item_type')->index();
        $table->integer('item_id')->index();
        $table->integer('stock_location_id')->default(0)->index();
        $table->integer('min_amt')->nullable();
        $table->timestamps();
        $table->index(['item_type', 'item_id']);  
        $table->unique(['item_type', 'item_id', 'stock_location_id'], 'unique_item_location');        
      });

      
        // Add accessory item locations
        DB::insert('INSERT INTO `inventory_items_locations` (item_type, item_id, stock_location_id, created_at, updated_at)
          SELECT "App\\\Models\\\Accessory" as "item_type", id as "item_id", ifnull(location_id,0) as "stock_location_id", NOW() as created_at, NOW() as updated_at
          FROM `accessories`
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('inventory_items_locations');
    }
}
