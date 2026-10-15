<?php

use App\Models\CalendarEvent;
use Illuminate\Database\Migrations\Migration;

/**
 * One-shot backfill of the calendar_events index for every source
 * model that uses HasCalendarEvents at the time this migration runs.
 * Walks the sources, chunks the rows, and force-syncs each so their
 * declared date columns land as calendar_events rows.
 *
 * On a fresh install the source tables are usually empty at this
 * point (this migration runs early), so the backfill is a no-op and
 * the observer takes over from there. On an upgrade from an install
 * that already has maintenances / audits / etc., the backfill
 * populates the index so those existing records show up on the
 * calendar without waiting for a manual save on each one.
 *
 * Capped at the most-recent 2000 rows per source (ordered by primary
 * key desc). Large installs with a decade of audit / maintenance /
 * checkout history would otherwise grind through every historical
 * row during upgrade to populate a calendar view most users only use
 * for recent and upcoming events. Admins who want the full backlog
 * run snipeit:reconcile-calendar-events after the upgrade completes.
 *
 * Duplicates snipeit:reconcile-calendar-events's sync logic on
 * purpose - the command is meant to be re-runnable on demand later,
 * this migration is the one-time seed at deploy time. Kept small
 * enough that no shared helper class is needed between them.
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
        // No-op. The calendar_events table gets dropped by the
        // create-table migration's down(); trying to un-backfill
        // individual rows here would just reset the index to an
        // empty state that the observer would immediately fill on
        // the next source save anyway.
    }

    protected function backfillSource(string $sourceClass): void
    {
        $instance = new $sourceClass;
        $keyName = $instance->getKeyName();

        // Live rows only. Backfilling trashed sources created calendar
        // events for soft-deleted records that users could neither
        // open nor remove (see issue #19760).
        $sourceClass::query()
            ->orderByDesc($keyName)
            ->limit(2000)
            ->get()
            ->each(function ($row) {
                $row->forceSyncCalendarEvents();
            });
    }

    protected function discoverSources(): array
    {
        // Single source of truth for the HasCalendarEvents adopter
        // list. Lives on CalendarEvent so the controller, the
        // reconcile command, and both backfill migrations all resolve
        // "which models publish calendar events" the same way.
        return CalendarEvent::sourceModels();
    }
};
