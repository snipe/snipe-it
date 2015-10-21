<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateMacAddress extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		//create empty 'default' fieldset'
		Fieldset::create({name: "Plain Asset"});
		$f2=Fieldset::create({name: "Asset with MAC Address"});
		$f2->fields()->create({name: "MAC Address",required: false, order: 1});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
