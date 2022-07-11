<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsReturnSignatureSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function ($table) {
            $table->boolean('require_return_signature')->default(0);
        });

        Schema::table('action_logs', function ($table) {
            $table->string('return_signature', 100)->nullable()->default(null);
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
            if (Schema::hasColumn('settings', 'require_return_signature')) {
                $table->dropColumn('require_return_signature');
            }
        });
        Schema::table('action_logs', function (Blueprint $table) {
            if (Schema::hasColumn('action_logs', 'return_signature')) {
                $table->dropColumn('return_signature');
            }
        });
    }
}
