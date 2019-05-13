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
        $csv = Reader::createFromPath(storage_path('private_uploads/imports/').$filename, 'r');

        $this->info('Attempting to process: '.storage_path('private_uploads/imports/').$filename);
        $csv->setOffset(1); //because we don't want to insert the header
        $results = $csv->fetchAssoc();

        foreach ($results as $parent_index => $parent_row) {

            $parent_name = trim($parent_row['Parent Name']);
            // First create any parents if they don't exist

            if ($parent_name!='') {
                $parent_location = Location::firstOrCreate(array('name' => $parent_name));
                $this->info('Parent for '.$parent_row['Name'].' is '.$parent_name.'. Attempting to save '.$parent_name.'.');


                // Save parent location name
                if ($parent_location->exists) {
                        $this->info('- Parent location '.$parent_name.' already exists.');
                } else {

                    $this->info('- Parent location '.$parent_name.' was created.');
                }

            } else {
                $this->info('- No parent location for '.$parent_row['Name'].' provided.');
            }

        }

        foreach ($results as $index => $row) {
            
            $location = Location::firstOrNew(array('name' => trim($row['Name'])));
            $location->name = trim($row['Name']);
            $location->currency = trim($row['Currency']);
            $location->address = trim($row['Address 1']);
            $location->address2 = trim($row['Address 2']);
            $location->city = trim($row['City']);
            $location->state = trim($row['State']);
            $location->zip = trim($row['Zip']);

            $this->info('Checking location: '.$location->name);


            if ($parent_name) {
                $parent = Location::where('name', '=', $parent_name)->first();
                $location->parent_id = $parent->id;
                $this->info('Parent ID: '.$parent->id);
            }

            if (($location->isValid()) && ($location->save())) {

                if ($location->exists) {
                    $this->info('Location ' . $location->name . ' already exists. Updating...');
                } else {
                    $this->info('- Location '.$location->name.' was created. ');
                }

            } else {
                $this->error('- Non-parent Location '.$location->name.' could not be created: '.$location->getErrors() );
            }




        }


    }
}
