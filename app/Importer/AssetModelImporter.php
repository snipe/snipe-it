<?php

namespace App\Importer;

use App\Models\AssetModel;
use Illuminate\Support\Facades\Log;

/**
 * When we are importing users via an Asset/etc import, we use createOrFetchUser() in
 * Importer\Importer.php. [ALG]
 *
 * Class LocationImporter
 */
class AssetModelImporter extends ItemImporter
{
    protected $models;

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        parent::handle($row);
        $this->createAssetModelIfNotExists($row);
    }

    /**
     * Create a model if a duplicate does not exist.
     * @todo Investigate how this should interact with Importer::createModelIfNotExists
     *
     * @author A. Gianotto
     * @since 6.1.0
     * @param array $row
     */
    public function createAssetModelIfNotExists(array $row)
    {

        $editingAssetModel = false;
        $assetmodel = AssetModel::where('name', '=', $this->findCsvMatch($row, 'name'))->first();

        if ($assetmodel) {
            if (! $this->updating) {
                $this->log('A matching Model '.$this->item['name'].' already exists');
                return;
            }

            $this->log('Updating Model');
            $editingAssetModel = true;
        } else {
            $this->log('No Matching Model, Create a new one');
            $assetmodel = new AssetModel();
        }

        // Pull the records from the CSV to determine their values
        $this->item['name'] = trim($this->findCsvMatch($row, 'name'));
        $this->item['category'] = trim($this->findCsvMatch($row, 'category'));
        $this->item['manufacturer'] = trim($this->findCsvMatch($row, 'manufacturer'));
        $this->item['min_amt'] = trim($this->findCsvMatch($row, 'min_amt'));
        $this->item['model_number'] = trim($this->findCsvMatch($row, 'model_number'));
        $this->item['notes'] = trim($this->findCsvMatch($row, 'notes'));
        $this->item['user_id'] = auth()->id();


        if (!empty($this->item['category'])) {
            if ($category = $this->createOrFetchCategory($row, 'category')) {
                $this->item['category_id'] = $category->id;
            }
        }
        if (!empty($this->item['manufacturer'])) {
            if ($manufacturer = $this->createOrFetchManufacturer($row, 'manufacturer')) {
                $this->item['manufacturer_id'] = $manufacturer->id;
            }
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));


        if ($editingAssetModel) {
            Log::debug('Updating existing model');
            $assetmodel->update($this->sanitizeItemForUpdating($assetmodel));
        } else {
            Log::debug('Creating model');
            $assetmodel->fill($this->sanitizeItemForStoring($assetmodel));
        }

        if ($assetmodel->save()) {
            $this->log('AssetModel '.$assetmodel->name.' created or updated from CSV import');
            return $assetmodel;

        } else {
            Log::debug($assetmodel->getErrors());
            return $assetmodel->errors;
        }


    }
}