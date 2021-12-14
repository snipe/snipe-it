<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class CreateLicensesGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses_groups', function (Blueprint $table) {
            $table->integer('license_id')->unsigned();
			$table->integer('group_id')->unsigned();

            $table->engine = 'InnoDB';
			$table->primary(array('license_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenses_groups', function (Blueprint $table) {
            Schema::drop('licenses_groups');
        });
    }
}
