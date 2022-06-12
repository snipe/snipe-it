<?php

namespace App\Importer;

use App\Models\Asset;
use App\Models\Statuslabel;

class AssetImporter extends ItemImporter
{
    protected $defaultStatusLabelId;

    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->defaultStatusLabelId = Statuslabel::first()->id;
    }

    protected function handle($row)
    {
        // ItemImporter handles the general fetching.
        parent::handle($row);

        if ($this->customFields) {
            foreach ($this->customFields as $customField) {
                $customFieldValue = $this->array_smart_custom_field_fetch($row, $customField);

                if ($customFieldValue) {
                    if ($customField->field_encrypted == 1) {
                        $this->item['custom_fields'][$customField->db_column_name()] = \Crypt::encrypt($customFieldValue);
                        $this->log('Custom Field '.$customField->name.': '.\Crypt::encrypt($customFieldValue));
                    } else {
                        $this->item['custom_fields'][$customField->db_column_name()] = $customFieldValue;
                        $this->log('Custom Field '.$customField->name.': '.$customFieldValue);
                    }
                } else {
                    // Clear out previous data.
                    $this->item['custom_fields'][$customField->db_column_name()] = null;
                }
            }
        }


        $this->createAssetIfNotExists($row);
    }

    /**
     * Create the asset if it does not exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array $row
     * @return Asset|mixed|null
     */
    public function createAssetIfNotExists(array $row)
    {
        $editingAsset = false;
        $asset_tag = $this->findCsvMatch($row, 'asset_tag');
        $asset = Asset::where(['asset_tag'=> $asset_tag])->first();
        if ($asset) {
            if (! $this->updating) {
                $this->log('A matching Asset '.$asset_tag.' already exists');

                return;
            }

            $this->log('Updating Asset');
            $editingAsset = true;
        } else {
            $this->log('No Matching Asset, Creating a new one');
            $asset = new Asset;
        }
        $this->item['notes'] = $this->findCsvMatch($row, 'asset_notes');
        $this->item['image'] = $this->findCsvMatch($row, 'image');
        $this->item['requestable'] = $this->fetchHumanBoolean($this->findCsvMatch($row, 'requestable'));
        $asset->requestable = $this->fetchHumanBoolean($this->findCsvMatch($row, 'requestable'));
        $this->item['warranty_months'] = intval($this->findCsvMatch($row, 'warranty_months'));
        $this->item['model_id'] = $this->createOrFetchAssetModel($row);

        // If no status ID is found
        if (! array_key_exists('status_id', $this->item) && ! $editingAsset) {
            $this->log('No status field found, defaulting to first status.');
            $this->item['status_id'] = $this->defaultStatusLabelId;
        }

        $this->item['asset_tag'] = $asset_tag;

        // We need to save the user if it exists so that we can checkout to user later.
        // Sanitizing the item will remove it.
        if (array_key_exists('checkout_target', $this->item)) {
            $target = $this->item['checkout_target'];
        }
        $item = $this->sanitizeItemForStoring($asset, $editingAsset);
        // The location id fetched by the csv reader is actually the rtd_location_id.
        // This will also set location_id, but then that will be overridden by the
        // checkout method if necessary below.
        if (isset($this->item['location_id'])) {
            $item['rtd_location_id'] = $this->item['location_id'];
        }

        $item['last_audit_date'] = null;
        if (isset($this->item['last_audit_date'])) {
            $item['last_audit_date'] = $this->item['last_audit_date'];
        }

        $item['next_audit_date'] = null;
        if (isset($this->item['next_audit_date'])) {
            $item['next_audit_date'] = $this->item['next_audit_date'];
        }

        if ($editingAsset) {
            $asset->update($item);
        } else {
            $asset->fill($item);
        }

        // If we're updating, we don't want to overwrite old fields.
        if (array_key_exists('custom_fields', $this->item)) {
            foreach ($this->item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }

        //FIXME: this disables model validation.  Need to find a way to avoid double-logs without breaking everything.
        // $asset->unsetEventDispatcher();
        if ($asset->save()) {
            $asset->logCreate('Imported using csv importer');
            $this->log('Asset '.$this->item['name'].' with serial number '.$this->item['serial'].' was created');

            // If we have a target to checkout to, lets do so.
            //-- user_id is a property of the abstract class Importer, which this class inherits from and it's setted by
            //-- the class that needs to use it (command importer or GUI importer inside the project).
            if (isset($target)) {
                $asset->fresh()->checkOut($target, $this->user_id, date('Y-m-d H:i:s'));
            }

            return;
        }
        $this->logError($asset, 'Asset "'.$this->item['name'].'"');
    }
}
