<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds indexes on the date columns the dashboard's Needs Attention
 * widget filters against so the count queries can use a b-tree lookup
 * instead of a full table scan on large installs.
 *
 * Columns covered:
 *   - assets.expected_checkin        — overdue-checkin count
 *   - assets.asset_eol_date          — assets-past-EOL count
 *   - licenses.expiration_date       — licenses-expiring-soon count
 *   - users.end_date                 — users-offboarding count
 *   - maintenances.expected_completion_date — overdue-maintenances count
 *
 * `assets.next_audit_date` already has an index (see the 2026_07_30
 * migration), so it's intentionally not repeated here.
 *
 * Each add is guarded by a hasColumn + doesntHaveIndex check so re-runs
 * on installs that manually added any of these are no-ops instead of
 * hard failures. The corresponding down() drops each index only if it
 * exists.
 */
return new class extends Migration
{
    private const TARGETS = [
        ['table' => 'assets', 'column' => 'expected_checkin', 'index' => 'assets_expected_checkin_index'],
        ['table' => 'assets', 'column' => 'asset_eol_date', 'index' => 'assets_asset_eol_date_index'],
        ['table' => 'licenses', 'column' => 'expiration_date', 'index' => 'licenses_expiration_date_index'],
        ['table' => 'users', 'column' => 'end_date', 'index' => 'users_end_date_index'],
        ['table' => 'maintenances', 'column' => 'expected_completion_date', 'index' => 'maintenances_expected_completion_date_index'],
    ];

    public function up(): void
    {
        foreach (self::TARGETS as $target) {
            if (! Schema::hasColumn($target['table'], $target['column'])) {
                continue;
            }
            if ($this->indexExists($target['table'], $target['index'])) {
                continue;
            }

            Schema::table($target['table'], function (Blueprint $t) use ($target) {
                $t->index($target['column'], $target['index']);
            });
        }
    }

    public function down(): void
    {
        foreach (self::TARGETS as $target) {
            if (! $this->indexExists($target['table'], $target['index'])) {
                continue;
            }

            Schema::table($target['table'], function (Blueprint $t) use ($target) {
                $t->dropIndex($target['index']);
            });
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(Schema::getIndexes($table))
            ->pluck('name')
            ->contains($index);
    }
};
