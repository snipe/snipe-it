<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class CreateComponentsGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components_groups', function (Blueprint $table) {
            $table->integer('component_id')->unsigned();
			$table->integer('group_id')->unsigned();

            $table->engine = 'InnoDB';
			$table->primary(array('component_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components_groups', function (Blueprint $table) {
            Schema::drop('components_groups');
        });
    }
}
