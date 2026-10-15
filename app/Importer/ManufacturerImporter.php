<?php

namespace App\Importer;

use App\Models\Manufacturer;
use Illuminate\Support\Facades\Log;

/**
 * When we are importing users via an Asset/etc import, we use createOrFetchUser() in
 * Importer\Importer.php. [ALG]
 *
 * Class ManufacturerImporter
 */
class ManufacturerImporter extends ItemImporter
{
    protected $manufacturers;

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        // ManufacturerImporter deliberately does NOT call parent::handle(). See
        // the other subclass migrations for the same pattern: absent CSV
        // columns stay out of $this->item so update mode preserves the DB
        // value, and present-but-empty cells land as null so update mode
        // clears the DB value. The base sanitize's reject-empty pass is
        // disabled by $rejectEmptyOnUpdate on ItemImporter.
        $this->item = [];

        foreach ([
            'name',
            'support_phone',
            'support_email',
            'url',
            'support_url',
            'warranty_lookup_url',
            'notes',
            'tag_color',
        ] as $field) {
            $this->setItemFromCsvIfPresent($row, $field);
        }

        $this->createManufacturerIfNotExists($row);
    }

    /**
     * Create a manufacturer if a duplicate does not exist.
     *
     * @todo Investigate how this should interact with Importer::createManufacturerIfNotExists
     *
     * @author A. Gianotto
     *
     * @since 6.1.0
     */
    public function createManufacturerIfNotExists(array $row)
    {
        $editingManufacturer = false;
        $name = trim($this->item['name'] ?? '');

        $manufacturer = Manufacturer::where('name', '=', $name)->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override manufacturer if an ID was given
            \Log::debug('Finding manufacturer by ID: '.$this->findCsvMatch($row, 'id'));
            $manufacturer = Manufacturer::find($this->findCsvMatch($row, 'id'));
        }

        if ($manufacturer) {
            if (! $this->updating) {
                $this->log('A matching Manufacturer '.$name.' already exists');
                $this->recordSkipped();

                return;
            }

            $this->log('Updating Manufacturer');
            $editingManufacturer = true;
        } else {
            $this->log('No Matching Manufacturer, Create a new one');
            $manufacturer = new Manufacturer;
            $manufacturer->created_by = $this->created_by;
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));

        if ($editingManufacturer) {
            Log::debug('Updating existing manufacturer');
            $manufacturer->update($this->sanitizeItemForUpdating($manufacturer));
        } else {
            Log::debug('Creating manufacturer');
            $manufacturer->fill($this->sanitizeItemForStoring($manufacturer));
        }

        if ($manufacturer->save()) {
            $this->log('Manufacturer '.$manufacturer->name.' created or updated from CSV import');
            if ($editingManufacturer) {
                $this->recordUpdated();
            } else {
                $this->recordCreated();
            }

            return $manufacturer;

        } else {
            Log::debug($manufacturer->getErrors());
            $this->recordErrored();
            $this->logError($manufacturer, 'Manufacturer "'.$name.'"');

            return $manufacturer->errors;
        }

    }
}
