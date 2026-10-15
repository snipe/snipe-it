<?php

namespace Tests\Feature\Seeders;

use App\Models\Import;
use Database\Seeders\ImportSeeder;
use Tests\TestCase;

class ImportSeederTest extends TestCase
{
    private array $seededPaths = [];

    protected function setUp(): void
    {
        parent::setUp();

        if (! is_dir(base_path('sample_csvs'))) {
            $this->markTestSkipped('sample_csvs directory is not present on this checkout.');
        }
    }

    protected function tearDown(): void
    {
        // The seeder writes real files via copy(); clean up so nothing
        // leaks between tests. DB rows go with the transaction.
        foreach ($this->seededPaths as $path) {
            @unlink($path);
        }

        parent::tearDown();
    }

    private function trackSeededFiles(): void
    {
        $importsDir = config('app.private_uploads').'/imports';
        foreach (Import::where('file_path', 'like', 'demo-%.csv')->get() as $import) {
            $this->seededPaths[] = $importsDir.'/'.$import->file_path;
        }
    }

    public function test_seeds_a_handful_of_sample_imports(): void
    {
        $this->seed(ImportSeeder::class);
        $this->trackSeededFiles();

        $seeded = Import::where('file_path', 'like', 'demo-%.csv')->get();

        $this->assertGreaterThan(0, $seeded->count(), 'Expected at least one demo import to be seeded.');
        $this->assertContains('demo-users-sample.csv', $seeded->pluck('file_path')->all());

        $importsDir = config('app.private_uploads').'/imports';
        foreach ($seeded as $import) {
            $this->assertFileExists($importsDir.'/'.$import->file_path);
            $this->assertIsArray($import->header_row);
            $this->assertIsArray($import->first_row);
            $this->assertNotEmpty($import->header_row);
        }
    }

    public function test_seeding_is_idempotent(): void
    {
        $this->seed(ImportSeeder::class);
        $firstRunCount = Import::where('file_path', 'like', 'demo-%.csv')->count();

        $this->seed(ImportSeeder::class);
        $secondRunCount = Import::where('file_path', 'like', 'demo-%.csv')->count();

        $this->trackSeededFiles();

        $this->assertSame($firstRunCount, $secondRunCount, 'Repeated seeder runs must not accumulate duplicate imports.');
    }
}
