<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTypteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_types', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->string('name');
            $table->integer('bitrix_id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
         Schema::create('legal_persons', function (Blueprint $table) {
             $table->softDeletes();
             $table->increments('id');
             $table->string('name');
             $table->integer('bitrix_id');
             $table->timestamps();
             $table->engine = 'InnoDB';
         });
        Schema::table('purchases', function (Blueprint $table) {
            $table->integer('invoice_type_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types')
                ->onDelete('cascade');
            $table->integer('legal_person_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('legal_person_id')->references('id')->on('legal_persons')
                ->onDelete('cascade');
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
            $table->dropForeign(['invoice_type_id']);
            $table->dropForeign(['legal_person_id']);
        });

        Schema::dropIfExists('invoice_types');
        Schema::dropIfExists('legal_persons');
    }
}
