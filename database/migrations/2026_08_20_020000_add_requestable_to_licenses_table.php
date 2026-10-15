<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            if (! Schema::hasColumn('licenses', 'requestable')) {
                $table->tinyInteger('requestable')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            if (Schema::hasColumn('licenses', 'requestable')) {
                $table->dropColumn('requestable');
            }
        });
    }
};
