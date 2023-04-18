<?php

namespace App\Importer;

use App\Models\Location;

/**
 * When we are importing users via an Asset/etc import, we use createOrFetchUser() in
 * Importer\Importer.php. [ALG]
 *
 * Class LocationImporter
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

        $editingLocation = false;
        $location = Location::where('name', '=', $this->findCsvMatch($row, 'name'))->first();

        if ($location) {
            if (! $this->updating) {
                $this->log('A matching Location '.$this->item['name'].' already exists');
                return;
            }

            $this->log('Updating Location');
            $editingLocation = true;
        } else {
            $this->log('No Matching Location, Create a new one');
            $location = new Location;
        }

        // Pull the records from the CSV to determine their values
        $this->item['name'] = $this->findCsvMatch($row, 'name');
        $this->item['address'] = $this->findCsvMatch($row, 'address');
        $this->item['address2'] = $this->findCsvMatch($row, 'address2');
        $this->item['city'] = $this->findCsvMatch($row, 'city');
        $this->item['state'] = $this->findCsvMatch($row, 'state');
        $this->item['country'] = $this->findCsvMatch($row, 'country');
        $this->item['zip'] = $this->findCsvMatch($row, 'zip');
        $this->item['currency'] = $this->findCsvMatch($row, 'currency');
        $this->item['ldap_ou'] = $this->findCsvMatch($row, 'ldap_ou');
        $this->item['manager'] = $this->findCsvMatch($row, 'manager');
        $this->item['manager_username'] = $this->findCsvMatch($row, 'manager_username');
        $this->item['user_id'] = \Auth::user()->id;

        if ($this->findCsvMatch($row, 'parent_location')) {
            $this->item['parent_id'] = $this->createOrFetchLocation($this->findCsvMatch($row, 'parent_location'));
        }

        if (!empty($this->item['manager'])) {
            if ($manager = $this->createOrFetchUser($row, 'manager')) {
                $this->item['manager_id'] = $manager->id;
            }
        }

        \Log::debug('Item array is: ');
        \Log::debug(print_r($this->item, true));


        if ($editingLocation) {
            \Log::debug('Updating existing location');
            $location->update($this->sanitizeItemForUpdating($location));
        } else {
            \Log::debug('Creating location');
            $location->fill($this->sanitizeItemForStoring($location));
        }

        if ($location->save()) {
            $this->log('Location '.$location->name.' created or updated from CSV import');
            return $location;

        } else {
            \Log::debug($location->getErrors());
            return $location->errors;
        }


    }
}