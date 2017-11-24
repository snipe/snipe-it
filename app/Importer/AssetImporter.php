<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Manufacturer;
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
                    $this->item['custom_fields'][$customField->db_column_name()] = $customFieldValue;
                    $this->log('Custom Field '. $customField->name.': '.$customFieldValue);
                } else {
                    // This removes custom fields when updating if the column doesn't exist in file.
                    // Commented out becausee not sure if it's needed anywhere.
                    // $this->item['custom_fields'][$customField->db_column_name()] = '';
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
        $asset_tag = $this->findCsvMatch($row, "asset_tag");
        $asset = Asset::where(['asset_tag'=> $asset_tag])->first();
        if ($asset) {
            if (!$this->updating) {
                $this->log('A matching Asset ' . $asset_tag . ' already exists');
                return;
            }

            $this->log("Updating Asset");
            $editingAsset = true;
        } else {
            $this->log("No Matching Asset, Creating a new one");
            $asset = new Asset;
        }

        $this->item['image'] = $this->findCsvMatch($row, "image");
        $this->item['warranty_months'] = intval($this->findCsvMatch($row, "warranty_months"));
        $this->item['model_id'] = $this->createOrFetchAssetModel($row);

        // If no status ID is found
        if (!array_key_exists('status_id', $this->item) && !$editingAsset) {
            $this->log("No status field found, defaulting to first status.");
            $this->item['status_id'] = $this->defaultStatusLabelId;
        }

        $this->item['asset_tag'] = $asset_tag;
        $item = $this->sanitizeItemForStoring($asset, $editingAsset);
        // By default we're set this to location_id in the item.
        if (isset($this->item["location_id"])) {
            $item['rtd_location_id'] = $this->item['location_id'];
            unset($item['location_id']);
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
        if ($asset->save()) {
            $asset->logCreate('Imported using csv importer');
            $this->log('Asset ' . $this->item["name"] . ' with serial number ' . $this->item['serial'] . ' was created');
            return;
        }
        $this->logError($asset, 'Asset "' . $this->item['name'].'"');
    }
}
