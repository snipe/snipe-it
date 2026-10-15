<?php

namespace App\Importer;

use App\Models\AssetModel;
use App\Models\CustomFieldset;
use App\Models\Depreciation;
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
        // AssetModelImporter deliberately does NOT call parent::handle(). See
        // the other subclass migrations for the same pattern: absent CSV
        // columns stay out of $this->item so update mode preserves the DB
        // value, and present-but-empty cells land as null so update mode
        // clears the DB value. The base sanitize's reject-empty pass is
        // disabled by $rejectEmptyOnUpdate on ItemImporter.
        $this->item = [];

        $this->setItemFromCsvIfPresent($row, 'name');
        $this->setItemFromCsvIfPresent($row, 'model_number');
        $this->setItemFromCsvIfPresent($row, 'min_amt');
        $this->setItemFromCsvIfPresent($row, 'eol');
        $this->setItemFromCsvIfPresent($row, 'notes');

        // Lookup fields resolve a name to an id. Present-and-empty clears
        // the FK; absent preserves it. category_id is required per model
        // validation; clearing it will surface a clear validation error.
        foreach ([
            ['category_id', 'category', fn ($v) => $this->createOrFetchCategory($v)],
            ['manufacturer_id', 'manufacturer', fn ($v) => $this->createOrFetchManufacturer($v)],
            ['depreciation_id', 'depreciation', fn ($v) => $this->fetchDepreciation($v)],
            ['fieldset_id', 'fieldset', fn ($v) => $this->createOrFetchCustomFieldset($v)],
        ] as [$itemKey, $csvKey, $resolver]) {
            if ($this->csvRowHas($row, $csvKey)) {
                $value = $this->findCsvMatch($row, $csvKey);
                $this->item[$itemKey] = ($value !== '') ? $resolver($value) : null;
            }
        }

        // Boolean flags. Present-empty maps to 0; present-with-value uses
        // fetchHumanBoolean; absent leaves the DB value alone on update.
        foreach (['requestable', 'require_serial'] as $flag) {
            if ($this->csvRowHas($row, $flag)) {
                $raw = $this->findCsvMatch($row, $flag);
                $this->item[$flag] = ($this->fetchHumanBoolean($raw) == 1) ? 1 : 0;
            }
        }

        $this->createAssetModelIfNotExists($row);
    }

    /**
     * Create a model if a duplicate does not exist.
     *
     * @todo Investigate how this should interact with Importer::createModelIfNotExists
     *
     * @author A. Gianotto
     *
     * @since 6.1.0
     */
    public function createAssetModelIfNotExists(array $row)
    {

        $editingAssetModel = false;
        $name = $this->item['name'] ?? '';
        $modelNumber = $this->item['model_number'] ?? '';

        /**
         * This part gets a little confusing, since folks might be importing multiple models with the same name and different model numbers for the first time
         * or they might be wanting to update existing models with new model numbers.
         */

        // They are not trying to update existing models, so we'll check for duplicates with model name *and* number
        if (! $this->updating) {
            $this->log('Finding model by name and model number: '.$name.' / '.$modelNumber);
            $assetModel = AssetModel::where('name', '=', $name)->where('model_number', '=', $modelNumber)->first();
        } else {

            if ($this->findCsvMatch($row, 'id') != '') {
                // Override model if an ID was given
                $this->log('Finding model by ID: '.$this->findCsvMatch($row, 'id'));
                $assetModel = AssetModel::find($this->findCsvMatch($row, 'id'));
            } else {
                $this->log('Finding model by name: '.$name);
                $assetModel = AssetModel::where('name', '=', $name)->first();
            }
        }

        if ($assetModel) {
            if (! $this->updating) {
                $this->log('A matching Model '.$name.' already exists and we are not updating. Skipping.');
                $this->recordSkipped();

                return;
            }

            $this->log('Updating Model');
            $editingAssetModel = true;
        } else {
            $this->log('No Matching Model, Create a new one');
            $assetModel = new AssetModel;
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));

        if ($editingAssetModel) {
            Log::debug('Updating existing model');
            $assetModel->update($this->sanitizeItemForUpdating($assetModel));
        } else {
            Log::debug('Creating model');
            $assetModel->fill($this->sanitizeItemForStoring($assetModel));
            $assetModel->created_by = $this->created_by;
        }

        if ($assetModel->save()) {
            $this->log('AssetModel '.$assetModel->name.' created or updated from CSV import');
            if ($editingAssetModel) {
                $this->recordUpdated();
            } else {
                $this->recordCreated();
            }

            return $assetModel;

        } else {
            $this->recordErrored();
            $this->log($assetModel->getErrors()->first());
            $this->addErrorToBag($assetModel, $assetModel->getErrors()->keys()[0], $assetModel->getErrors()->first());

            return $assetModel->getErrors();
        }

    }

    /**
     * Fetch an existing depreciation, or create new if it doesn't exist.
     *
     * We only do a fetch vs create here since Depreciations have additional fields required
     * and cannot be created without them (months, for example.))
     *
     * @author A. Gianotto
     *
     * @since 7.1.3
     *
     * @param  $depreciation_name  string
     * @return int id of depreciation created/found
     */
    public function fetchDepreciation($depreciation_name): ?int
    {
        if ($depreciation_name != '') {

            if ($depreciation = Depreciation::where('name', '=', $depreciation_name)->first()) {
                $this->log('A matching Depreciation '.$depreciation_name.' already exists');

                return $depreciation->id;
            }
        }

        return null;
    }

    /**
     * Fetch an existing fieldset, or create new if it doesn't exist
     *
     * @author A. Gianotto
     *
     * @since 7.1.3
     *
     * @param  $fieldset_name  string
     * @return int id of fieldset created/found
     */
    public function createOrFetchCustomFieldset($fieldset_name): ?int
    {
        if ($fieldset_name != '') {
            $fieldset = CustomFieldset::where('name', '=', $fieldset_name)->first();

            if ($fieldset) {
                $this->log('A matching fieldset '.$fieldset_name.' already exists');

                return $fieldset->id;
            }

            $fieldset = new CustomFieldset;
            $fieldset->name = $fieldset_name;

            if ($fieldset->save()) {
                $this->log('Fieldset '.$fieldset_name.' was created');

                return $fieldset->id;
            }
            $this->logError($fieldset, 'Fieldset');
        }

        return null;
    }
}
