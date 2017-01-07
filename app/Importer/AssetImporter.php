<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Manufacturer;

class AssetImporter extends ItemImporter
{
    protected $assets;
    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->assets = Asset::all();
    }

    protected function handle($row)
    {
        // ItemImporter handles the general fetching.
        parent::handle($row);

        foreach ($this->customFields as $customField) {
            if ($this->item['custom_fields'][$customField->db_column_name()] = $this->array_smart_custom_field_fetch($row, $customField)) {
                $this->log('Custom Field '. $customField->name.': '.$this->array_smart_custom_field_fetch($row, $customField));
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
        $asset = new Asset;
        $asset_id = $this->assets->search(function ($key) {
            return strcasecmp($key->asset_tag, $this->item['asset_tag']) == 0;
        });
        if ($asset_id !== false) {
            if (!$this->updating) {
                $this->log('A matching Asset ' . $this->item['asset_tag'] . ' already exists');
                return;
            }

            $this->log("Updating Asset");
            $editingAsset = true;
            $asset = $this->assets[$asset_id];
        } else {
            $this->log("No Matching Asset, Creating a new one");
        }
        $this->item['serial'] = $this->array_smart_fetch($row, "serial number");
        $this->item['image'] = $this->array_smart_fetch($row, "image");
        $this->item['warranty_months'] = intval($this->array_smart_fetch($row, "warranty months"));
        if ($this->item['asset_model'] = $this->createOrFetchAssetModel($row)) {
            $this->item['model_id'] = $this->item['asset_model']->id;
        }
        if (isset($this->item["status_label"])) {
            $this->item['status_id'] = $this->item["status_label"]->id;
        }
        // We should require a status or come up with a better way of doing this..
        // elseif (!$editingAsset) {
        //     // Assume if we are editing, we already have a status and can ignore.
        //     $this->log("No status field found, defaulting to first status.");
        //     $status_id = $this->status_labels->first()->id;
        // }


        // By default we're set this to location_id in the item.
        $item = $this->sanitizeItemForStoring($asset, $editingAsset);
        if (isset($this->item["location"])) {
            $item['rtd_location_id'] = $this->item['location_id'];
            unset($item['location_id']);
        }
        if ($editingAsset) {
            $asset->update($item);
        } else {
            $asset->fill($item);
        }
        if (array_key_exists('custom_fields', $this->item)) {
            foreach ($this->item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }
        if (!$editingAsset) {
            $this->assets->add($asset);
        }
        if (!$this->testRun) {
            if ($asset->save()) {
                $asset->logCreate('Imported using csv importer');
                $this->log('Asset ' . $this->item["name"] . ' with serial number ' . $this->item['serial'] . ' was created');
                return;
            }
            $this->jsonError($asset, 'Asset "' . $this->item['name'].'"');
        }
    }
}
