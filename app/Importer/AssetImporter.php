<?php
/**
 * Created by PhpStorm.
 * User: parallelgrapefruit
 * Date: 12/24/16
 * Time: 12:45 PM
 */

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Manufacturer;

class AssetImporter extends ItemImporter
{
    protected $assets;
    function __construct($filename, $logCallback, $progressCallback, $errorCallback, $testRun = false, $user_id = -1, $updating = false, $usernameFormat = null)
    {
        parent::__construct($filename, $logCallback, $progressCallback, $errorCallback, $testRun, $user_id, $updating, $usernameFormat);
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
        $asset = null;
        $editingAsset = false;
        $asset = $this->assets->search(function ($key) {
            return strcasecmp($key->asset_tag, $this->item['asset_tag']) == 0;
        });
        if ($asset !== false) {
            $editingAsset = true;
            if (!$this->updating) {
                $this->log('A matching Asset ' . $this->item['asset_tag'] . ' already exists');
                return $asset;
            }
        }

        if (!$asset) {
            $this->log("No Matching Asset, Creating a new one");
            $asset = new Asset;
        }
        $asset_serial = $this->array_smart_fetch($row, "serial number");
        $asset_image = $this->array_smart_fetch($row, "image");
        $asset_warranty_months = intval($this->array_smart_fetch($row, "warranty months"));
        if (empty($asset_warranty_months)) {
            $asset_warranty_months = null;
        }
        // Check for the asset model match and create it if it doesn't exist
        if (!($editingAsset && empty($this->array_smart_fetch($row, 'model name')))) {
            // Ignore the asset_model
            isset($this->item["category"]) || $this->item["category"] = new Category();
            isset($this->item["manufacturer"]) || $this->item["manufacturer"] = new Manufacturer();
            $asset_model = $this->createOrFetchAssetModel($row, $this->item["category"], $this->item["manufacturer"]);
        }
        $item_supplier = $this->array_smart_fetch($row, "supplier");
        // If we're editing, only update if value isn't empty
        if (!($editingAsset && empty($item_supplier))) {
            $supplier = $this->createOrFetchSupplier($item_supplier);
        }

        $this->log('Serial No: '.$asset_serial);
        $this->log('Asset Tag: '.$this->item['asset_tag']);
        $this->log('Notes: '.$this->item["notes"]);
        $this->log('Warranty Months: ' . $asset_warranty_months);


        if (isset($this->item["status_label"])) {
            $status_id = $this->item["status_label"]->id;
        } elseif (!$editingAsset) {
            // Assume if we are editing, we already have a status and can ignore.
            $this->log("No status field found, defaulting to first status.");
            $status_id = $this->status_labels->first()->id;
        }

        if (!$editingAsset) {
            $asset->asset_tag = $this->item['asset_tag']; // This doesn't need to be guarded for empty because it's the key we use to identify the asset.
        }
        if (!empty($this->item['item_name'])) {
            $asset->name = $this->item["item_name"];
        }
        if (!empty($this->item["purchase_date"])) {
            $asset->purchase_date = $this->item["purchase_date"];
        }

        if (array_key_exists('custom_fields', $this->item)) {
            foreach ($this->item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }

        if (!empty($this->item["purchase_cost"])) {
            //TODO How to generalize this for not USD?
            $purchase_cost = substr($this->item["purchase_cost"], 0, 1) === '$' ? substr($this->item["purchase_cost"], 1) : $this->item["purchase_cost"];
            // $asset->purchase_cost = number_format($purchase_cost, 2, '.', '');
            $asset->purchase_cost = Helper::ParseFloat($purchase_cost);
            $this->log("Asset cost parsed: " . $asset->purchase_cost);
        } else {
            $asset->purchase_cost = 0.00;
        }
        if (!empty($asset_serial)) {
            $asset->serial = $asset_serial;
        }
        if (!empty($asset_warranty_months)) {
            $asset->warranty_months = $asset_warranty_months;
        }

        if (isset($asset_model)) {
            $asset->model_id = $asset_model->id;
        }

        if ($this->item["user"]) {
            $asset->assigned_to = $this->item["user"]->id;
        }

        if (isset($this->item["location"])) {
            $asset->rtd_location_id = $this->item["location"]->id;
        }

        $asset->user_id = $this->user_id;
        if (isset($status_id)) {
            $asset->status_id = $status_id;
        }
        if (isset($this->item["company"])) {
            $asset->company_id = $this->item["company"]->id;
        }
        if ($this->item["order_number"]) {
            $asset->order_number = $this->item["order_number"];
        }

        if (isset($supplier)) {
            $asset->supplier_id = $supplier->id;
        }
        if ($this->item["notes"]) {
            $asset->notes = $this->item["notes"];
        }
        if (!empty($asset_image)) {
            $asset->image = $asset_image;
        }
        if (!$editingAsset) {
            $this->assets->add($asset);
        }
        if (!$this->testRun) {
            if ($asset->save()) {
                $asset->logCreate('Imported using csv importer');
                $this->log('Asset ' . $this->item["item_name"] . ' with serial number ' . $asset_serial . ' was created');
            } else {
                $this->jsonError($asset, 'Asset', $asset->getErrors());
            }
        }
    }
}
