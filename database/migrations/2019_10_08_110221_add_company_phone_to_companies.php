<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyPhoneToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('phone')->nullable()->default(null);
        });

        Schema::table('settings', function(Blueprint $table) {
           $table->boolean('labels_display_company_phone')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
        Schema::table('settings', function(Blueprint $table) {
            $table->dropColumn('labels_display_company_phone');
        });
    }
}
