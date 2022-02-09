<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixDoubleEscape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:unescape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This should be run to fix some double-escaping issues from earlier versions of Snipe-IT.';

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

        $tables = [
            '\App\Models\Asset' => ['name'],
            '\App\Models\License' => ['name', 'license_name'],
            '\App\Models\Consumable' => ['name'],
            '\App\Models\Accessory' => ['name'],
            '\App\Models\Component' => ['name'],
            '\App\Models\Company' => ['name'],
            '\App\Models\Manufacturer' => ['name'],
            '\App\Models\Supplier' => ['name'],
            '\App\Models\Statuslabel' => ['name'],
            '\App\Models\Depreciation' => ['name'],
            '\App\Models\AssetModel' => ['name'],
            '\App\Models\Group' => ['name'],
            '\App\Models\Department' => ['name'],
            '\App\Models\Location' => ['name'],
            '\App\Models\User' => ['first_name', 'last_name', 'jobtitle'],
        ];

        $count = array();



            foreach ($tables as $classname => $fields) {
                $count[$classname] = array();
                $count[$classname]['classname'] = 0;

                foreach($fields as $field) {

                    $count[$classname]['classname']++;
                    $count[$classname][$field] = 0;

                    foreach($classname::where("$field",'LIKE','%;%')->get() as $row) {
                       
                        $fixed = html_entity_decode($row->{$field});
                        if ($row->save()) {
                            $this->info('Updating '.$field.' for '.$classname.' to '.$row->{$field}.' to '.$fixed);
                        } else {
                            $this->error('Could NOT update '.$field.' for '.$classname.' to '.$row->{$field}.' to '.$fixed.': '.$row->getErrors());
                        }
                        $count[$classname][$field]++;

                    }
                }
            }

        $this->info('Update complete');

    }
}
