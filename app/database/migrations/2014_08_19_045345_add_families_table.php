<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFamiliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('families', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name');
                        $table->string('common_name');
                        $table->text('notes');
                        $table->unique('name');
                        $table->unique('common_name');
                        $table->integer('user_id');
                        $table->timestamps();
                        $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('families');
	}

}
