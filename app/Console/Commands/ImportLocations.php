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


        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $filename = $this->argument('filename');
        $csv = Reader::createFromPath(storage_path('private_uploads/imports/').$filename, 'r');
        $this->info('Attempting to process: '.storage_path('private_uploads/imports/').$filename);
        $csv->setOffset(1); //because we don't want to insert the header
        $results = $csv->getRecords();

        // Import parent location names first if they don't exist
        foreach ($results as $parent_index => $parent_row) {

            $parent_name = trim($parent_row['Parent Name']);
            // First create any parents if they don't exist

            if ($parent_name!='') {

                // Save parent location name
                // This creates a sort of name-stub that we'll update later on in this script
                $parent_location = Location::firstOrCreate(array('name' => $parent_name));
                $this->info('Parent for '.$parent_row['Name'].' is '.$parent_name.'. Attempting to save '.$parent_name.'.');

                // Check if the record was updated or created.
                // This is mostly for clearer debugging.
                if ($parent_location->exists) {
                        $this->info('- Parent location '.$parent_name.' already exists.');
                } else {
                    $this->info('- Parent location '.$parent_name.' was created.');
                }

            } else {
                $this->info('- No parent location for '.$parent_row['Name'].' provided.');
            }

        }

        // Loop through ALL records and add/update them if there are additional fields
        // besides name
        foreach ($results as $index => $row) {

            // Set the location attributes to save
            $location = Location::firstOrNew(array('name' => trim($row['Name'])));
            $location->name = trim($row['Name']);
            $location->currency = trim($row['Currency']);
            $location->address = trim($row['Address 1']);
            $location->address2 = trim($row['Address 2']);
            $location->city = trim($row['City']);
            $location->state = trim($row['State']);
            $location->zip = trim($row['Zip']);
            $location->country = trim($row['Country']);
            $location->ldap_ou = trim($row['OU']);

            $this->info('Checking location: '.$location->name);

            // If a parent name nis provided, we created it earlier in the script,
            // so let's grab that ID
            if ($parent_name) {
                $parent = Location::where('name', '=', $parent_name)->first();
                $location->parent_id = $parent->id;
                $this->info('Parent ID: '.$parent->id);
            }

            // Make sure the more advanced (non-name) fields pass validation
            if (($location->isValid()) && ($location->save())) {

                // Check if the record was updated or created.
                // This is mostly for clearer debugging.
                if ($location->exists) {
                    $this->info('Location ' . $location->name . ' already exists. Updating...');
                } else {
                    $this->info('- Location '.$location->name.' was created. ');
                }

            // If there's a validation error, display that
            } else {
                $this->error('- Non-parent Location '.$location->name.' could not be created: '.$location->getErrors() );
            }




        }


    }
}
