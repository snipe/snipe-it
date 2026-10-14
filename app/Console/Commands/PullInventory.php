<?php

namespace App\Console\Commands;

use App\Models\Actionlog;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\SyncAdapter;
use App\SyncAdapters\SyncErrorFormatter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class PullInventory extends Command
{
    protected $signature = 'snipeit:pull-inventory {adapter? : The adapter instance slug. Omit to pull every enabled instance.}';

    protected $description = 'Pull host inventory from configured sync-adapter instances and upsert as Snipe-IT assets.';

    private const TABLE_HEADERS = ['Adapter', 'Status', 'Synced', 'Skipped', 'Errors', 'Elapsed'];

    public function handle(): int
    {
        $slug = $this->argument('adapter');

        if ($slug !== null) {
            $instance = SyncAdapterInstance::query()->where('slug', $slug)->first();

            if ($instance === null) {
                $available = SyncAdapterInstance::query()->pluck('slug')->implode(', ');
                $availableLabel = $available !== '' ? $available : '(none configured)';
                $this->error("Unknown adapter instance \"{$slug}\". Available: {$availableLabel}.");

                return self::FAILURE;
            }

            $rows = [];
            $exit = $this->runInstance($instance, $rows);
            $this->table(self::TABLE_HEADERS, $rows);

            return $exit;
        }

        // No slug argument means "run every enabled instance". Used by
        // the scheduler entry so the whole install syncs off one cron
        // line without having to enumerate instances at boot time
        // (they're user-created and change at runtime).
        $instances = SyncAdapterInstance::query()->orderBy('slug')->get();

        if ($instances->isEmpty()) {
            $this->info('No sync-adapter instances configured.');

            return self::SUCCESS;
        }

        $anyFailed = false;
        $ranCount = 0;
        $totalStartedAt = microtime(true);
        $rows = [];

        foreach ($instances as $instance) {
            $adapter = $instance->adapter();
            if ($adapter === null || ! $adapter->isEnabled()) {
                $rows[] = [$instance->slug, 'Skipped', '-', '-', '-'];

                continue;
            }

            $ranCount++;
            if ($this->runInstance($instance, $rows) === self::FAILURE) {
                $anyFailed = true;
            }
        }

        $this->table(self::TABLE_HEADERS, $rows);

        $totalElapsed = self::formatElapsed($totalStartedAt);
        $this->info("Ran {$ranCount} enabled instance(s) in {$totalElapsed}.");

        return $anyFailed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Run a single instance. Appends one row to $rows describing the
     * outcome for the final table render, and returns the shell exit
     * code (SUCCESS or FAILURE) so the iterate-all path can aggregate
     * across many instances. Config-error paths still emit inline
     * $this->error output because those message shapes carry
     * remediation hints that don't fit a table row.
     */
    private function runInstance(SyncAdapterInstance $instance, array &$rows): int
    {
        $slug = $instance->slug;
        $startedAt = microtime(true);

        $adapter = $instance->adapter();
        if ($adapter === null) {
            $this->error("Instance \"{$slug}\" references adapter_type \"{$instance->adapter_type}\" which is not registered.");
            $rows[] = [$slug, 'Config error', '-', '-', self::formatElapsed($startedAt)];

            return self::FAILURE;
        }

        if (! $adapter->isEnabled()) {
            $this->error("Adapter \"{$slug}\" is not active or is missing configuration. Set it up under Settings -> Sync Adapters.");
            $rows[] = [$slug, 'Not active', '-', '-', self::formatElapsed($startedAt)];

            return self::FAILURE;
        }

        // CLI PHP usually has no time cap, but being explicit is
        // harmless and matches the interactive controller.
        set_time_limit(0);

        $seen = 0;
        $skipped = 0;
        $errors = 0;

        Log::channel('sync-adapters')->info("{$slug} sync starting (CLI)");

        try {
            Actionlog::withActionSource('sync:'.$slug, function () use ($adapter, $slug, &$seen, &$skipped, &$errors) {
                foreach ($adapter->pull() as $record) {
                    try {
                        $result = SyncAdapter::syncFromRecord($record);
                        if ($result === null) {
                            $skipped++;
                        } else {
                            $seen++;
                        }
                    } catch (Throwable $e) {
                        $errors++;
                        $sourceId = $record->sourceId;
                        $message = $e->getMessage();
                        // A single bad record shouldn't take down the run.
                        // Log the offending host and keep going.
                        $this->warn("Failed to sync host {$sourceId}: {$message}");
                        Log::channel('sync-adapters')->warning("{$slug} sync: failed to upsert host {$sourceId}: {$message}");
                    }
                }
            });
        } catch (Throwable $e) {
            // Brief summary for the UI "Last Synced" field and the
            // console error output.
            $summary = SyncErrorFormatter::summary($e);
            $abortSummary = "Sync aborted: {$summary}";
            $instance->last_synced_at = now();
            $instance->last_sync_result = $abortSummary;
            $instance->save();

            $elapsed = self::formatElapsed($startedAt);
            $this->error("{$slug} {$abortSummary} ({$elapsed})");
            Log::channel('sync-adapters')->warning(
                "{$slug} sync aborted after {$seen} record(s), {$skipped} skipped, {$errors} error(s), elapsed {$elapsed}: {$summary}",
                SyncErrorFormatter::logContext($e),
            );
            $rows[] = [$slug, 'Aborted', $seen, $skipped, $errors, $elapsed];

            return self::FAILURE;
        }

        // Same lang key as the UI so both paths render the same phrasing
        // on the settings page.
        $result = trans('admin/settings/sync_adapters.sync_complete', [
            'count' => $seen,
            'skipped' => $skipped,
            'errors' => $errors,
        ]);
        $instance->last_synced_at = now();
        $instance->last_sync_result = $result;
        $instance->save();

        $elapsed = self::formatElapsed($startedAt);
        Log::channel('sync-adapters')->info("{$slug} sync complete: {$seen} record(s) processed, {$skipped} skipped, {$errors} error(s), elapsed {$elapsed}");

        $status = $errors > 0 ? 'Errors' : 'OK';
        $rows[] = [$slug, $status, $seen, $skipped, $errors, $elapsed];

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Format an elapsed duration for console output. Seconds with one
     * decimal below a minute, minutes-and-seconds above. Sized for
     * scan-at-a-glance output on multi-instance runs where one slow
     * adapter is easier to spot when the units don't drift into the
     * hundreds of seconds.
     */
    private static function formatElapsed(float $startedAt): string
    {
        $elapsed = microtime(true) - $startedAt;
        if ($elapsed < 60) {
            return number_format($elapsed, 1).'s';
        }

        $minutes = (int) floor($elapsed / 60);
        $seconds = number_format($elapsed - ($minutes * 60), 1);

        return $minutes.'m '.$seconds.'s';
    }
}
