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
            $table->string('name');
            $table->string('page_format')->nullable();
            $table->string('page_orientation')->nullable();
            $table->decimal('column1_x',6)->nullable();
            $table->decimal('column2_x', 6)->nullable();
            $table->decimal('row1_y', 6)->nullable();
            $table->decimal('row2_y', 6)->nullable();
            $table->decimal('label_width', 6)->nullable();
            $table->decimal('label_height', 6)->nullable();
            $table->decimal('barcode_size', 6)->nullable();
            $table->decimal('barcode_margin', 6)->nullable();
            $table->decimal('title_size', 6)->nullable();
            $table->decimal('title_margin', 6)->nullable();
            $table->decimal('field_size', 6)->nullable();
            $table->decimal('field_margin', 6)->nullable();
            $table->decimal('label_size', 6)->nullable();
            $table->decimal('label_margin', 6)->nullable();
            $table->decimal('tag_size', 6)->nullable();
            $table->decimal('logo_max_width', 6)->nullable();
            $table->decimal('logo_margin', 6)->nullable();
            $table->decimal('measurement_unit', 6)->nullable();
            $table->decimal('margin_top', 6)->nullable();
            $table->decimal('margin_bottom', 6)->nullable();
            $table->decimal('margin_left', 6)->nullable();
            $table->decimal('margin_right', 6)->nullable();
            $table->integer('fields_supported')->default(1);
            $table->boolean('tag_option')->nullable();
            $table->boolean('1d_barcode_option')->nullable();
            $table->boolean('2d_barcode_option')->nullable();
            $table->boolean('logo_option')->nullable();
            $table->boolean('title_option')->nullable();
            $table->decimal('tape_height', 6)->nullable();
            $table->decimal('tape_width', 6)->nullable();
            $table->decimal('tape_margin_sides', 6)->nullable();
            $table->decimal('tape_margin_ends', 6)->nullable();
            $table->decimal('tape_text_size_mod', 6)->nullable();
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