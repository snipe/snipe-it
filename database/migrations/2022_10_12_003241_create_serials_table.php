<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table already exists
        if (!Schema::hasTable('serials')) {
            Schema::create('serials', function (Blueprint $table) {
                $table->id();
                // Associated component ID
                $table->unsignedInteger('component_id');
                // Serial number assigned to asset ID
                $table->unsignedInteger('asset_id')->nullable();
                // Serial number (unique)
                $table->string('serial_number')->unique();
                // Serial number notes
                $table->text('notes')->nullable();
                // Serial number status (0 = available, 1 = assigned, 2 = reserved)
                $table->tinyInteger('status')->default(0);
                // Serial number created at and updated at timestamps
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign key constraints
        Schema::table('serials', function (Blueprint $table) {
            $table->dropForeign(['component_id']);
            $table->dropForeign(['asset_id']);
        });

        Schema::dropIfExists('serials');
    }
}
