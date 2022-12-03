<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableItemsOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id');
            $table->unsignedInteger('item_id');
            $table->string('item_type');
            $table->integer('supplier_id');
            $table->integer('total')->default(0); // Lo que necesita
            $table->integer('total_final')->default(0); // Lo que llega
            $table->timestamps();
            $table->index('supplier_id');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->integer('user_id');
            $table->index('user_id');
            $table->date('initial_date')->nullable();
            $table->date('recibed_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_orders', function (Blueprint $table) {
            Schema::dropIfExists('items_orders');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropIndex('user_id');
        });
    }
}
