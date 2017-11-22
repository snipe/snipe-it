<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlackToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('slack_endpoint')->nullable()->default(null);
            $table->string('slack_channel')->nullable()->default(null);
            $table->string('slack_botname')->nullable()->default(null);
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
            //
            $table->dropColumn('slack_endpoint');
            $table->dropColumn('slack_channel');
            $table->dropColumn('slack_botname');
        });
    }
}
