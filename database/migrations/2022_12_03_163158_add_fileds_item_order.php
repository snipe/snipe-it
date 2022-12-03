<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledsItemOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_orders', function (Blueprint $table) {
            $table->integer('state')->default(0); 
            // 0 Sin cargar, 1 Cargada, 2 Cancelado
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
            $table->dropColumn('state');
        });
    }
}
