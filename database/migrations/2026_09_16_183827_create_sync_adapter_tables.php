<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create every table the sync-adapter feature needs, in one migration.
 * Historically this landed as eight incremental migrations that
 * seeded per-adapter rows and toggled a built_in column. Adapter
 * TYPE discovery moved to runtime via SyncAdapter::allTypes(),
 * so per-adapter row seeding is gone and the built_in column
 * with it. Consolidating pre-release keeps the ship-out shape flat.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Combined identity + inventory table for sync-adapter data
        // about an asset. Carries which adapter created it
        // (source + external_id) plus the last-known network / OS
        // inventory (primary_mac / primary_ip / os / os_version /
        // last_seen). Kept separate from the assets table so
        // vendor-populated data can grow without widening the row
        // and eating custom-field headroom.
        //
        // Two unique indexes.
        //   - (source, external_id) so one row per vendor-device pair.
        //   - (source, asset_id) so one asset can only be linked to
        //     each vendor once (prevents duplicate side-table rows
        //     when a device gets re-enrolled with a new external id).
        Schema::create('asset_external_sources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->unsignedBigInteger('asset_id')->index();
            $table->string('source', 191);
            $table->string('external_id', 191);
            $table->string('primary_mac', 191)->nullable()->index();
            $table->string('primary_ip', 191)->nullable()->index();
            $table->string('os', 191)->nullable();
            $table->string('os_version', 191)->nullable();
            $table->timestamp('last_seen')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
            $table->unique(['source', 'external_id']);
            $table->unique(['source', 'asset_id'], 'aes_source_asset_id_unique');
        });

        // One row per configured adapter instance. Adapter TYPES live
        // in the codebase and are discovered at runtime, so nothing
        // gets pre-seeded here. Admins add instances via the settings
        // page. The slug is auto-generated from the label on create
        // and is immutable after (asset_external_sources.source
        // references it, reassigning slugs would orphan assets).
        //
        // config holds every per-instance setting (URL, encrypted
        // credentials, mapping.{field} targets, direction.{field},
        // group_mapping.{group_id}, cached vendor metadata, etc)
        // as a single JSON blob. The SyncAdapterConfig helper reads
        // and writes individual keys against this column so callers
        // don't have to json_decode themselves. Prior shape was a
        // separate sync_adapter_settings table with one row per key.
        Schema::create('sync_adapter_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->string('slug', 191)->unique();
            $table->string('adapter_type', 191)->index();
            $table->string('label', 191);
            $table->boolean('active')->default(true);
            $table->longText('config')->nullable();
            $table->timestamp('last_synced_at')->nullable()->index();
            $table->text('last_sync_result')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_adapter_instances');
        Schema::dropIfExists('asset_external_sources');
    }
};
