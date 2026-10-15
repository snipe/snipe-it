<?php

namespace App\Importer;

use App\Models\Supplier;
use Illuminate\Support\Facades\Log;

/**
 * When we are importing users via an Asset/etc import, we use createOrFetchUser() in
 * Importer\Importer.php. [ALG]
 *
 * Class SupplierImporter
 */
class SupplierImporter extends ItemImporter
{
    protected $suppliers;

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        // SupplierImporter deliberately does NOT call parent::handle(). See
        // the other subclass migrations for the same pattern: absent CSV
        // columns stay out of $this->item so update mode preserves the DB
        // value, and present-but-empty cells land as null so update mode
        // clears the DB value. The base sanitize's reject-empty pass is
        // disabled by $rejectEmptyOnUpdate on ItemImporter.
        $this->item = [];

        foreach ([
            'name',
            'address',
            'address2',
            'city',
            'state',
            'country',
            'zip',
            'phone',
            'fax',
            'email',
            'contact',
            'url',
            'notes',
            'tag_color',
        ] as $field) {
            $this->setItemFromCsvIfPresent($row, $field);
        }

        $this->createSupplierIfNotExists($row);
    }

    /**
     * Create a supplier if a duplicate does not exist.
     *
     * @todo Investigate how this should interact with Importer::createSupplierIfNotExists
     *
     * @author A. Gianotto
     *
     * @since 6.1.0
     */
    public function createSupplierIfNotExists(array $row)
    {
        $editingSupplier = false;
        $name = trim($this->item['name'] ?? '');

        $supplier = Supplier::where('name', '=', $name)->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override supplier if an ID was given
            \Log::debug('Finding supplier by ID: '.$this->findCsvMatch($row, 'id'));
            $supplier = Supplier::find($this->findCsvMatch($row, 'id'));
        }

        if ($supplier) {
            if (! $this->updating) {
                $this->log('A matching Supplier '.$name.' already exists');
                $this->recordSkipped();

                return;
            }

            $this->log('Updating Supplier');
            $editingSupplier = true;
        } else {
            $this->log('No Matching Supplier, Create a new one');
            $supplier = new Supplier;
            $supplier->created_by = $this->created_by;
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));

        if ($editingSupplier) {
            Log::debug('Updating existing supplier');
            $supplier->update($this->sanitizeItemForUpdating($supplier));
        } else {
            Log::debug('Creating supplier');
            $supplier->fill($this->sanitizeItemForStoring($supplier));
        }

        if ($supplier->save()) {
            $this->log('Supplier '.$supplier->name.' created or updated from CSV import');
            if ($editingSupplier) {
                $this->recordUpdated();
            } else {
                $this->recordCreated();
            }

            return $supplier;

        } else {
            Log::debug($supplier->getErrors());
            $this->recordErrored();
            $this->logError($supplier, 'Supplier "'.$name.'"');

            return $supplier->errors;
        }

    }
}
