<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class OptimizeTest extends TestCase
{
    private const RELOCATABLE_CACHES = [
        'APP_CONFIG_CACHE' => 'config.php',
        'APP_EVENTS_CACHE' => 'events.php',
        'APP_ROUTES_CACHE' => 'routes-v7.php',
    ];

    private array $originalCacheEnv = [];

    private string $relocatedCacheDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->relocatedCacheDirectory = storage_path('framework/testing/optimize-'.getmypid());

        $this->snapshotCachePathEnv();
        $this->relocateFrameworkCaches();

        $this->beforeApplicationDestroyed(function () {
            File::deleteDirectory($this->relocatedCacheDirectory);
            $this->restoreCachePathEnv();
        });
    }

    public function test_optimize_succeeds(): void
    {
        $this->artisan('optimize')->assertSuccessful();
    }

    /**
     * Record every cache path env var as it stands before this test
     * relocates it.
     */
    private function snapshotCachePathEnv(): void
    {
        foreach (array_keys(self::RELOCATABLE_CACHES) as $key) {
            $this->originalCacheEnv[$key] = [
                'env' => $_ENV[$key] ?? false,
                'server' => $_SERVER[$key] ?? false,
            ];
        }
    }

    /**
     * Point the three relocatable caches at an isolated
     * directory to avoid workers stepping on each other.
     */
    private function relocateFrameworkCaches(): void
    {
        File::ensureDirectoryExists($this->relocatedCacheDirectory);

        foreach (self::RELOCATABLE_CACHES as $key => $filename) {
            $path = $this->relocatedCacheDirectory.'/'.$filename;

            $_ENV[$key] = $_SERVER[$key] = $path;
        }
    }

    /**
     * Put every cache path env var back exactly as it was before this test
     * ran, so a relocated path can't leak into the next test's config boot.
     */
    private function restoreCachePathEnv(): void
    {
        foreach ($this->originalCacheEnv as $key => $original) {
            unset($_ENV[$key], $_SERVER[$key]);

            if ($original['env'] !== false) {
                $_ENV[$key] = $original['env'];
            }
            if ($original['server'] !== false) {
                $_SERVER[$key] = $original['server'];
            }
        }
    }
}
