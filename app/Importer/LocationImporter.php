<?php

namespace App\Importer;

use App\Models\Location;
use App\Models\Setting;
use App\Models\User;

/**
 * This is ONLY used for the User Import. When we are importing users
 * via an Asset/etc import, we use createOrFetchUser() in
 * App\Importer.php. [ALG]
 *
 * Class UserImporter
 */
class LocationImporter extends ItemImporter
{
    protected $locations;

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        parent::handle($row);
        $this->createLocationIfNotExists($row);
    }

    /**
     * Create a location if a duplicate does not exist.
     * @todo Investigate how this should interact with Importer::createLocationIfNotExists
     *
     * @author A. Gianotto
     * @since 6.1.0
     * @param array $row
     */
    public function createLocationIfNotExists(array $row)
    {
        // Pull the records from the CSV to determine their values
        $this->item['name'] = $this->findCsvMatch($row, 'name');
        $this->item['address'] = $this->findCsvMatch($row, 'address');
        $this->item['address2'] = $this->findCsvMatch($row, 'address2');
        $this->item['city'] = $this->findCsvMatch($row, 'city');
        $this->item['state'] = $this->findCsvMatch($row, 'state');
        $this->item['zip'] = $this->findCsvMatch($row, 'zip');
        $this->item['currency'] = $this->findCsvMatch($row, 'currency');
        $this->item['ldap_ou'] = $this->findCsvMatch($row, 'ldap_ou');
        $this->item['parent_id'] = $this->createOrFetchLocation($this->findCsvMatch($row, 'parent_location'));
        $this->item['user_id'] = \Auth::user()->id;
        $this->item['manager_id'] = $this->createOrFetchUser($row);

        $location = Location::where('name', $this->item['name'])->first();


        // Location exists
        if ($location) {

            $this->log('A matching Location '.$this->item['name'].' already exists.  ');
            \Log::debug('A matching Location '.$this->item['name'].' already exists.  ');

            if (! $this->updating) {
                return;
            }

            $this->log('Updating Location from CSV import');
            $location->update($this->sanitizeItemForUpdating($location));
            //$location->save();
            return;

        // Location does not exist
        } else {

            $this->log('No matching location, creating one');
            $location = new Location();
            //dd($location);
            $location->fill($this->sanitizeItemForStoring($location));

            if ($location->save()) {
                $this->log('Location '.$location->name.' created from CSV import');
                return $location;
            }

            $this->logError($location, 'Location');
            return;
        }





    }
}
