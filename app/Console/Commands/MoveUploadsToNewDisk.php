<?php

namespace App\Console\Commands;

use App\Enums\FileStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

class MoveUploadsToNewDisk extends Command
{
    protected $signature = 'snipeit:move-uploads
        {--delete-local : Delete the local source files after a successful copy. Prompts if omitted.}
        {--overwrite : Overwrite destination files that already exist. Prompts if omitted.}';

    protected $description = 'Move locally uploaded files to the currently configured storage disk.';

    /**
     * Per-type tally rendered in the summary table at the end. One row
     * per FileStorage case the sweep touched, so admins can eyeball
     * what moved without reading the full per-file stream.
     *
     * @var array<string, array{copied: int, skipped: int, private: int, private_skipped: int, errors: int}>
     */
    private array $summary = [];

    private bool $overwrite = false;

    public function handle(): int
    {
        if (config('filesystems.default') === 'local') {
            error('Current disk is set to local. Nothing to move.');
            note('Set PUBLIC_FILESYSTEM_DISK=s3_public and PRIVATE_FILESYSTEM_DISK=s3_private in your .env, then rerun.');

            return self::FAILURE;
        }

        $publicDisk = config('filesystems.disks.public.driver', '?');
        $privateDisk = config('filesystems.default', '?');
        info("Target public disk: {$publicDisk}. Target private disk: {$privateDisk}.");

        $this->overwrite = $this->option('overwrite')
            || confirm(
                label: 'Overwrite destination files that already exist? Choose "No" to skip them and keep whatever is already on the destination.',
                default: false,
            );

        $publicSources = $this->collectPublicSources();
        $privateSources = $this->collectPrivateSources();
        $logoSources = array_merge(
            glob('public/uploads/setting*.*') ?: [],
            file_exists('public/uploads/default.png') ? ['public/uploads/default.png'] : [],
            file_exists('public/uploads/snipe-logo.png') ? ['public/uploads/snipe-logo.png'] : [],
        );

        $this->copyPublic($publicSources);
        $this->copyLogos($logoSources);
        $this->copyPrivate($privateSources);

        $this->renderSummary();

        $deleteLocal = $this->option('delete-local')
            || confirm(
                label: 'Also delete the local source files? This cannot be undone.',
                default: false,
            );

        if ($deleteLocal) {
            $this->deleteLocalSources($publicSources, $privateSources, $logoSources);
        }

        return self::SUCCESS;
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function collectPublicSources(): array
    {
        $sources = [];
        foreach (FileStorage::cases() as $case) {
            if (! $case->hasPublicScope() || $case === FileStorage::Barcodes) {
                continue;
            }
            $sources[$case->value] = glob($case->publicDir().'/*.*') ?: [];
        }

        return $sources;
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function collectPrivateSources(): array
    {
        $sources = [];
        foreach (FileStorage::cases() as $case) {
            if (! $case->hasPrivateScope()) {
                continue;
            }
            $sources[$case->value] = glob($case->privateDir().'/*.*') ?: [];
        }

        return $sources;
    }

    /**
     * @param  array<string, array<int, string>>  $sources
     */
    private function copyPublic(array $sources): void
    {
        $disk = Storage::disk('public');

        foreach ($sources as $type => $files) {
            if ($files === []) {
                continue;
            }

            $copied = 0;
            $skipped = 0;
            $errors = 0;

            progress(
                label: "Copying public {$type}",
                steps: $files,
                callback: function (string $filepath) use ($type, $disk, &$copied, &$skipped, &$errors): void {
                    $filename = basename($filepath);
                    // The `public` disk is already rooted at the uploads
                    // directory on local and the per-install bucket root
                    // on S3, so the destination key is `<type>/<file>`
                    // without an `uploads/` prefix. The application reads
                    // image URLs via FileStorage::<Case>->publicPath()
                    // which emits `<type>/`. Prefixing here would land
                    // the file at a key the app never resolves.
                    $key = $type.'/'.$filename;

                    if (! $this->overwrite && $disk->exists($key)) {
                        $skipped++;

                        return;
                    }

                    try {
                        $disk->put($key, file_get_contents($filepath));
                        $copied++;
                    } catch (Throwable $e) {
                        Log::debug($e);
                        $errors++;
                    }
                },
            );

            $this->tally($type, copied: $copied, skipped: $skipped, errors: $errors);
        }
    }

    /**
     * @param  array<int, string>  $logoSources
     */
    private function copyLogos(array $logoSources): void
    {
        if ($logoSources === []) {
            return;
        }

        $disk = Storage::disk('public');
        $copied = 0;
        $skipped = 0;
        $errors = 0;

        progress(
            label: 'Copying branding logos',
            steps: $logoSources,
            callback: function (string $filepath) use ($disk, &$copied, &$skipped, &$errors): void {
                $filename = basename($filepath);
                // Branding logos (logo.*, favicon.*, Setting-*) live at
                // the root of the public disk, so no subdirectory
                // prefix.
                if (! $this->overwrite && $disk->exists($filename)) {
                    $skipped++;

                    return;
                }

                try {
                    $disk->put($filename, file_get_contents($filepath));
                    $copied++;
                } catch (Throwable $e) {
                    Log::debug($e);
                    $errors++;
                }
            },
        );

        $this->tally('logos', copied: $copied, skipped: $skipped, errors: $errors);
    }

    /**
     * @param  array<string, array<int, string>>  $sources
     */
    private function copyPrivate(array $sources): void
    {
        foreach ($sources as $type => $files) {
            if ($files === []) {
                continue;
            }

            $copied = 0;
            $skipped = 0;
            $errors = 0;

            progress(
                label: "Copying private {$type}",
                steps: $files,
                callback: function (string $filepath) use ($type, &$copied, &$skipped, &$errors): void {
                    $filename = basename($filepath);
                    $key = $type.'/'.$filename;

                    if (! $this->overwrite && Storage::exists($key)) {
                        $skipped++;

                        return;
                    }

                    try {
                        Storage::put($key, file_get_contents($filepath));
                        $copied++;
                    } catch (Throwable $e) {
                        Log::debug($e);
                        $errors++;
                    }
                },
            );

            $this->tally($type, private: $copied, private_skipped: $skipped, errors: $errors);
        }
    }

    /**
     * @param  array<string, array<int, string>>  $publicSources
     * @param  array<string, array<int, string>>  $privateSources
     * @param  array<int, string>  $logoSources
     */
    private function deleteLocalSources(array $publicSources, array $privateSources, array $logoSources): void
    {
        warning('Deleting local source files. This cannot be undone.');

        $publicDeleted = 0;
        $privateDeleted = 0;
        $logoDeleted = 0;

        foreach ($publicSources as $files) {
            foreach ($files as $filepath) {
                if ($this->tryUnlink($filepath)) {
                    $publicDeleted++;
                }
            }
        }

        foreach ($privateSources as $files) {
            foreach ($files as $filepath) {
                if ($this->tryUnlink($filepath)) {
                    $privateDeleted++;
                }
            }
        }

        foreach ($logoSources as $filepath) {
            if ($this->tryUnlink($filepath)) {
                $logoDeleted++;
            }
        }

        info("Deleted {$publicDeleted} public, {$privateDeleted} private, {$logoDeleted} branding file(s) from the local filesystem.");
    }

    private function tryUnlink(string $filepath): bool
    {
        try {
            return @unlink($filepath);
        } catch (Throwable $e) {
            Log::debug($e);

            return false;
        }
    }

    /**
     * Separate public / private counters so the summary table can show
     * both axes without conflating them. "copied" and "skipped" are
     * the public-side tallies, "private" and "private_skipped" the
     * matching pair for the private disk. "errors" aggregates both.
     */
    private function tally(string $type, int $copied = 0, int $skipped = 0, int $private = 0, int $private_skipped = 0, int $errors = 0): void
    {
        if (! isset($this->summary[$type])) {
            $this->summary[$type] = [
                'copied' => 0,
                'skipped' => 0,
                'private' => 0,
                'private_skipped' => 0,
                'errors' => 0,
            ];
        }
        $this->summary[$type]['copied'] += $copied;
        $this->summary[$type]['skipped'] += $skipped;
        $this->summary[$type]['private'] += $private;
        $this->summary[$type]['private_skipped'] += $private_skipped;
        $this->summary[$type]['errors'] += $errors;
    }

    private function renderSummary(): void
    {
        if ($this->summary === []) {
            info('No files found to move.');

            return;
        }

        ksort($this->summary);

        $rows = [];
        $totals = [
            'copied' => 0,
            'skipped' => 0,
            'private' => 0,
            'private_skipped' => 0,
            'errors' => 0,
        ];
        foreach ($this->summary as $type => $counts) {
            $rows[] = [
                $type,
                $counts['copied'],
                $counts['skipped'],
                $counts['private'],
                $counts['private_skipped'],
                $counts['errors'],
            ];
            foreach (array_keys($totals) as $k) {
                $totals[$k] += $counts[$k];
            }
        }
        $rows[] = [
            'TOTAL',
            $totals['copied'],
            $totals['skipped'],
            $totals['private'],
            $totals['private_skipped'],
            $totals['errors'],
        ];

        table(['Type', 'Public copied', 'Public skipped', 'Private copied', 'Private skipped', 'Errors'], $rows);
    }
}
