<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesToConsumables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumables', function (Blueprint $table) {
            $table->integer('purchase_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('purchase_id')->references('id')->on('purchases')
                ->onDelete('cascade');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->longText('consumables_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->dropColumn('purchase_id');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('consumables_json');
        });
    }
}
