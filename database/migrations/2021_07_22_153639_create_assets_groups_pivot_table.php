<?php


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_groups', function (Blueprint $table) {
            $table->integer('asset_id')->unsigned();
			$table->integer('group_id')->unsigned();

            $table->engine = 'InnoDB';
			$table->primary(array('asset_id', 'group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets_groups', function (Blueprint $table) {
            Schema::drop('assets_groups');
        });
    }
}
