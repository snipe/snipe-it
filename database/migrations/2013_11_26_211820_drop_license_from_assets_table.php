<?php

use Illuminate\Database\Migrations\Migration;

class DropLicenseFromAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('assets', function ($table) {
        //     $table->dropColumn('license_name');
        //     $table->dropColumn('license_email');
        // });
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
