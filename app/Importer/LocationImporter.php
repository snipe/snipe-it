<?php

namespace App\Importer;

use App\Models\Location;
use Illuminate\Support\Facades\Log;

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
        // LocationImporter deliberately does NOT call parent::handle(). See
        // the other subclass migrations for the same pattern: absent CSV
        // columns stay out of $this->item so update mode preserves the DB
        // value, and present-but-empty cells land as null so update mode
        // clears the DB value. The base sanitize's reject-empty pass is
        // disabled by $rejectEmptyOnUpdate on ItemImporter.
        $this->item = [];

        // Straight CSV-to-item assignments for Location fillable fields.
        $this->setItemFromCsvIfPresent($row, 'name');
        $this->setItemFromCsvIfPresent($row, 'address');
        $this->setItemFromCsvIfPresent($row, 'address2');
        $this->setItemFromCsvIfPresent($row, 'city');
        $this->setItemFromCsvIfPresent($row, 'state');
        $this->setItemFromCsvIfPresent($row, 'country');
        $this->setItemFromCsvIfPresent($row, 'zip');
        $this->setItemFromCsvIfPresent($row, 'currency');
        $this->setItemFromCsvIfPresent($row, 'ldap_ou');
        $this->setItemFromCsvIfPresent($row, 'notes');
        $this->setItemFromCsvIfPresent($row, 'tag_color');

        // parent_location column resolves to parent_id on the model. Empty
        // value clears the parent (root-level location); absent preserves.
        if ($this->csvRowHas($row, 'parent_location')) {
            $raw = $this->findCsvMatch($row, 'parent_location');
            $this->item['parent_id'] = ($raw !== '') ? $this->createOrFetchLocation($raw) : null;
        }

        // company column resolves to company_id. Applies to both create and
        // update paths (the old importer only did this on create - which
        // silently prevented reassigning a location to a different company
        // via re-import). Present-and-empty clears company_id.
        if ($this->csvRowHas($row, 'company')) {
            $raw = $this->findCsvMatch($row, 'company');
            $this->item['company_id'] = ($raw !== '') ? $this->createOrFetchCompany($raw) : null;
        }

        // Manager lookup: the 'manager' CSV column is the full name string
        // (space-separated first + last), matched via createOrFetchUser
        // which reads $this->item['manager'] (and optionally 'manager_username'
        // as an alternate lookup key). Both are internal signals, not
        // fillable on Location, so sanitize's fillable filter drops them
        // before the DB write.
        if ($this->csvRowHas($row, 'manager')) {
            $this->item['manager'] = $this->findCsvMatch($row, 'manager');
        }
        if ($this->csvRowHas($row, 'manager_username')) {
            $this->item['manager_username'] = $this->findCsvMatch($row, 'manager_username');
        }
        if (! empty($this->item['manager'])) {
            if ($manager = $this->createOrFetchUser($row, 'manager')) {
                $this->item['manager_id'] = $manager->id;
            }
        } elseif (array_key_exists('manager', $this->item)) {
            // CSV had the manager column but left it empty - clear the FK.
            $this->item['manager_id'] = null;
        }

        $this->createLocationIfNotExists($row);
    }

    /**
     * Create a location if a duplicate does not exist.
     *
     * @todo Investigate how this should interact with Importer::createLocationIfNotExists
     *
     * @author A. Gianotto
     *
     * @since 6.1.0
     */
    public function createLocationIfNotExists(array $row)
    {
        $editingLocation = false;
        $name = trim($this->item['name'] ?? '');

        $location = Location::where('name', '=', $name)->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override location if an ID was given
            \Log::debug('Finding location by ID: '.$this->findCsvMatch($row, 'id'));
            $location = Location::find($this->findCsvMatch($row, 'id'));
        }

        if ($location) {
            if (! $this->updating) {
                $this->log('A matching Location '.$name.' already exists');
                $this->recordSkipped();

                return;
            }

            $this->log('Updating Location');
            $editingLocation = true;
        } else {
            $this->log('No Matching Location, Create a new one');
            $location = new Location;
            $location->created_by = $this->created_by;
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));

        if ($editingLocation) {
            Log::debug('Updating existing location');
            $location->update($this->sanitizeItemForUpdating($location));
        } else {
            Log::debug('Creating location');
            $location->fill($this->sanitizeItemForStoring($location));
        }

        if ($location->save()) {
            $this->log('Location '.$location->name.' created or updated from CSV import');
            if ($editingLocation) {
                $this->recordUpdated();
            } else {
                $this->recordCreated();
            }

            return $location;

        } else {
            Log::debug($location->getErrors());
            $this->recordErrored();
            $this->logError($location, 'Location "'.$name.'"');

            return $location->errors;
        }

    }
}
