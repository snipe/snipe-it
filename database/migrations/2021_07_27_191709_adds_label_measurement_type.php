<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsLabelMeasurementType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('labels_measurement_type')->after('labels_per_page')->default('in');
            $table->decimal('labels_pagewidth',8,5)->change();
            $table->decimal('labels_pageheight',8,5)->change();
            $table->decimal('labels_width',8,5)->change();
            $table->decimal('labels_height',8,5)->change();
            $table->decimal('labels_pmargin_top',8,5)->change();
            $table->decimal('labels_pmargin_bottom',8,5)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('labels_measurement_type');
            $table->decimal('labels_pagewidth',7,5)->change();
            $table->decimal('labels_pageheight',7,5)->change();
            $table->decimal('labels_width',6,5)->change();
            $table->decimal('labels_height',6,5)->change();
            $table->decimal('labels_pmargin_top',6,5)->change();
            $table->decimal('labels_pmargin_bottom',6,5)->change();
        });
    }
}
