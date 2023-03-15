<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsWebhookOptionToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
                $table->string('webhook_selected')->after('slack_botname')->default('slack')->nullable();
                $table->renameColumn('slack_botname', 'webhook_botname');
                $table->renameColumn('slack_endpoint', 'webhook_endpoint');
                $table->renameColumn('slack_channel', 'webhook_channel');

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
            $table->dropColumn('webhook_selected');
            $table->renameColumn('webhook_botname', 'slack_botname');
            $table->renameColumn('webhook_endpoint', 'slack_endpoint');
            $table->renameColumn('webhook_channel', 'slack_channel');
        });
    }
}
