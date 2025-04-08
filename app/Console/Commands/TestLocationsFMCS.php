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
    protected $description = 'Test for inconsistencies if FullMultipleCompanySupport with scoped locations will be used';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Test for inconsistencies if FullMultipleCompanySupport with scoped locations will be used');
        $this->info('Depending on the database size this will take a while, output will be displayed after the complete test is over');

        // if parameter location_id is set, only test this location
        $location_id = null;
        if ($this->option('location_id')) {
            $location_id = $this->option('location_id');
        }
        $ret = Helper::test_locations_fmcs(true, $location_id);

        foreach($ret as $output) {
            $this->info($output);
        }
    }
}
