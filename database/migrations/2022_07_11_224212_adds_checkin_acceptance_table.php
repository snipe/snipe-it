<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsCheckinAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('checkin_acceptances')) {
            Schema::create('checkin_acceptances', function (Blueprint $table) {
                $table->increments('id');

                $table->morphs('checkinable');
                $table->integer('returned_by_id')->nullable();

                $table->string('signature_filename')->nullable();

                $table->timestamp('returned_at')->nullable();
                $table->timestamp('declined_at')->nullable();

                $table->timestamps();
                $table->softDeletes();
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
        if (Schema::hasTable('checkin_acceptances')) {
            Schema::dropIfExists('checkin_acceptances');
        }
    }
}
