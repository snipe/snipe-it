<?php

namespace App\Importer;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;

class ItemImporter extends Importer
{
    protected $item;
    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        // TODO: CHeck if this interferes with checkout to user.. it shouldn't..
        $this->item["user_id"] = $this->user_id;
        $item_category = $this->array_smart_fetch($row, "category");
        $item_company_name = $this->array_smart_fetch($row, "company");
        $item_location = $this->array_smart_fetch($row, "location");
        $item_manufacturer = $this->array_smart_fetch($row, "manufacturer");
        $item_status_name = $this->array_smart_fetch($row, "status");
        $item_supplier = $this->array_smart_fetch($row, "supplier");
        $this->item["name"] = $this->array_smart_fetch($row, "item name");
        $this->item["purchase_date"] = null;
        if ($this->array_smart_fetch($row, "purchase date")!='') {
            $this->item["purchase_date"] = date("Y-m-d 00:00:01", strtotime($this->array_smart_fetch($row, "purchase date")));
        }

        $this->item["purchase_cost"] = $this->array_smart_fetch($row, "purchase cost");
        $this->item["order_number"] = $this->array_smart_fetch($row, "order number");
        $this->item["notes"] = $this->array_smart_fetch($row, "notes");
        $this->item["qty"] = $this->array_smart_fetch($row, "quantity");
        $this->item["requestable"] = $this->array_smart_fetch($row, "requestable");
        $this->item["asset_tag"] = $this->array_smart_fetch($row, "asset tag");

        if ($this->item["user"] = $this->createOrFetchUser($row)) {
            $this->item['assigned_to'] = $this->item['user']->id;
        }

        if ($this->shouldUpdateField($item_location)) {
            if ($this->item["location"] = $this->createOrFetchLocation($item_location)) {
                $this->item["location_id"] = $this->item["location"]->id;
            }
        }
        if ($this->shouldUpdateField($item_category)) {
            if ($this->item["category"] = $this->createOrFetchCategory($item_category)) {
                $this->item["category_id"] = $this->item["category"]->id;
            }
        }
        if ($this->shouldUpdateField($item_manufacturer)) {
            if ($this->item["manufacturer"] = $this->createOrFetchManufacturer($item_manufacturer)) {
                $this->item["manufacturer_id"] = $this->item["manufacturer"]->id;
            }
        }
        if ($this->shouldUpdateField($item_company_name)) {
            if ($this->item["company"] = $this->createOrFetchCompany($item_company_name)) {
                $this->item["company_id"] = $this->item["company"]->id;
            }
        }
        if ($this->shouldUpdateField($item_status_name)) {
            if ($this->item["status_label"] = $this->createOrFetchStatusLabel($item_status_name)) {
                $this->item["status_label_id"] = $this->item["status_label"]->id;
            }
        }
        if ($this->shouldUpdateField($item_supplier)) {
            if ($this->item['supplier'] = $this->createOrFetchSupplier($item_supplier)) {
                $this->item['supplier_id'] = $this->item['supplier']->id;
            }
        }
    }

    /**
     * Cleanup the $item array before storing.
     * We need to remove any values that are not part of the fillable fields.
     * Also, if updating, we remove any fields from the array that are empty.
     *
     * @author Daniel Melzter
     * @since 4.0
     * @param $model SnipeModel Model that's being updated.
     * @param $updating boolean Should we remove blank values?
     * @return array
     */

    protected function sanitizeItemForStoring($model, $updating = false)
    {
        // Create a collection for all manipulations to come.
        $item = collect($this->item);
        // First Filter the item down to the model's fillable fields

        $item = $item->only($model->getFillable());
        // Then iterate through the item and, if we are updating, remove any blank values.
        if ($updating) {
            $item = $item->reject(function ($value, $key) {
                return empty($value);
            });
        }

        return $item->toArray();
    }

    /**
     * Determines if a field needs updating
     * Follows the following rules:
     * If we are not updating, we should update the field
     * If We are updating, we only update the field if it's not empty.
     *
     * @author Daniel Melzter
     * @since 4.0
     * @param $field string
     * @return boolean
     */
    private function shouldUpdateField($field)
    {
        return !($this->updating && empty($field));
    }
    /**
     * Select the asset model if it exists, otherwise create it.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array
     * @param $category Category
     * @param $manufacturer Manufacturer
     * @return AssetModel
     * @internal param $asset_modelno string
     */
    public function createOrFetchAssetModel(array $row)
    {
        $asset_model_name = $this->array_smart_fetch($row, "model name");
        $asset_modelNumber = $this->array_smart_fetch($row, "model number");
        // TODO: At the moment, this means  we can't update the model number if the model name stays the same.
        if (!$this->shouldUpdateField($asset_model_name)) {
            return;
        }
        if ((empty($asset_model_name))  && (!empty($asset_modelNumber))) {
            $asset_model_name = $asset_modelNumber;
        } elseif ((empty($asset_model_name))  && (empty($asset_modelNumber))) {
            $asset_model_name ='Unknown';
        }

        $this->log('Model Name: ' . $asset_model_name);
        $this->log('Model No: ' . $asset_modelNumber);
        $editingModel = $this->updating;
        $asset_model_id = $this->asset_models->search(function ($key) use ($asset_model_name, $asset_modelNumber) {
            return strcasecmp($key->name, $asset_model_name) ==0
                && $key->model_number == $asset_modelNumber;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        $asset_model = new AssetModel;
        $item = $this->sanitizeItemForStoring($asset_model, $editingModel);
        $item['name'] = $asset_model_name;
        $item['model_number'] = $asset_modelNumber;
        if ($asset_model_id !== false) {
            $asset_model = $this->asset_models[$asset_model_id];
            if (!$this->updating) {
                $this->log("A matching model already exists, returning it.");
                return $asset_model;
            }
            $this->log("Matching Model found, updating it.");
            $asset_model->update($item);
            if (!$this->testRun) {
                $asset_model->save();
            }
            return $asset_model;
        }
        $this->log("No Matching Model, Creating a new one");
        $asset_model = new AssetModel();
        $asset_model->fill($item);
        $this->asset_models->add($asset_model);

        if ($this->testRun) {
            $this->log('TEST RUN - asset_model  ' . $asset_model->name . ' not created');
            return $asset_model;
        }

        if ($asset_model->save()) {
            $this->log('Asset Model ' . $asset_model_name . ' with model number ' . $asset_modelNumber . ' was created');
            return $asset_model;
        }
        $this->jsonError($asset_model, 'Asset Model "' . $asset_model_name . '"');
        return;
    }

    /**
     * Finds a category with the same name and item type in the database, otherwise creates it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $asset_category string
     * @return Category
     * @internal param string $item_type
     */
    public function createOrFetchCategory($asset_category)
    {
        // Magic to transform "AssetImporter" to "asset" or similar.
        $classname = class_basename(get_class($this));
        $item_type = strtolower(substr($classname, 0, strpos($classname, 'Importer')));
        if (empty($asset_category)) {
            $asset_category = 'Unnamed Category';
        }
        $category = $this->categories->search(function ($key) use ($asset_category, $item_type) {
            return (strcasecmp($key->name, $asset_category) == 0)
                && $key->category_type === $item_type;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($category !== false) {
            $this->log("A matching category: " . $asset_category . " already exists");
            return $this->categories[$category];
        }

        $category = new Category();
        $category->name = $asset_category;
        $category->category_type = $item_type;
        $category->user_id = $this->user_id;

        if ($this->testRun) {
            $this->categories->add($category);
            return $category;
        }
        if ($category->save()) {
            $this->categories->add($category);
            $this->log('Category ' . $asset_category . ' was created');
            return $category;
        }

        $this->jsonError($category, 'Category "'. $asset_category. '"');
    }

    /**
     * Fetch an existing company, or create new if it doesn't exist
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $asset_company_name string
     * @return Company
     */
    public function createOrFetchCompany($asset_company_name)
    {
        $company = $this->companies->search(function ($key) use ($asset_company_name) {
            return strcasecmp($key->name, $asset_company_name) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($company !== false) {
            $this->log('A matching Company ' . $asset_company_name . ' already exists');
            return $this->companies[$company];
        }
        $company = new Company();
        $company->name = $asset_company_name;

        if ($this->testRun) {
            $this->companies->add($company);
            return $company;
        }
        if ($company->save()) {
            $this->companies->add($company);
            $this->log('Company ' . $asset_company_name . ' was created');
            return $company;
        }
        $this->jsonError($company, 'Company');
        return;
    }

    /**
     * Fetch the existing status label or create new if it doesn't exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param string $asset_statuslabel_name
     * @return Statuslabel|null
     */
    public function createOrFetchStatusLabel($asset_statuslabel_name)
    {
        if (empty($asset_statuslabel_name)) {
            return null;
        }
        $status = $this->status_labels->search(function ($key) use ($asset_statuslabel_name) {
            return strcasecmp($key->name, $asset_statuslabel_name) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($status !== false) {
            $this->log('A matching Status ' . $asset_statuslabel_name . ' already exists');
            return $this->status_labels[$status];
        }
        $this->log("Creating a new status");
        $status = new Statuslabel();
        $status->name = $asset_statuslabel_name;

        $status->deployable = 1;
        $status->pending = 0;
        $status->archived = 0;

        if ($this->testRun) {
            $this->status_labels->add($status);
            return $status;
        }

        if ($status->save()) {
            $this->status_labels->add($status);
            $this->log('Status ' . $asset_statuslabel_name . ' was created');
            return $status;
        }

        $this->jsonError($status, 'Status "'. $asset_statuslabel_name . '"');
        return;
    }

    /**
     * Finds a manufacturer with matching name, otherwise create it.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $item_manufacturer string
     * @return Manufacturer
     */

    public function createOrFetchManufacturer($item_manufacturer)
    {

        if (empty($item_manufacturer)) {
            $item_manufacturer='Unknown';
        }
        $manufacturer = $this->manufacturers->search(function ($key) use ($item_manufacturer) {
            return strcasecmp($key->name, $item_manufacturer) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($manufacturer !== false) {
            $this->log('Manufacturer ' . $item_manufacturer . ' already exists') ;
            return $this->manufacturers[$manufacturer];
        }

        //Otherwise create a manufacturer.
        $manufacturer = new Manufacturer();
        $manufacturer->name = $item_manufacturer;
        $manufacturer->user_id = $this->user_id;

        if ($this->testRun) {
            $this->manufacturers->add($manufacturer);
            return $manufacturer;
        }
        if ($manufacturer->save()) {
            $this->manufacturers->add($manufacturer);
            $this->log('Manufacturer ' . $manufacturer->name . ' was created');
            return $manufacturer;
        }
        $this->jsonError($manufacturer, 'Manufacturer "'. $manufacturer->name . '"');
        return;
    }

    /**
     * Checks the DB to see if a location with the same name exists, otherwise create it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $asset_location string
     * @return Location|null
     */
    public function createOrFetchLocation($asset_location)
    {
        if (empty($asset_location)) {
            $this->log('No location given, so none created.');
            return null;
        }
        $location = $this->locations->search(function ($key) use ($asset_location) {
            return strcasecmp($key->name, $asset_location) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($location !== false) {
            $this->log('Location ' . $asset_location . ' already exists');
            return $this->locations[$location];
        }
        // No matching locations in the collection, create a new one.
        $location = new Location();
        $location->name = $asset_location;
        $location->address = '';
        $location->city = '';
        $location->state = '';
        $location->country = '';
        $location->user_id = $this->user_id;

        if ($this->testRun) {
            $this->locations->add($location);
            return $location;
        }
        if ($location->save()) {
            $this->locations->add($location);
            $this->log('Location ' . $asset_location . ' was created');
            return $location;
        }
        $this->jsonError($location, 'Location');
        return;
    }

    /**
     * Fetch an existing supplier or create new if it doesn't exist
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $row array
     * @return Supplier
     */
    public function createOrFetchSupplier($item_supplier)
    {
        if (empty($item_supplier)) {
            $item_supplier='Unknown';
        }

        $supplier = $this->suppliers->search(function ($key) use ($item_supplier) {
            return strcasecmp($key->name, $item_supplier) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if ($supplier !== false) {
            $this->log('Supplier ' . $item_supplier . ' already exists');
            return $this->suppliers[$supplier];
        }

        $supplier = new Supplier();
        $supplier->name = $item_supplier;
        $supplier->user_id = $this->user_id;

        if ($this->testRun) {
            $this->suppliers->add($supplier);
            return $supplier;
        }
        if ($supplier->save()) {
            $this->suppliers->add($supplier);
            $this->log('Supplier ' . $item_supplier . ' was created');
            return $supplier;
        }
        $this->jsonError($supplier, 'Supplier');
        return;
    }
}
