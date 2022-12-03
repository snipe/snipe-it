<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_rent_order', function (Blueprint $table) {
            $table->unsignedInteger("asset_id");
            $table->unsignedBigInteger("rent_order_id");

            $table->foreign("asset_id")->references("id")->on("assets")->cascadeOnDelete();
            $table->foreign("rent_order_id")->references("id")->on("rent_orders")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_rent_order');
    }
}
