<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class CreateKitsGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kits_groups', function (Blueprint $table) {
            $table->integer('kit_id')->unsigned();
			$table->integer('group_id')->unsigned();

            $table->engine = 'InnoDB';
			$table->primary(array('kit_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kits_groups', function (Blueprint $table) {
            Schema::drop('kits_groups');
        });
    }
}
