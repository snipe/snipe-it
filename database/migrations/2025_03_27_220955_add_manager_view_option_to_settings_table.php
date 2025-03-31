<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the column already exists before trying to add it
        if (!Schema::hasColumn('settings', 'manager_view_enabled')) {
            Schema::table('settings', function (Blueprint $table) {
                // Add the new column, defaulting to false (0)
                // Place it after 'show_images_in_email' for organization if that column exists
                if (Schema::hasColumn('settings', 'show_images_in_email')) {
                    $table->boolean('manager_view_enabled')->default(false)->after('show_images_in_email');
                } else {
                    $table->boolean('manager_view_enabled')->default(false);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the column exists before trying to drop it
        if (Schema::hasColumn('settings', 'manager_view_enabled')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('manager_view_enabled');
            });
        }
    }
};
