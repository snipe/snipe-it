<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address',50)->nullable()->default(NULL);
            $table->string('address2',50)->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('state',2)->nullable()->default(NULL);
            $table->string('country',2)->nullable()->default(NULL);
            $table->string('phone',20)->nullable()->default(NULL);
            $table->string('fax',20)->nullable()->default(NULL);
            $table->string('email',150)->nullable()->default(NULL);
            $table->string('contact',100)->nullable()->default(NULL);
            $table->string('notes')->nullable()->default(NULL);
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->softDeletes();
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
        //
        Schema::drop('suppliers');
    }

}
