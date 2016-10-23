<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesToModels extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
  public function up()
 	{
 		Schema::table('models', function ($table) {
 			$table->text('note')->nullable()->default(NULL);
 		});
 	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::table('models', function ($table) {
        $table->dropColumn('note');
    });
	}

}
