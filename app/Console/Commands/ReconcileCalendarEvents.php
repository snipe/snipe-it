<?php

namespace App\Console\Commands;

use App\Models\CalendarEvent;
use Illuminate\Console\Command;

/**
 * Reconciles the calendar_events index against every source model
 * that uses the HasCalendarEvents trait.
 *
 * The observer keeps rows in sync on live saves, but drift can still
 * happen from:
 *   - Direct DB edits that bypass Eloquent (raw SQL, migrations
 *     that touch date columns, restored backups).
 *   - Missed observer fires (queue jobs that ->save() then throw
 *     between save and observer completion in pre-Laravel-12
 *     versions).
 *   - New sources added after existing data was already in place -
 *     nothing published events until the trait was added; this
 *     command backfills them.
 *   - Orphan rows whose source was hard-deleted while the observer
 *     was down (rare, but the reconcile also cleans these).
 *
 * Sources are discovered by walking app/Models for classes that use
 * the trait. Each source is chunked to keep memory flat on large
 * installs.
 *
 * Idempotent - safe to schedule (e.g. nightly) alongside the observer.
 */
class ReconcileCalendarEvents extends Command
{
    protected $signature = 'snipeit:reconcile-calendar-events
                            {--source= : Fully-qualified class name of a single source to reconcile, if you don\'t want to walk everything}
                            {--dry-run : Report the counts of what would change without writing}';

    protected $description = 'Rebuilds the calendar_events index from source model date columns.';

    public function handle(): int
    {
        $sources = $this->discoverSources();
        if (empty($sources)) {
            $this->warn('No models use the HasCalendarEvents trait. Nothing to reconcile.');

            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');
        $totalUpserts = 0;
        $totalOrphans = 0;

        foreach ($sources as $sourceClass) {
            $this->info(sprintf('Reconciling %s ...', $sourceClass));

            [$upserts, $orphans] = $this->reconcileSource($sourceClass, $dryRun);
            $totalUpserts += $upserts;
            $totalOrphans += $orphans;

            $this->line(sprintf(
                '  %s: %d source rows synced, %d orphan calendar_events %s',
                class_basename($sourceClass),
                $upserts,
                $orphans,
                $dryRun ? 'would be removed' : 'removed',
            ));
        }

        $this->newLine();
        $this->info(sprintf(
            'Done. %d syncs, %d orphans %s.',
            $totalUpserts,
            $totalOrphans,
            $dryRun ? '(dry run)' : 'processed',
        ));

        return self::SUCCESS;
    }

    /**
     * @return array{0: int, 1: int} [upsert count, orphan count]
     */
    protected function reconcileSource(string $sourceClass, bool $dryRun): array
    {
        $upserts = 0;
        $orphans = 0;

        // Sync path: walk every live source row and force-sync its
        // calendar_events. force=true bypasses the observer's
        // "did any declared field change" gate so drifted-in-place
        // date values get corrected. Live rows only - trashed
        // sources should not publish calendar_events (see issue
        // #19760 and the matching gate in
        // HasCalendarEvents::syncCalendarEvents).
        $sourceClass::query()
            ->chunkById(500, function ($rows) use (&$upserts, $dryRun) {
                foreach ($rows as $row) {
                    if (! $dryRun) {
                        $row->forceSyncCalendarEvents();
                    }
                    $upserts++;
                }
            });

        // Orphan sweep: any calendar_events pointing at a
        // source_type / source_id that no longer resolves to a row
        // (even a trashed one) is unreachable. Batches at 500 to
        // keep DELETE statements bounded.
        CalendarEvent::withTrashed()
            ->where('source_type', $sourceClass)
            ->chunkById(500, function ($events) use ($sourceClass, &$orphans, $dryRun) {
                $ids = $events->pluck('source_id')->all();
                $existingIds = $sourceClass::query()
                    ->when(
                        in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($sourceClass), true),
                        fn ($q) => $q->withTrashed(),
                    )
                    ->whereIn('id', $ids)
                    ->pluck('id')
                    ->all();

                $orphanEvents = $events->filter(fn ($e) => ! in_array($e->source_id, $existingIds, true));
                $orphans += $orphanEvents->count();

                if (! $dryRun && $orphanEvents->isNotEmpty()) {
                    CalendarEvent::withTrashed()
                        ->whereIn('id', $orphanEvents->pluck('id')->all())
                        ->forceDelete();
                }
            });

        return [$upserts, $orphans];
    }

    /**
     * Explicit --source overrides the scan for targeted reconciles
     * (e.g. after a bulk import touched one model). Otherwise defer
     * to CalendarEvent::sourceModels(), which is the single source
     * of truth for "which models participate in the calendar" so a
     * new HasCalendarEvents adopter picks up here without editing
     * this command.
     */
    protected function discoverSources(): array
    {
        if ($single = $this->option('source')) {
            if (! class_exists($single)) {
                $this->error(sprintf('%s not found. Pass a fully-qualified class name.', $single));

                return [];
            }

            return [$single];
        }

        $sources = CalendarEvent::sourceModels();
        sort($sources);

        return $sources;
    }
}
