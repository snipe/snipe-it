<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebhookToSettings extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       Schema::table('settings', function (Blueprint $table) {
           $table->string('webhook_endpoint',255)->nullable()->default(NULL);
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
           $table->dropColumn('webhook_endpoint');
       });
   }
}
