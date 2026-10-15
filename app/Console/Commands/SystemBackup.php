<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemBackup extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    // --force is accepted for parity with other Laravel commands that require
    // it (migrate, db:seed, etc.); it doesn't gate anything here but external
    // automations were passing it and crashing on the "option does not exist"
    // error.
    protected $signature = 'snipeit:backup {--filename=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a database dump and zips up all of the uploaded files in the upload directories.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', config('backup.time_limit')); // 600 seconds = 10 minutes

        if ($this->option('filename')) {
            $filename = $this->option('filename');

            // Make sure the filename ends in .zip
            if (! ends_with($filename, '.zip')) {
                $filename = $filename.'.zip';
            }

            $this->call('backup:run', ['--filename' => $filename]);
        } else {
            $this->call('backup:run');
        }

    }
}
