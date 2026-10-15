<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Widen custom_fields.format from varchar(191) to TEXT. Custom regex
    // formats can easily exceed 191 chars (character classes + anchors +
    // grouping quickly add up), and hitting the ceiling truncates the
    // regex silently on save, breaking validation on that field's values.
    public function up(): void
    {
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->text('format')->change();
        });
    }

    public function down(): void
    {
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->string('format', 191)->change();
        });
    }
};
