<?php

namespace Database\Seeders;

use App\Models\Import;
use App\Models\User;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class ImportSeeder extends Seeder
{
    /**
     * Copy a handful of canonical sample CSVs from sample_csvs/ into the
     * importer's storage directory and register Import rows for them so
     * demo/dev users can exercise the import flow end to end without
     * uploading anything themselves. Runs on `db:seed` and is also safe
     * to invoke standalone via `db:seed --class=ImportSeeder`. On the
     * hosted demo, the reset pipeline calls `db:seed` after paving the
     * DB, so this re-seeds automatically without any extra wiring.
     */
    public function run(): void
    {
        Import::truncate();

        $samplesDir = base_path('sample_csvs');

        if (! is_dir($samplesDir)) {
            $this->command?->warn("Sample CSV directory not found at $samplesDir, skipping.");

            return;
        }

        $admin = User::where('permissions->superuser', '1')->first()
            ?? User::factory()->firstAdmin()->create();

        $importsDir = config('app.private_uploads').'/imports';

        if (! is_dir($importsDir)) {
            mkdir($importsDir, 0755, true);
        }

        // The subset a demo user is most likely to try. Keeping the list
        // short so the imports index doesn't become noisy after repeated
        // resets. Ordering is a suggestion, not a dependency chain.
        $samples = [
            'users-sample.csv',
            'assets-sample.csv',
            'licenses-sample.csv',
            'accessories-sample.csv',
            'consumables-sample.csv',
        ];

        foreach ($samples as $sample) {
            $source = $samplesDir.'/'.$sample;

            if (! is_file($source)) {
                continue;
            }

            // Fixed filename so re-runs overwrite in place instead of
            // accumulating dated dupes on disk. The DB row is idempotent
            // via the truncate at the top.
            $storedName = 'demo-'.$sample;
            $destination = $importsDir.'/'.$storedName;

            copy($source, $destination);

            try {
                $reader = Reader::createFromPath($destination);
                $headerRow = $reader->nth(0);
                $firstRow = $reader->nth(1);
            } catch (\Throwable) {
                $this->command?->warn("Could not parse $sample, skipping.");

                continue;
            }

            // Explicit set-and-save because Import has no $fillable, so
            // mass-assignment helpers (updateOrCreate / firstOrNew) throw.
            $import = new Import;
            $import->file_path = $storedName;
            $import->name = $storedName;
            $import->filesize = filesize($destination);
            $import->header_row = $headerRow;
            $import->first_row = $firstRow;
            $import->created_by = $admin->id;
            $import->save();
        }
    }
}
