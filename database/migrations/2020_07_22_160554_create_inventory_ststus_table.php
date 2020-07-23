<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryStstusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_status_labels', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name',100)->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('success')->default(0);
            $table->text('notes')->nullable();
            $table->string('color', 10)->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('broken');
            $table->dropColumn('photo');
            $table->string('photo')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('inventory_status_labels')
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
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->boolean('broken')->default(false);
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
            $table->dropColumn('photo');
        });

        Schema::dropIfExists('inventory_status_labels');
    }
}
