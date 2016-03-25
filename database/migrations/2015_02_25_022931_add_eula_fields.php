<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEulaFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('settings', function ($table) {
			$table->longText('default_eula_text')->nullable()->default(NULL);
		});

		Schema::table('categories', function ($table) {
			$table->longText('eula_text')->nullable()->default(NULL);
			$table->boolean('use_default_eula')->default(0);
			$table->boolean('require_acceptance')->default(0);
		});

		Schema::table('asset_logs', function ($table) {
			$table->dateTime('requested_at')->nullable()->default(NULL);
			$table->dateTime('accepted_at')->nullable()->default(NULL);
		});


    Schema::create('requested_assets', function ($table) {
        $table->increments('id');
        $table->integer('asset_id')->default(NULL);
        $table->integer('user_id')->default(NULL);
        $table->dateTime('accepted_at')->nullable()->default(NULL);
        $table->dateTime('denied_at')->nullable()->default(NULL);
        $table->string('notes')->default(NULL);
        $table->timestamps();
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('settings', function ($table) {
			$table->dropColumn('default_eula_text');
		});

		Schema::table('categories', function ($table) {
			$table->dropColumn('eula_text');
			$table->dropColumn('use_default_eula');
			$table->dropColumn('require_acceptance');
		});

		Schema::table('asset_logs', function ($table) {
			$table->dropColumn('requested_at');
			$table->dropColumn('accepted_at');
		});

		Schema::drop('requested_assets');
	}

}
