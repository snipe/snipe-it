<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendPhoneLengthsInSupplierAndElsewhere extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            //
            $table->string('phone',35)->nullable()->default(NULL)->change();
            $table->string('fax',35)->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            //
            $table->string('phone',20)->nullable()->default(NULL)->change();
            $table->string('fax',20)->nullable()->default(NULL)->change();

        });
    }
}
