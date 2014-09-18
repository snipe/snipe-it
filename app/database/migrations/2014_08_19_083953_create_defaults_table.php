<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('defaults', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
                        $table->softDeletes();
                        $table->string('name');
                        $table->string('table_name');
                        $table->string('column_name');
                        $table->string('value');
                        $table->string('source_table');
                        $table->integer('user_id');
		});
                               
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('defaults');
                
	}

}
