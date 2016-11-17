<?php
namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use ForceUTF8\Encoding;

ini_set('max_execution_time', 600); //600 seconds = 10 minutes
ini_set('memory_limit', '500M');

/**
 * Class ObjectImportCommand
 */
class ObjectImportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Items from CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $filename = $this->argument('filename');

        $tmp_password  = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $password = bcrypt($tmp_password);

        $this->updating = $this->option('update');
        if (!$this->option('web-importer')) {
            $logFile = $this->option('logfile');
            \Log::useFiles($logFile);
            if ($this->option('testrun')) {
                $this->comment('====== TEST ONLY Asset Import for '.$filename.' ====');
                $this->comment('============== NO DATA WILL BE WRITTEN ==============');
            } else {

                $this->comment('======= Importing Assets from '.$filename.' =========');
            }
        }

        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromPath($this->argument('filename'));
        $csv->setNewline("\r\n");
        $results = $csv->fetchAssoc();
        $newarray = null;

        foreach ($results as $index => $arraytoNormalize) {
            $internalnewarray = array_change_key_case($arraytoNormalize);
            $newarray[$index] = $internalnewarray;
        }



        $this->locations = Location::All(['name', 'id']);
        $this->categories = Category::All(['name', 'category_type', 'id']);
        $this->manufacturers = Manufacturer::All(['name', 'id']);
        $this->asset_models = AssetModel::All(['name','model_number','category_id','manufacturer_id', 'id']);
        $this->companies = Company::All(['name', 'id']);
        $this->status_labels = Statuslabel::All(['name', 'id']);
        $this->suppliers = Supplier::All(['name', 'id']);
        switch (strtolower($this->option('item-type'))) {
            case "asset":
                $this->assets = Asset::all();
                break;
            case "accessory":
                $this->accessories = Accessory::All();
                break;
            case "consumable":
                $this->consumables = Consumable::All();
                break;
        }
        $this->customfields = CustomField::All(['name']);
        $bar = null;

        if (!$this->option('web-importer')) {
            $bar = $this->output->createProgressBar(count($newarray));
        }
        // Loop through the records
        DB::transaction(function () use (&$newarray, $bar, $password) {
            Model::unguard();
            $item_type = strtolower($this->option('item-type'));



            foreach ($newarray as $row) {

                // Let's just map some of these entries to more user friendly words

                // Fetch general items here, fetch item type specific items in respective methods
                /** @var Asset, License, Accessory, or Consumable $item_type */

                $item_category = $this->array_smart_fetch($row, "category");
                $item_company_name = $this->array_smart_fetch($row, "company");
                $item_location = $this->array_smart_fetch($row, "location");
                $item_manufacturer = $this->array_smart_fetch($row, "manufacturer");
                $item_status_name = $this->array_smart_fetch($row, "status");

                $item["item_name"] = $this->array_smart_fetch($row, "item name");
                if ($this->array_smart_fetch($row, "purchase date")!='') {
                    $item["purchase_date"] = date("Y-m-d 00:00:01", strtotime($this->array_smart_fetch($row, "purchase date")));
                } else {
                    $item["purchase_date"] = null;
                }

                $item["purchase_cost"] = $this->array_smart_fetch($row, "purchase cost");
                $item["order_number"] = $this->array_smart_fetch($row, "order number");
                $item["notes"] = $this->array_smart_fetch($row, "notes");
                $item["quantity"] = $this->array_smart_fetch($row, "quantity");
                $item["requestable"] = $this->array_smart_fetch($row, "requestable");
                $item["asset_tag"] = $this->array_smart_fetch($row, "asset tag");


                $this->current_assetId = $item["item_name"];
                if ($item["asset_tag"] != '') {
                    $this->current_assetId = $item["asset_tag"];
                }
                $this->log('Category: ' . $item_category);
                $this->log('Location: ' . $item_location);
                $this->log('Manufacturer: ' . $item_manufacturer);
                $this->log('Purchase Date: ' . $item["purchase_date"]);
                $this->log('Purchase Cost: ' . $item["purchase_cost"]);
                $this->log('Company Name: ' . $item_company_name);
                $this->log('Status: ' . $item_status_name);


                $item["user"] = $this->createOrFetchUser($row, $password);

                if (!($this->updating && empty($item_location))) {
                    $item["location"] = $this->createOrFetchLocation($item_location);
                }
                if (!($this->updating && empty($item_category))) {
                    $item["category"] = $this->createOrFetchCategory($item_category, $item_type);
                }
                if (!($this->updating && empty($item_manufacturer))) {
                    $item["manufacturer"] = $this->createOrFetchManufacturer($item_manufacturer);
                }
                if (!($this->updating && empty($item_company_name))) {
                    $item["company"] = $this->createOrFetchCompany($item_company_name);
                }

                if (!($this->updating && empty($item_status_name))) {
                    $item["status_label"] = $this->createOrFetchStatusLabel($item_status_name);
                }

                switch ($item_type) {
                    case "asset":
                        // -----------------------------
                        // CUSTOM FIELDS
                        // -----------------------------
                        // Loop through custom fields in the database and see if we have any matches in the CSV
                        foreach ($this->customfields as $customfield) {
                            if ($item['custom_fields'][$customfield->db_column_name()] = $this->array_smart_custom_field_fetch($row, $customfield)) {
                                $this->log('Custom Field '. $customfield->name.': '.$this->array_smart_custom_field_fetch($row, $customfield));
                            }

                        }

                        $this->createAssetIfNotExists($row, $item);
                        break;
                    case "accessory":
                        $this->createAccessoryIfNotExists($item);
                        break;
                    case 'consumable':
                        $this->createConsumableIfNotExists($item);
                        break;
                }

                if (!$this->option('web-importer')) {
                    $bar->advance();
                }
                $this->log('------------- Action Summary ----------------');

            }
        });
        if (!$this->option('web-importer')) {
            $bar->finish();
        }


            $this->log('=====================================');
        if (!$this->option('web-importer')) {
            if (!empty($this->errors)) {
                $this->comment("The following Errors were encountered.");
                foreach ($this->errors as $asset => $error) {
                    $this->comment('Error: Item: ' . $asset . 'failed validation: ' . json_encode($error));
                }
            } else {
                $this->comment("All Items imported successfully!");
            }
        } else {
            if (empty($this->errors)) {
                return 0;
            } else {
                $this->comment(json_encode($this->errors)); //Send a big string to the
                return 1;
            }
        }
            $this->comment("");

            return 2;
    }
    // Tracks the current item for error messages
    private $current_assetId;
    private $updating;
    // An array of errors encountered while parsing
    private $errors;

    public function jsonError($field, $errorString)
    {
        $this->errors[$this->current_assetId][$field] = $errorString;
        if ($this->option('verbose')) {
            parent::error($field . $errorString);
        }
    }

    /**
     * Log a message to file, configurable by the --log-file parameter.
     * If a warning message is passed, we'll spit it to the console as well.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param string $string
     * @param string $level
    */
    private function log($string, $level = 'info')
    {
        if ($this->option('web-importer')) {
            return;
        }
        if ($level === 'warning') {
            \Log::warning($string);
            $this->comment($string);
        } else {
            \Log::Info($string);
            if ($this->option('verbose')) {
                $this->comment($string);
            }
        }
    }

    /**
     * Check to see if the given key exists in the array, and trim excess white space before returning it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $array array
     * @param $key string
     * @param $default string
     * @return string
     */
    public function array_smart_fetch(array $array, $key, $default = '')
    {
        return array_key_exists(trim($key), $array) ? e(Encoding::fixUTF8(trim($array[ $key ]))) : $default;
    }


    /**
     * Figure out the fieldname of the custom field
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since 3.0
     * @param $array array
     * @return string
     */
    public function array_smart_custom_field_fetch(array $array, $key)
    {
        $index_name = strtolower($key->name);
        return array_key_exists($index_name, $array) ? e(trim($array[$index_name])) : '';
    }



    private $asset_models;
    /**
     * Select the asset model if it exists, otherwise create it.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array
     * @param $category Category
     * @param $manufacturer Manufacturer
     * @return Model
     * @internal param $asset_modelno string
     */
    public function createOrFetchAssetModel(array $row, $category, $manufacturer)
    {

        $asset_model_name = $this->array_smart_fetch($row, "model name");
        $asset_modelno = $this->array_smart_fetch($row, "model number");
        if ((empty($asset_model_name))  && (!empty($asset_modelno))) {
            $asset_model_name = $asset_modelno;
        } elseif ((empty($asset_model_name))  && (empty($asset_modelno))) {
            $asset_model_name ='Unknown';
        }
        if (empty($asset_modelno)) {
            $asset_modelno='';
        }
        $this->log('Model Name: ' . $asset_model_name);
        $this->log('Model No: ' . $asset_modelno);

        $asset_model = null;
        $editingModel = false;
        foreach ($this->asset_models as $tempmodel) {
            if (strcasecmp($tempmodel->name, $asset_model_name) == 0
                && $tempmodel->model_number == $asset_modelno) {
                $this->log('A matching model ' . $asset_model_name . ' already exists');
                if (!$this->option('update')) {
                    return $tempmodel;
                }
                $this->log('Updating matching model with new values');
                $editingModel = true;
                $asset_model = $tempmodel;
            }
        }
        if (is_null($asset_model)) {
            $this->log("No Matching Model, Creating a new one");
            $asset_model = new AssetModel();
        }
        if (($editingModel && (!$asset_model_name === "Unknown")) || (!$editingModel)) {
            $asset_model->name = $asset_model_name;
        }
        isset($manufacturer) && $manufacturer->exists && $asset_model->manufacturer_id = $manufacturer->id;
        isset($asset_modelno) && $asset_model->model_number = $asset_modelno;
        if (isset($category) && $category->exists) {
            $asset_model->category_id = $category->id;
        }
        $asset_model->user_id = $this->option('user_id');

        if (!$editingModel) {
                $this->asset_models->add($asset_model);
        }
        if (!$this->option('testrun')) {
            if ($asset_model->save()) {
                $this->log('Asset Model ' . $asset_model_name . ' with model number ' . $asset_modelno . ' was created');
                return $asset_model;
            } else {
                $this->jsonError('Asset Model "' . $asset_model_name . '"', $asset_model->getErrors());
                $this->log('Asset Model "' . $asset_model_name . '"', $asset_model->getErrors());
                return $asset_model;
            }
        } else {
            $this->asset_models->add($asset_model);
            return $asset_model;
        }

    }

    private $categories;

    /**
     * Finds a category with the same name and item type in the database, otherwise creates it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $asset_category string
     * @param $item_type string
     * @return Category
     */
    public function createOrFetchCategory($asset_category, $item_type)
    {
        if (empty($asset_category)) {
            $asset_category = 'Unnamed Category';
        }

        foreach ($this->categories as $tempcategory) {
            if ((strcasecmp($tempcategory->name, $asset_category) == 0) && $tempcategory->category_type === $item_type) {
                $this->log('Category ' . $asset_category . ' already exists');
                return $tempcategory;
            }
        }

        $category = new Category();

        $category->name = $asset_category;
        $category->category_type = $item_type;
        $category->user_id = $this->option('user_id');


        if (!$this->option('testrun')) {
            if ($category->save()) {
                $this->categories->add($category);
                $this->log('Category ' . $asset_category . ' was created');
                return $category;
            } else {
                $this->jsonError('Category "'. $asset_category. '"', $category->getErrors());
                return $category;
            }
        } else {
            $this->categories->add($category);
            return $category;
        }

    }

    private $companies;

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
        foreach ($this->companies as $tempcompany) {
            if (strcasecmp($tempcompany->name, $asset_company_name) == 0) {
                $this->log('A matching Company ' . $asset_company_name . ' already exists');
                return $tempcompany;
            }
        }

        $company = new Company();
        $company->name = $asset_company_name;

        if (!$this->option('testrun')) {
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
    private $status_labels;
    /**
     * Fetch the existing status label or create new if it doesn't exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param string $asset_statuslabel_name
     * @return Company
     */
    public function createOrFetchStatusLabel($asset_statuslabel_name)
    {
        if (empty($asset_statuslabel_name)) {
            return;
        }
        foreach ($this->status_labels as $tempstatus) {
            if (strcasecmp($tempstatus->name, $asset_statuslabel_name) == 0) {
                $this->log('A matching Status ' . $asset_statuslabel_name . ' already exists');
                return $tempstatus;
            }
        }
        $status = new Statuslabel();
        $status->name = $asset_statuslabel_name;

        $status->deployable = 1;
        $status->pending = 0;
        $status->archived = 0;


        if (!$this->option('testrun')) {
            if ($status->save()) {
                $this->status_labels->add($status);
                $this->log('Status ' . $asset_statuslabel_name . ' was created');
                return $status;
            } else {
                $this->jsonError('Status "'. $asset_statuslabel_name . '"', $status->getErrors());
                return $status;
            }
        } else {
            $this->status_labels->add($status);
            return $status;
        }
    }

    private $manufacturers;

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

        foreach ($this->manufacturers as $tempmanufacturer) {
            if (strcasecmp($tempmanufacturer->name, $item_manufacturer) == 0) {
                $this->log('Manufacturer ' . $item_manufacturer . ' already exists') ;
                return $tempmanufacturer;
            }
        }

        //Otherwise create a manufacturer.

        $manufacturer = new Manufacturer();
        $manufacturer->name = $item_manufacturer;
        $manufacturer->user_id = $this->option('user_id');

        if (!$this->option('testrun')) {
            if ($manufacturer->save()) {
                $this->manufacturers->add($manufacturer);
                $this->log('Manufacturer ' . $manufacturer->name . ' was created');
                return $manufacturer;
            } else {
                $this->jsonError('Manufacturer "'. $manufacturer->name . '"', $manufacturer->getErrors());
                return $manufacturer;
            }

        } else {
            $this->manufacturers->add($manufacturer);
            return $manufacturer;
        }
    }

    /**
     * @var
     */
    private $locations;
    /**
     * Checks the DB to see if a location with the same name exists, otherwise create it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $asset_location string
     * @return Location
     */
    public function createOrFetchLocation($asset_location)
    {
        foreach ($this->locations as $templocation) {
            if (strcasecmp($templocation->name, $asset_location) == 0) {
                $this->log('Location ' . $asset_location . ' already exists');
                return $templocation;
            }
        }
        // No matching locations in the collection, create a new one.
        $location = new Location();

        if (!empty($asset_location)) {
            $location->name = $asset_location;
            $location->address = '';
            $location->city = '';
            $location->state = '';
            $location->country = '';
            $location->user_id = $this->option('user_id');

            if (!$this->option('testrun')) {
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
        } else {
            $this->log('No location given, so none created.');
            return $location;
        }

    }

    private $suppliers;

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
        foreach ($this->suppliers as $tempsupplier) {
            if (strcasecmp($tempsupplier->name, $item_supplier) == 0) {
                $this->log('A matching Supplier ' . $item_supplier . ' already exists');
                return $tempsupplier;
            }
        }

        $supplier = new Supplier();
        $supplier->name = $item_supplier;
        $supplier->user_id = $this->option('user_id');

        if (!$this->option('testrun')) {
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

    /**
     * Finds the user matching given data, or creates a new one if there is no match
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $row array
     * @return User Model w/ matching name
     * @internal param string $user_username Username extracted from CSV
     * @internal param string $user_email Email extracted from CSV
     * @internal param string $first_name
     * @internal param string $last_name
     */
    public function createOrFetchUser($row, $password = null)
    {
        $user_name = $this->array_smart_fetch($row, "name");
        $user_email = $this->array_smart_fetch($row, "email");
        $user_username = $this->array_smart_fetch($row, "username");

        // A number was given instead of a name
        if (is_numeric($user_name)) {
            $this->log('User '.$user_name.' is not a name - assume this user already exists');
            $user_username = '';
            $first_name = '';
            $last_name = '';

        // No name was given
        } elseif (empty($user_name)) {
            $this->log('No user data provided - skipping user creation, just adding asset');
            $first_name = '';
            $last_name = '';
            //$user_username = '';
        } else {
            $user_email_array = User::generateFormattedNameFromFullName(Setting::getSettings()->email_format, $user_name);
            $first_name = $user_email_array['first_name'];
            $last_name = $user_email_array['last_name'];

            if ($user_email=='') {
                if (Setting::getSettings()->email_domain) {
                    $user_email = str_slug($user_email_array['username']).'@'.Setting::getSettings()->email_domain;
                } else {
                    $user_email = '';
                }

            }

            if ($user_username=='') {
                if ($this->option('username_format')=='email') {
                    $user_username = $user_email;
                } else {
                    $user_name_array = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format, $user_name);
                    $user_username = $user_name_array['username'];
                }

            }

        }
        $this->log("--- User Data ---");
        $this->log('Full Name: ' . $user_name);
        $this->log('First Name: ' . $first_name);
        $this->log('Last Name: ' . $last_name);
        $this->log('Username: ' . $user_username);
        $this->log('Email: ' . $user_email);
        $this->log('--- End User Data ---');

        if ($this->option('testrun')) {
            return new User;
        }

        if (!empty($user_username)) {
            if ($user = User::MatchEmailOrUsername($user_username, $user_email)
                ->whereNotNull('username')->first()) {

                $this->log('User '.$user_username.' already exists');
            } elseif (( $first_name != '') && ($last_name != '') && ($user_username != '')) {
                $user = new \App\Models\User;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->username = $user_username;
                $user->email = $user_email;
                $user->activated = 1;
                $user->password = $password;

                if ($user->save()) {
                    $this->log('User '.$first_name.' created');
                } else {
                    $this->jsonError('User "' . $first_name . '"', $user->getErrors());
                }

            } else {
                $user = new User;
            }
        } else {
            $user = new User;
        }
        return $user;
    }

    private $assets;

    /**
     * Create the asset if it doesn't exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array $row
     * @param array $item
     */
    public function createAssetIfNotExists(array $row, array $item)
    {
        $asset = null;
        $editingAsset = false;
        foreach ($this->assets as $tempasset) {
            if (strcasecmp($tempasset->asset_tag, $item['asset_tag']) == 0) {
                $this->log('A matching Asset ' . $item['asset_tag'] . ' already exists');
                if (!$this->option('update')) {
                    $this->log("Skipping item.");
                    return;
                }
                $this->log('Updating matching asset with new values');
                $editingAsset = true;
                $asset = $tempasset;
            }
        }
        if (is_null($asset)) {
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
            isset($item["category"]) || $item["category"] = new Category();
            isset($item["manufacturer"]) || $item["manufacturer"] = new Manufacturer();
            $asset_model = $this->createOrFetchAssetModel($row, $item["category"], $item["manufacturer"]);
        }
        $item_supplier = $this->array_smart_fetch($row, "supplier");
        // If we're editing, only update if value isn't empty
        if (!($editingAsset && empty($item_supplier))) {
            $supplier = $this->createOrFetchSupplier($item_supplier);
        }

        $this->log('Serial No: '.$asset_serial);
        $this->log('Asset Tag: '.$item['asset_tag']);
        $this->log('Notes: '.$item["notes"]);
        $this->log('Warranty Months: ' . $asset_warranty_months);



        if (isset($item["status_label"])) {
            $status_id = $item["status_label"]->id;
        } else if (!$editingAsset) {
            // Assume if we are editing, we already have a status and can ignore.
            // FIXME: We're already grabbing the list of statuses, we should probably not hardcode here
            $this->log("No status field found, defaulting to id 1.");
            $status_id = $this->status_labels->first()->id;
        }

        if (!$editingAsset) {
            $asset->asset_tag = $item['asset_tag']; // This doesn't need to be guarded for empty because it's the key we use to identify the asset.
        }
        if (!empty($item['item_name'])) {
            $asset->name = $item["item_name"];
        }
        if (!empty($item["purchase_date"])) {
            $asset->purchase_date = $item["purchase_date"];
        }

        if (array_key_exists('custom_fields', $item)) {
            foreach ($item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }

        if (!empty($item["purchase_cost"])) {
            //TODO How to generalize this for not USD?
            $purchase_cost = substr($item["purchase_cost"], 0, 1) === '$' ? substr($item["purchase_cost"], 1) : $item["purchase_cost"];
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

        if ($item["user"]) {
            $asset->assigned_to = $item["user"]->id;
        }

        if (isset($item["location"])) {
            $asset->rtd_location_id = $item["location"]->id;
        }

        $asset->user_id = $this->option('user_id');
        if (isset($status_id)) {
            $asset->status_id = $status_id;
        }
        if (isset($item["company"])) {
            $asset->company_id = $item["company"]->id;
        }
        if ($item["order_number"]) {
            $asset->order_number = $item["order_number"];
        }
        if (isset($supplier)) {
            $asset->supplier_id = $supplier->id;
        }
        if ($item["notes"]) {
            $asset->notes = $item["notes"];
        }
        if (!empty($asset_image)) {
            $asset->image = $asset_image;
        }
        if (!$editingAsset) {
            $this->assets->add($asset);
        }
        if (!$this->option('testrun')) {

            if ($asset->save()) {
                $asset->logCreate('Imported using csv importer');
                $this->log('Asset ' . $item["item_name"] . ' with serial number ' . $asset_serial . ' was created');
            } else {
                $this->jsonError('Asset', $asset->getErrors());
            }

        } else {
            return;
        }
    }

    private $accessories;

    /**
     * Create an accessory if a duplicate does not exist
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $item array
     */
    public function createAccessoryIfNotExists(array $item)
    {
        $accessory = null;
        $editingAccessory = false;
        $this->log("Creating Accessory");
        foreach ($this->accessories as $tempaccessory) {
            if (strcasecmp($tempaccessory->name, $item["item_name"]) == 0) {
                $this->log('A matching Accessory ' . $item["item_name"] . ' already exists.  ');
                if (!$this->option('update')) {
                    $this->log("Skipping accessory.");
                    return;
                }
                $this->log('Updating matching accessory with new values');
                $editingAccessory = true;
                $accessory = $tempaccessory;
            }
        }
        if (is_null($accessory)) {
            $this->log("No Matching Accessory, Creating a new one");
            $accessory = new Accessory();
        }

        if (!$editingAccessory) {
            $accessory->name = $item["item_name"];
        }

        if (!empty($item["purchase_date"])) {
            $accessory->purchase_date = $item["purchase_date"];
        } else {
            $accessory->purchase_date = null;
        }
        if (!empty($item["purchase_cost"])) {
            $accessory->purchase_cost = Helper::ParseFloat($item["purchase_cost"]);
        }

        if (isset($item["location"])) {
            $accessory->location_id = $item["location"]->id;
        }
        $accessory->user_id = $this->option('user_id');
        if (isset($item["company"])) {
            $accessory->company_id = $item["company"]->id;
        }
        if (!empty($item["order_number"])) {
            $accessory->order_number = $item["order_number"];
        }
        if (isset($item["category"])) {
            $accessory->category_id = $item["category"]->id;
        }

        //TODO: Implement
//		$accessory->notes = e($item_notes);
        if (!empty($item["requestable"])) {
            $accessory->requestable = filter_var($item["requestable"], FILTER_VALIDATE_BOOLEAN);
        }

        //Must have at least zero of the item if we import it.
        if (!empty($item["quantity"])) {
            if ($item["quantity"] > -1) {
                $accessory->qty = $item["quantity"];
            } else {
                $accessory->qty = 1;
            }
        }

        if (!$this->option('testrun')) {
            if ($accessory->save()) {
                $accessory->logCreate('Imported using CSV Importer');
                $this->log('Accessory ' . $item["item_name"] . ' was created');
                // $this->comment('Accessory ' . $item["item_name"] . ' was created');

            } else {
                $this->jsonError('Accessory', $accessory->getErrors()) ;
            }
        } else {
            $this->log('TEST RUN - Accessory  ' . $item["item_name"] . ' not created');
        }
    }

    private $consumables;

    /**
     * Create a consumable if a duplicate does not exist
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $item array
     */
    public function createConsumableIfNotExists(array $item)
    {
        $consumable = null;
        $editingConsumable = false;
        $this->log("Creating Consumable");
        foreach ($this->consumables as $tempconsumable) {
            if (strcasecmp($tempconsumable->name, $item["item_name"]) == 0) {
                $this->log("A matching consumable " . $item["item_name"] . " already exists");
                if (!$this->option('update')) {
                    $this->log("Skipping consumable.");
                    return;
                }
                $this->log('Updating matching consumable with new values');
                $editingConsumable = true;
                $consumable = $tempconsumable;
            }
        }

        if (is_null($consumable)) {
            $this->log("No matching consumable, creating one");
            $consumable = new Consumable();
        }
        if (!$editingConsumable) {
            $consumable->name = $item["item_name"];
        }
        if (!empty($item["purchase_date"])) {
            $consumable->purchase_date = $item["purchase_date"];
        } else {
            $consumable->purchase_date = null;
        }

        if (!empty($item["purchase_cost"])) {
            $consumable->purchase_cost = Helper::ParseFloat($item["purchase_cost"]);
        }
        if (isset($item["location"])) {
            $consumable->location_id = $item["location"]->id;
        }
        $consumable->user_id = $this->option('user_id');
        if (isset($item["company"])) {
            $consumable->company_id = $item["company"]->id;
        }
        if (!empty($item["order_number"])) {
            $consumable->order_number = $item["order_number"];
        }
        if (isset($item["category"])) {
            $consumable->category_id = $item["category"]->id;
        }
        // TODO:Implement
        //$consumable->notes= e($item_notes);
        if (!empty($item["requestable"])) {
            $consumable->requestable = filter_var($item["requestable"], FILTER_VALIDATE_BOOLEAN);
        }

        if (!empty($item["quantity"])) {
            if ($item["quantity"] > -1) {
                $consumable->qty = $item["quantity"];
            } else {
                $consumable->qty = 1;
            }
        }

        if (!$this->option("testrun")) {
            // dd($consumable);
            if ($consumable->save()) {
                $consumable->logCreate('Imported using CSV Importer');
                $this->log("Consumable " . $item["item_name"] . ' was created');
                // $this->comment("Consumable " . $item["item_name"] . ' was created');

            } else {
                $this->jsonError('Consumable', $consumable->getErrors());
            }
        } else {
            $this->log('TEST RUN - Consumable ' . $item['item_name'] . ' not created');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('filename', InputArgument::REQUIRED, 'File for the CSV import.'),
        );
    }


    /**
     * Get the console command options.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @return array
     */
    protected function getOptions()
    {
        return array(
        array('email_format', null, InputOption::VALUE_REQUIRED, 'The format of the email addresses that should be generated. Options are firstname.lastname, firstname, filastname', null),
        array('username_format', null, InputOption::VALUE_REQUIRED, 'The format of the username that should be generated. Options are firstname.lastname, firstname, filastname, email', null),
        array('testrun', null, InputOption::VALUE_NONE, 'If set, will parse and output data without adding to database', null),
        array('logfile', null, InputOption::VALUE_REQUIRED, 'The path to log output to.  storage/logs/importer.log by default', storage_path('logs/importer.log') ),
        array('item-type', null, InputOption::VALUE_REQUIRED, 'Item Type To import.  Valid Options are Asset, Consumable, Or Accessory', 'Asset'),
        array('web-importer', null, InputOption::VALUE_NONE, 'Internal: packages output for use with the web importer'),
        array('user_id', null, InputOption::VALUE_REQUIRED, 'ID of user creating items', 1),
        array('update', null, InputOption::VALUE_NONE, 'If a matching item is found, update item information'),
        );

    }
}
