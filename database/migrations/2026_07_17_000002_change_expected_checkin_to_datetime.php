<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dateTime('expected_checkin')->nullable()->change();
        });

        Schema::table('action_logs', function (Blueprint $table) {
            $table->dateTime('expected_checkin')->nullable()->change();
        });

        // asset_logs is a legacy table (superseded by action_logs since 2016)
        // and is not referenced by any app code, so we leave it alone.
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->date('expected_checkin')->nullable()->change();
        });

        Schema::table('action_logs', function (Blueprint $table) {
            $table->date('expected_checkin')->nullable()->change();
        });
    }
};
