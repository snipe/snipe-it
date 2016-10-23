<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupFieldForReporting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		// Schema::table('groups', function(Blueprint $table)
		// {
		// 	//
		// });

    DB::update('update '.DB::getTablePrefix().'groups set permissions = ? where id = ?', ['{"admin":1,"users":1,"reports":1}', 1]);

    DB::update('update '.DB::getTablePrefix().'groups set permissions = ? where id = ?', ['{"users":1,"reports":1}', 2]);

      // DB::statement('UPDATE '.$prefix.'groups SET permissions="{\"admin\":1,\"users\":1,\"reports\":1}" where id=1');
      // DB::statement('UPDATE '.$prefix.'groups SET permissions="{\"users\":1,\"reports\":1}" where id=2');

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
