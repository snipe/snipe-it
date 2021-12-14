<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class CreateConsumablesGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumables_groups', function (Blueprint $table) {
            $table->integer('consumable_id')->unsigned();
			$table->integer('group_id')->unsigned();

            $table->engine = 'InnoDB';
			$table->primary(array('consumable_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables_groups', function (Blueprint $table) {
            Schema::drop('consumables_groups');
        });
    }
}
