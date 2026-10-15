<?php

namespace App\Console\Commands;

use App\Models\AssetExternalSource;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\PushableAdapter;
use Illuminate\Console\Command;
use Throwable;

class PushInventory extends Command
{
    protected $signature = 'snipeit:push-inventory {adapter? : The adapter instance slug. Omit to push every enabled instance that supports push.}';

    protected $description = 'Push Snipe-IT-authoritative field values to configured sync-adapter instances that support pushing.';

    private const TABLE_HEADERS = ['Adapter', 'Status', 'Pushed', 'Errors', 'Elapsed'];

    public function handle(): int
    {
        $slug = $this->argument('adapter');

        if ($slug !== null) {
            $instance = SyncAdapterInstance::query()->where('slug', $slug)->first();
            if ($instance === null) {
                $this->error("Unknown adapter instance \"{$slug}\".");

                return self::FAILURE;
            }

            $rows = [];
            $exit = $this->runInstance($instance, $rows);
            $this->table(self::TABLE_HEADERS, $rows);

            return $exit;
        }

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
            if (! $adapter instanceof PushableAdapter) {
                continue;
            }
            if (! $adapter->isEnabled() || ! $adapter->canPush()) {
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
        $this->info("Ran push on {$ranCount} push-enabled instance(s) in {$totalElapsed}.");

        return $anyFailed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Run push for one instance. Mirrors the postAdapterPush controller
     * shape: iterate asset_external_sources for this instance in chunks
     * so a large fleet doesn't load everything into memory, invoke
     * $adapter->push() per asset, accumulate counts. Per-asset errors
     * get logged and counted. A single bad asset doesn't abort the run.
     * Appends one row to $rows describing the outcome for the final
     * table render.
     */
    private function runInstance(SyncAdapterInstance $instance, array &$rows): int
    {
        $slug = $instance->slug;
        $startedAt = microtime(true);

        $adapter = $instance->adapter();
        if (! $adapter instanceof PushableAdapter) {
            $this->error("Adapter \"{$slug}\" does not support push.");
            $rows[] = [$slug, 'Not pushable', '-', '-', self::formatElapsed($startedAt)];

            return self::FAILURE;
        }
        if (! $adapter->isEnabled()) {
            $this->error("Adapter \"{$slug}\" is not active or is missing configuration.");
            $rows[] = [$slug, 'Not active', '-', '-', self::formatElapsed($startedAt)];

            return self::FAILURE;
        }
        if (! $adapter->canPush()) {
            $this->error("Adapter \"{$slug}\" does not currently support push (vendor gate).");
            $rows[] = [$slug, 'Push gated', '-', '-', self::formatElapsed($startedAt)];

            return self::FAILURE;
        }

        set_time_limit(0);

        $pushed = 0;
        $errors = 0;

        try {
            AssetExternalSource::query()
                ->where('source', $slug)
                ->with('asset')
                ->chunkById(200, function ($queryRows) use ($adapter, &$pushed, &$errors) {
                    foreach ($queryRows as $row) {
                        $asset = $row->asset;
                        if ($asset === null) {
                            continue;
                        }

                        try {
                            $adapter->push($asset);
                            $pushed++;
                        } catch (Throwable $e) {
                            $errors++;
                            $message = $e->getMessage();
                            $this->warn("push: asset {$asset->id} failed: {$message}");
                        }
                    }
                });
        } catch (Throwable $e) {
            $elapsed = self::formatElapsed($startedAt);
            $message = $e->getMessage();
            $this->error("{$slug} push aborted: {$message} ({$elapsed})");
            $rows[] = [$slug, 'Aborted', $pushed, $errors, $elapsed];

            return self::FAILURE;
        }

        $status = $errors > 0 ? 'Errors' : 'OK';
        $rows[] = [$slug, $status, $pushed, $errors, self::formatElapsed($startedAt)];

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
