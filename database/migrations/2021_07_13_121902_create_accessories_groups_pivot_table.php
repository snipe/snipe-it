<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class CreateAccessoriesGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories_groups', function (Blueprint $table) {
            $table->integer('accessory_id')->unsigned();
			$table->integer('group_id')->unsigned();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->primary(array('accessory_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accessories_groups');
    }
}
