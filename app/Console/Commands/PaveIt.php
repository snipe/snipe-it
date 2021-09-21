<?php

namespace App\Console\Commands;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Group;
use App\Models\Import;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;
use DB;
use Illuminate\Console\Command;

class PaveIt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:pave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the database tables, leaving all migrations, table structure, and the first user in place. (It is primarily a quick tool for developers.) If you want to destroy all tables as well, use php artisan db:wipe.';

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
        if ($this->confirm("\n****************************************************\nTHIS WILL DELETE ALL OF THE DATA IN YOUR DATABASE. \nThere is NO undo. This WILL destroy ALL of your data. \n****************************************************\n\nDo you wish to continue? No backsies! [y|N]")) {

            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

                $except_tables = [
                    'oauth_access_tokens',
                    'oauth_clients',
                    'oauth_personal_access_clients',
                    'migrations',
                    'settings',
                    'users',
                ];

                foreach ($tables as $table) {

                    $this->info($table);
                    
                    if (in_array($table, $except_tables)) {
                        $this->info('Table '. $table. ' will be skipped');
                    } else {
                        \DB::statement('delete from '.$table);
                    }
                    
                }   
                \DB::statement('delete from users WHERE id!=1' 
        }
    }
}
