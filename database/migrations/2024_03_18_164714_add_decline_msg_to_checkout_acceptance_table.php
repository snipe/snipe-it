<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeclineMsgToCheckoutAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout_acceptances', function (Blueprint $table) {
            $table->string('declined_msg')->after('signature_filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkout_acceptances', function (Blueprint $table) {
            $table->dropColumn('declined_msg');
        });
    }
}
