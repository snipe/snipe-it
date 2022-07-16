<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumablesStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumables_stock', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('user_id');                        
            $table->integer('consumable_id')->nullable()->default(null);
            $table->integer('initial_qty');       
            $table->integer('total_replenish');                                         
            $table->string('replenish_note')->nullable()->default(null);
            $table->string('order_number')->nullable()->default(null);
            $table->string('file')->nullable()->default(null);
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
        Schema::dropIfExists('consumables_stock');
    }
}
