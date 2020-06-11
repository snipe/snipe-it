<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchasesAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->string('invoice_number');
            $table->string('invoice_file');
            $table->integer('bitrix_id')->nullable();
            $table->float('final_price', 8, 2);
            $table->boolean('paid')->default(false);
            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onDelete('cascade');
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });
        Schema::drop('purchases');
    }
}
