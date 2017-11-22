<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_logs', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('action_type');
            $table->integer('asset_id');
            $table->integer('checkedout_to')->nullable();
            $table->integer('location_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asset_logs');
    }
}
