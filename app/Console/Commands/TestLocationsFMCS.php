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
    protected $signature = 'snipeit:test-locations-fmcs';

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
        $ret = Helper::test_locations_fmcs(true);

        foreach($ret as $output) {
            $this->info($output);
        }
    }
}
