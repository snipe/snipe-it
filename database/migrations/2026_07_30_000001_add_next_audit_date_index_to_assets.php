<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Speeds up two query paths that sort/filter on assets.next_audit_date:
 *
 *   - Audit report sort (#9430) via Actionlog::scopeOrderByAssetNextAuditDate,
 *     which leftJoins assets on the polymorphic item_id/item_type and
 *     orders by next_audit_date. Without an index, larger installs
 *     filesort the entire filtered set per paged click.
 *   - SendUpcomingAuditReport's dueOrOverdueForAudit scope, which
 *     filters assets by next_audit_date within a window. Runs
 *     nightly via the scheduler; on installs with 100k+ assets the
 *     full-scan cost showed up in slow-query logs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->index('next_audit_date', 'assets_next_audit_date_index');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropIndex('assets_next_audit_date_index');
        });
    }
};
