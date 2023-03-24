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
     * @author Daniel Melzter
     * @since 4.0
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
        $this->item['user_id'] = $this->user_id;
        $this->item['manager_id'] = $this->fetchManager($row);

        $location = Location::where('name', $this->item['name'])->first();


        if ($location) {

            $this->log('A matching Location '.$this->item['name'].' already exists.  ');
            \Log::debug('A matching Location '.$this->item['name'].' already exists.  ');

            if (! $this->updating) {
                return;
            }

            $this->log('Updating Location from CSV import');
            $location->update($this->sanitizeItemForUpdating($location));
            $location->save();
            return;

        } else {

            $this->log('No matching location, creating one');
            $location = new Location();
            $location->fill($this->sanitizeItemForStoring($location));
        }


        if ($location->save()) {
            $this->log('Location '.$this->item['name'].' created from CSV import');
            $location = null;
            $this->item = null;
            return;
        }

        $this->logError($location, 'Location');
        return;
    }
}
