<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ChangeLicenseNotesType extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$prefix = DB::getTablePrefix();
		 DB::statement('ALTER TABLE '.$prefix.'licenses MODIFY COLUMN notes TEXT');
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		$prefix = DB::getTablePrefix();
		 DB::statement('ALTER TABLE '.$prefix.'licenses MODIFY COLUMN notes VARCHAR(255)');
	}
}
