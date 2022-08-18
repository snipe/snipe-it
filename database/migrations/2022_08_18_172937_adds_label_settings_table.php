<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsLabelSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_settings', function ( Blueprint $table)
        {
            $table->increments('id');
            $table->string('setting_name')->default('Default Settings');
            $table->integer('user_id')->nullable();
            $table->tinyInteger('labels_per_page')->default(30);
            $table->decimal('labels_width', 6, 5)->default(2.625);
            $table->decimal('labels_height', 6, 5)->default(1);
            $table->decimal('labels_pmargin_left', 6, 5)->default(0.21975);
            $table->decimal('labels_pmargin_right', 6, 5)->default(0.21975);
            $table->decimal('labels_pmargin_top', 6, 5)->default(0.5);
            $table->decimal('labels_pmargin_bottom', 6, 5)->default(0.5);
            $table->decimal('labels_display_bgutter', 6, 5)->default(0.07);
            $table->decimal('labels_display_sgutter', 6, 5)->default(0.05);
            $table->tinyInteger('labels_fontsize')->default(9);
            $table->decimal('labels_pagewidth', 7, 5)->default(8.5);
            $table->decimal('labels_pageheight', 7, 5)->default(11);
            $table->tinyInteger('labels_display_name')->default(0);
            $table->tinyInteger('labels_display_serial')->default(1);
            $table->tinyInteger('labels_display_tag')->default(1);
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
        Schema::dropifExists('custom_label_settings');
    }
}
