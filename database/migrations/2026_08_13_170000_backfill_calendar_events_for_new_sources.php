<?php

use App\Models\CalendarEvent;
use Illuminate\Database\Migrations\Migration;

/**
 * Second-pass backfill for calendar_events. The first backfill
 * migration ran when only Maintenance used HasCalendarEvents; this
 * one runs after Asset / License / User adopted the trait so any
 * install that already applied the earlier migration also picks up
 * the new sources without a manual reconcile.
 *
 * Same discover-and-force-sync logic as the first backfill: idempotent
 * on rows that already have an index entry (updateOrCreate-shaped
 * lookup in the trait uses withTrashed to sidestep the unique
 * constraint even for restored rows), so re-running for
 * already-synced Maintenance rows is a no-op.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->discoverSources() as $sourceClass) {
            $this->backfillSource($sourceClass);
        }
    }

    public function down(): void
    {
        // No-op. See sibling backfill migration.
    }

    protected function backfillSource(string $sourceClass): void
    {
        // Live rows only. Backfilling trashed sources created calendar
        // events for soft-deleted records that users could neither
        // open nor remove (see issue #19760).
        $sourceClass::query()
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    $row->forceSyncCalendarEvents();
                }
            });
    }

    protected function discoverSources(): array
    {
        // See CalendarEvent::sourceModels() - single source of truth
        // for the HasCalendarEvents adopter list.
        return CalendarEvent::sourceModels();
    }
};
