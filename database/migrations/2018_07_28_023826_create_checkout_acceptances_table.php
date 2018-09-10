<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutAcceptancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_acceptances', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('checkoutable');
            $table->integer('assigned_to_id')->unsigned();

            $table->string('signature_filename')->nullable();

            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('declined_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout_acceptances');
    }
}
