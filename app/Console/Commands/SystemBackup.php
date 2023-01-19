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
    protected $name = 'snipeit:backup';

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
        //
        $this->call('backup:run');
    }
}
