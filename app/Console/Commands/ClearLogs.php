<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckoutLicenseToAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear {--license_id=} {--notify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear log files';

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


        exec('rm -f ' . storage_path('logs/*.log'));

        exec('rm -f ' . base_path('*.log'));

        $this->comment('Logs have been cleared!');


    }
}