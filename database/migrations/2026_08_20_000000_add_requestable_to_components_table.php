<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('components', function (Blueprint $table) {
            if (! Schema::hasColumn('components', 'requestable')) {
                $table->tinyInteger('requestable')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            if (Schema::hasColumn('components', 'requestable')) {
                $table->dropColumn('requestable');
            }
        });
    }
};
