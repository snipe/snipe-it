<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->string('name');
            $table->string('status')->default("START");
            $table->string('device')->nullable();
            $table->integer('responsible_id');
            $table->string('responsible');
            $table->binary('responsible_photo')->nullable();
            $table->string('coords')->nullable();
            $table->longText('log')->nullable();
            $table->longText('comment')->nullable();
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->string('name')->nullable();
            $table->longText('notes')->nullable();
            $table->string('model');
            $table->string('category');
            $table->string('manufacturer')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('tag');
            $table->string('photo')->nullable();
            $table->boolean('checked')->default(false);
            $table->boolean('broken')->default(false);
            $table->dateTime('checked_at', 0)->nullable();
            $table->integer('asset_id')->unsigned();
            $table->foreign('asset_id')->references('id')->on('assets')
                ->onDelete('cascade');
            $table->integer('inventory_id')->unsigned();
            $table->foreign('inventory_id')->references('id')->on('inventories')
                ->onDelete('cascade');
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
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropForeign(['inventory_id']);
            $table->dropForeign(['asset_id']);
        });
        Schema::drop('inventories');
        Schema::drop('inventory_items');
    }
}
