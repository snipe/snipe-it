<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('asset_tag')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('serial')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 8, 2)->nullable();
            $table->string('order_number')->nullable();
            $table->integer('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->boolean('physical')->default(1);
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
        Schema::drop('assets');
    }

}
