<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultLabelToNullable extends Migration
{
    /**
     * Run the migrations.
     * 
     * This is stupid because it has a default valuye of 0 so it *should* 
     * default to 0, but it doesn't on some versions of MySQL. 
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nullable', function (Blueprint $table) {
            Schema::table('status_labels', function (Blueprint $table) {
                $table->boolean('default_label')->nullable()->default(0);
                $table->boolean('show_in_nav')->nullable()->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nullable', function (Blueprint $table) {
            //
        });
    }
}
