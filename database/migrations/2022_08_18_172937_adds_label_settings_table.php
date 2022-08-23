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
        Schema::table('settings', function ( Blueprint $table) {
            $table->renameColumn('labels_per_page', 'deprecated_labels_per_page');
            $table->renameColumn('labels_width', 'deprecated_labels_width');
            $table->renameColumn('labels_width', 'deprecated_labels_width');
            $table->renameColumn('labels_height', 'deprecated_labels_height');
            $table->renameColumn('labels_pmargin_left', 'deprecated_labels_pmargin_left');
            $table->renameColumn('labels_pmargin_right', 'deprecated_labels_pmargin_right');
            $table->renameColumn('labels_pmargin_top', 'deprecated_labels_pmargin_top');
            $table->renameColumn('labels_pmargin_bottom', 'deprecated_labels_pmargin_bottom');
            $table->renameColumn('labels_display_bgutter', 'deprecated_labels_display_bgutter');
            $table->renameColumn('labels_display_sgutter', 'deprecated_labels_display_sgutter');
            $table->renameColumn('labels_fontsize', 'deprecated_labels_fontsize');
            $table->renameColumn('labels_pagewidth', 'deprecated_labels_pagewidth');
            $table->renameColumn('labels_pageheight', 'deprecated_labels_pageheight');
            $table->renameColumn('labels_display_name', 'deprecated_labels_display_name');
            $table->renameColumn('labels_display_serial', 'deprecated_labels_display_serial');
            $table->renameColumn('labels_display_tag', 'deprecated_labels_display_tag');
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

        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('deprecated_labels_per_page', 'labels_per_page');
            $table->renameColumn('deprecated_labels_width', 'labels_width');
            $table->renameColumn('deprecated_labels_width', 'labels_width');
            $table->renameColumn('deprecated_labels_height', 'labels_height');
            $table->renameColumn('deprecated_labels_pmargin_left', 'labels_pmargin_left');
            $table->renameColumn('deprecated_labels_pmargin_right', 'labels_pmargin_right');
            $table->renameColumn('deprecated_labels_pmargin_top', 'labels_pmargin_top');
            $table->renameColumn('deprecated_labels_pmargin_bottom', 'labels_pmargin_bottom');
            $table->renameColumn('deprecated_labels_display_bgutter', 'labels_display_bgutter');
            $table->renameColumn('deprecated_labels_display_sgutter', 'labels_display_sgutter');
            $table->renameColumn('deprecated_labels_fontsize', 'labels_fontsize');
            $table->renameColumn('deprecated_labels_pagewidth', 'labels_pagewidth');
            $table->renameColumn('deprecated_labels_pageheight', 'labels_pageheight');
            $table->renameColumn('deprecated_labels_display_name', 'labels_display_name');
            $table->renameColumn('deprecated_labels_display_serial', 'labels_display_serial');
            $table->renameColumn('deprecated_labels_display_tag', 'labels_display_tag');
        });
    }
}
