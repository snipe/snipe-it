<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\Location;

class ImportLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:import-locations {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import locations and their parents';

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
        // Import parent location names first if they don't exist
        // 2019-05-13-021051-locationscsv

        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $filename = $this->argument('filename');
        $csv = Reader::createFromPath(storage_path('private_uploads/imports/').$filename.'.csv', 'r');

        $this->info('Attempting to process: '.storage_path('private_uploads/imports/').$filename.'.csv');
        $keys = ['Name', 'Currency', 'Address 1', 'Address 2', 'City', 'State', 'Country', 'Zip', 'Parent Name', 'Manager'];

        $csv->setOffset(1); //because we don't want to insert the header
        $results = $csv->fetchAssoc($keys);

        foreach ($results as $parent_index => $parent_row) {

            $parent_name = trim($parent_row['Parent Name']);
            // First create any parents if they don't exist
            //$this->info(print_r($parent_row));
            $parent_location = Location::firstOrNew(array('name' => trim($parent_name)));


            if ($parent_name!='') {
                $this->info('Parent for '.$parent_row['Name'].' is '.$parent_name.'. Attempting to save '.$parent_name.'.');

                // Save parent location name
                if ($parent_location->exists()) {
                        $this->info('- Parent location '.$parent_name.' already exists: '.$parent_location);
                } else {
                    $parent_location->save();
                    $this->info('- Parent location '.$parent_name.' was created.');
                }

            } else {
                $this->info('- No parent location for '.$parent_row['Name'].' provided.');
            }

        }

        foreach ($results as $index => $row) {

            $this->info(print_r($row));
            $location = Location::updateOrCreate(array('name' => trim($row['Name'])));
            $location->name = trim($row['Name']);
            $location->currency = trim($row['Currency']);
            $location->address = trim($row['Address 1']);
            $location->address2 = trim($row['Address 2']);
            $location->city = trim($row['City']);
            $location->state = trim($row['State']);
            $location->zip = trim($row['Zip']);

            //$this->info(print_r($location));

            $this->info('Checking location: '.$location->name);

            if ($parent_location->id) {
                $location->parent_id = Location::find($parent_location->id);
                $this->info('Parent ID: '.$parent_location->id);
            }

            if ($location->save()) {

                if ($location->exists()) {
                    $this->error('Location ' . $location->name . ' already exists. Updating...');
                } else {
                    $this->info('- Location '.$location->name.' was created. ');
                }

            } else {
                $this->error('- Non-parent Location '.$location->name.' could not be created:');
            }




        }


    }
}
