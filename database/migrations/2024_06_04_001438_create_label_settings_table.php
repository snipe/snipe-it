<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('page_format');
            $table->string('page_orientation')->default('P');
            $table->float('column1_x');
            $table->float('column2_x');
            $table->float('row1_y');
            $table->float('row2_y');
            $table->float('label_width');
            $table->float('label_height');
            $table->float('barcode_size');
            $table->float('barcode_margin');
            $table->float('title_size');
            $table->float('field_size');
            $table->float('field_margin');
            $table->float('title_margin');
            $table->float('label_size');
            $table->float('label_margin');
            $table->float('tag_size');
            $table->float('logo_max_width');
            $table->float('measurement_unit');
            $table->float('margin_top');
            $table->float('margin_bottom');
            $table->float('margin_left');
            $table->float('margin_right');
            $table->integer('fields_supported')->default(1);
            $table->boolean('tag_option');
            $table->boolean('1d_barcode_option');
            $table->boolean('2d_barcode_option');
            $table->boolean('logo_option');
            $table->boolean('title_option');
            $table->float('tape_height');
            $table->float('tape_margin_sides');
            $table->float('tape_margin_ends');
            $table->float('tape_text_size_mod');
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
        Schema::dropIfExists('label_settings');
    }
}