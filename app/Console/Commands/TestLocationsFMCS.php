<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use Illuminate\Console\Command;

class TestLocationsFMCS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:test-locations-fmcs {--location_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test for company ID inconsistencies if FullMultipleCompanySupport with scoped locations will be used.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('This script checks for company ID inconsistencies if Full Multiple Company Support with scoped locations will be used.');
        $this->info('This could take few moments if have a very large dataset.');
        $this->newLine();

        // if parameter location_id is set, only test this location
        $location_id = null;
        if ($this->option('location_id')) {
            $location_id = $this->option('location_id');
        }


        $ret = Helper::test_locations_fmcs(true, $location_id);
        $this->warn('There are '.count($ret).' items in the database that need your attention before you can enable location scoping.');
        $this->table(['Item Type', 'Item ID', 'Item Company ID', 'Location Company ID'], $ret);

    }
}
