<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dateTime('start_date')->change();
            $table->dateTime('completion_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('completion_date')->nullable()->change();
        });
    }
};
