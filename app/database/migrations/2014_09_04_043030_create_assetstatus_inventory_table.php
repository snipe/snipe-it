<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetstatusInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_states', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name');
                        $table->string('notes')->nullable();
                        $table->integer('user_id');
                        $table->timestamps();
                        $table->softDeletes();
                        $table->unique('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventory_states');
	}

}
