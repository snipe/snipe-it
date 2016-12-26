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
    function __construct($filename, $logCallback, $progressCallback, $errorCallback, $testRun = false, $user_id = -1, $updating = false, $usernameFormat = null)
    {
        parent::__construct($filename, $logCallback, $progressCallback, $errorCallback, $testRun, $user_id, $updating, $usernameFormat);
    }

    protected function handle($row)
    {
        $item_category = $this->array_smart_fetch($row, "category");
        $item_company_name = $this->array_smart_fetch($row, "company");
        $item_location = $this->array_smart_fetch($row, "location");
        $item_manufacturer = $this->array_smart_fetch($row, "manufacturer");
        $item_status_name = $this->array_smart_fetch($row, "status");
        $this->item["item_name"] = $this->array_smart_fetch($row, "item name");
        if ($this->array_smart_fetch($row, "purchase date")!='') {
            $this->item["purchase_date"] = date("Y-m-d 00:00:01", strtotime($this->array_smart_fetch($row, "purchase date")));
        } else {
            $this->item["purchase_date"] = null;
        }

        $this->item["purchase_cost"] = $this->array_smart_fetch($row, "purchase cost");
        $this->item["order_number"] = $this->array_smart_fetch($row, "order number");
        $this->item["notes"] = $this->array_smart_fetch($row, "notes");
        $this->item["quantity"] = $this->array_smart_fetch($row, "quantity");
        $this->item["requestable"] = $this->array_smart_fetch($row, "requestable");
        $this->item["asset_tag"] = $this->array_smart_fetch($row, "asset tag");

        $this->item["user"] = $this->createOrFetchUser($row);

        if (!($this->updating && empty($item_location))) {
            $this->item["location"] = $this->createOrFetchLocation($item_location);
        }
        if (!($this->updating && empty($item_category))) {
            $this->item["category"] = $this->createOrFetchCategory($item_category);
        }
        if (!($this->updating && empty($item_manufacturer))) {
            $this->item["manufacturer"] = $this->createOrFetchManufacturer($item_manufacturer);
        }
        if (!($this->updating && empty($item_company_name))) {
            $this->item["company"] = $this->createOrFetchCompany($item_company_name);
        }

        if (!($this->updating && empty($item_status_name))) {
            $this->item["status_label"] = $this->createOrFetchStatusLabel($item_status_name);
        }
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
    public function createOrFetchAssetModel(array $row, $category, $manufacturer)
    {
        $asset_model_name = $this->array_smart_fetch($row, "model name");
        $asset_modelNumber = $this->array_smart_fetch($row, "model number");
        if ((empty($asset_model_name))  && (!empty($asset_modelNumber))) {
            $asset_model_name = $asset_modelNumber;
        } elseif ((empty($asset_model_name))  && (empty($asset_modelNumber))) {
            $asset_model_name ='Unknown';
        }
        $this->log('Model Name: ' . $asset_model_name);
        $this->log('Model No: ' . $asset_modelNumber);

        $asset_model = null;
        $editingModel = $this->updating;
        $asset_model = $this->asset_models->search(function ($key) use ($asset_model_name, $asset_modelNumber) {
            return strcasecmp($key->name, $asset_model_name) ==0
                && $key->model_number == $asset_modelNumber;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if(($asset_model !== false) && !$editingModel) {
            return $this->asset_models[$asset_model];
        } else {
            $this->log("No Matching Model, Creating a new one");
            $asset_model = new AssetModel();
        }
        if (($editingModel && ($asset_model_name != "Unknown"))
            || (!$editingModel)) {
            $asset_model->name = $asset_model_name;
        }
        isset($manufacturer) && $manufacturer->exists() && $asset_model->manufacturer_id = $manufacturer->id;
        isset($asset_modelNumber) && $asset_model->model_number = $asset_modelNumber;
        if (isset($category) && $category->exists()) {
            $asset_model->category_id = $category->id;
        }
        $asset_model->user_id = $this->user_id;

        if (!$editingModel) {
            $this->asset_models->add($asset_model);
        }
        if (!$this->testRun) {
            if ($asset_model->save()) {
                $this->log('Asset Model ' . $asset_model_name . ' with model number ' . $asset_modelNumber . ' was created');
                return $asset_model;
            } else {
                $this->jsonError($asset_model,'Asset Model "' . $asset_model_name . '"', $asset_model->getErrors());
                $this->log('Asset Model "' . $asset_model_name . '"' . $asset_model->getErrors());
                return $asset_model;
            }
        } else {
            $this->asset_models->add($asset_model);
            return $asset_model;
        }

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
        $classname = get_class($this);
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
            return $this->categories[$category];
        }

        $category = new Category();

        $category->name = $asset_category;
        $category->category_type = $item_type;
        $category->user_id = $this->user_id;

        if (!$this->testRun) {
            if ($category->save()) {
                $this->categories->add($category);
                $this->log('Category ' . $asset_category . ' was created');
                return $category;
            } else {
                $this->jsonError($category, 'Category "'. $asset_category. '"', $category->getErrors());
                return $category;
            }
        } else {
            $this->categories->add($category);
            return $category;
        }

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
        $company = $this->companies->search(function ($key) use($asset_company_name) {
            return strcasecmp($key->name, $asset_company_name) == 0;
        });
        // We need strict compare here because the index returned above can be 0.
        //  This casts to false and causes false positives
        if($company !== false) {
            $this->log('A matching Company ' . $asset_company_name . ' already exists');
            return $this->companies[$company];
        }
        $company = new Company();
        $company->name = $asset_company_name;

        if (!$this->testRun) {
            if ($company->save()) {
                $this->companies->add($company);
                $this->log('Company ' . $asset_company_name . ' was created');
                return $company;
            } else {
                $this->log('Company', $company->getErrors());
            }
        } else {
            $this->companies->add($company);
            return $company;
        }
    }

    /**
     * Fetch the existing status label or create new if it doesn't exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param string $asset_statuslabel_name
     * @return Statuslabel
     */
    public function createOrFetchStatusLabel($asset_statuslabel_name)
    {
        if (empty($asset_statuslabel_name)) {
            return null;
        }
        $status = $this->status_labels->search(function ($key) use($asset_statuslabel_name) {
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

        if (!$this->testRun) {
            if ($status->save()) {
                $this->status_labels->add($status);
                $this->log('Status ' . $asset_statuslabel_name . ' was created');
                return $status;
            } else {
                $this->jsonError($status,'Status "'. $asset_statuslabel_name . '"', $status->getErrors());
                return $status;
            }
        } else {
            $this->status_labels->add($status);
            return $status;
        }
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
        $manufacturer = $this->manufacturers->search(function ($key) use($item_manufacturer) {
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

        if (!$this->testRun) {
            if ($manufacturer->save()) {
                $this->manufacturers->add($manufacturer);
                $this->log('Manufacturer ' . $manufacturer->name . ' was created');
                return $manufacturer;
            } else {
                $this->jsonError($manufacturer, 'Manufacturer "'. $manufacturer->name . '"', $manufacturer->getErrors());
                return $manufacturer;
            }

        } else {
            $this->manufacturers->add($manufacturer);
            return $manufacturer;
        }
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
        $location = $this->locations->search(function ($key) use($asset_location) {
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

        if (!$this->testRun) {
            if ($location->save()) {
                $this->locations->add($location);
                $this->log('Location ' . $asset_location . ' was created');
                return $location;
            } else {
                $this->log('Location', $location->getErrors()) ;
                return $location;
            }
        } else {
            $this->locations->add($location);
            return $location;
        }
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

        $supplier = $this->suppliers->search(function ($key) use($item_supplier) {
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

        if (!$this->testRun) {
            if ($supplier->save()) {
                $this->suppliers->add($supplier);
                $this->log('Supplier ' . $item_supplier . ' was created');
                return $supplier;
            } else {
                $this->log('Supplier', $supplier->getErrors());
                return $supplier;
            }
        } else {
            $this->suppliers->add($supplier);
            return $supplier;
        }
    }


}