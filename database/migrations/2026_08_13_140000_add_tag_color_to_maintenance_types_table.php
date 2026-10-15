<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a nullable `tag_color` column to maintenance_types, matching
 * the same-name column on other categorizing tables (companies,
 * models, categories, locations, departments, etc). Used by the new
 * asset-maintenance calendar view (blade: maintenances/calendar) to
 * color-code events by maintenance type - the calendar falls back to
 * a status-based palette (green/orange/blue for
 * completed/active/upcoming) when no tag_color is set on the type.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_types', function (Blueprint $table) {
            if (! Schema::hasColumn('maintenance_types', 'tag_color')) {
                $table->string('tag_color')->after('name')->nullable()->default(null);
            }
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_types', function (Blueprint $table) {
            if (Schema::hasColumn('maintenance_types', 'tag_color')) {
                $table->dropColumn('tag_color');
            }
        });
    }
};
