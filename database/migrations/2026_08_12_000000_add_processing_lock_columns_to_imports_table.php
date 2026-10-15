<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mutex columns for the per-import processing lock. Prevents two
        // concurrent process() calls on the same import file from racing
        // the app-layer unique-validation checks and producing duplicate
        // rows. See Api\ImportController::process for the acquire logic.
        // Both columns nullable and index-only (no FK constraint, per
        // project convention).
        Schema::table('imports', function (Blueprint $table) {
            if (! Schema::hasColumn('imports', 'processing_by')) {
                $table->unsignedBigInteger('processing_by')->nullable()->after('created_by');
                $table->index('processing_by');
            }
            if (! Schema::hasColumn('imports', 'processing_started_at')) {
                $table->timestamp('processing_started_at')->nullable()->after('processing_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('imports', function (Blueprint $table) {
            if (Schema::hasColumn('imports', 'processing_started_at')) {
                $table->dropColumn('processing_started_at');
            }
            if (Schema::hasColumn('imports', 'processing_by')) {
                $table->dropIndex(['processing_by']);
                $table->dropColumn('processing_by');
            }
        });
    }
};
