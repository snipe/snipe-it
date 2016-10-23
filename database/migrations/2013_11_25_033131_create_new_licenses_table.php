<?php

use Illuminate\Database\Migrations\Migration;

class CreateNewLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('licenses', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('serial')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 8, 2)->nullable();
            $table->string('order_number');
            $table->integer('seats')->default(1);
            $table->text('notes')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('depreciation_id')->nullable();
            $table->timestamps();
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
        Schema::drop('licenses');
    }

}
