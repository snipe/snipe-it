<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('quality')->unsigned()->nullable();
            $table->decimal('depreciable_cost', 8, 2)->nullable();
        });
        Schema::table('models', function (Blueprint $table) {

            $table->integer('lifetime')->unsigned()->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {

            $table->integer('lifetime')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('quality');
            $table->dropColumn('depreciable_cost');
        });
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn('lifetime');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('lifetime');
        });
    }
}
