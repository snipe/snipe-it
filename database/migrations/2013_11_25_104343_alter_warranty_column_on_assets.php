<?php

use Illuminate\Database\Migrations\Migration;

class AlterWarrantyColumnOnAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function ($table) {
	        $table->renameColumn('warrantee_months', 'warranty_months');
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
    }

}
