<?php
namespace App\Importer;


use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use ForceUTF8\Encoding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

abstract class Importer
{
    /**
     * @var string
     */
    private $filename;
    private $csv;
    /**
     * Should we persist to database?
     * @var bool
     */
    protected $testRun;
    /**
     * Id of User performing import
     * @var
     */
    protected $user_id;
    /**
     * Are we updating items in the import
     * @var bool
     */
    protected $updating;
    /**
     * @var callable
     */
    protected $logCallback;
    protected $tempPassword;
    /**
     * @var callable
     */
    protected $progressCallback;
    /**
     * @var null
     */
    protected $usernameFormat;
    /**
     * @var callable
     */
    protected $errorCallback;

    /**
     * ObjectImporter constructor.
     * @param string $filename
     * @param callable $logCallback
     * @param callable $progressCallback
     * @param callable $errorCallback
     * @param bool $testRun
     * @param int $user_id
     * @param bool $updating
     * @param null $usernameFormat
     */
    function __construct(string $filename,
                         $logCallback,
                         $progressCallback,
                         $errorCallback,
                         $testRun = false,
                         $user_id = -1,
                         $updating = false,
                         $usernameFormat = null)
    {
        $this->filename = $filename;
        $this->csv = Reader::createFromPath($filename);
        $this->csv->setNewLine('\r\n');
        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
        $this->testRun = $testRun;
        if($user_id == -1) {
            $user_id = Auth::id();
        }
        $this->user_id = $user_id;
        $this->updating = $updating;
        $this->logCallback = $logCallback;
        $this->tempPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $this->progressCallback = $progressCallback;
        $this->usernameFormat = $usernameFormat;
        $this->errorCallback = $errorCallback;
    }
    // Cached Values for import lookups
    protected $locations;
    protected $categories;
    protected $manufacturers;
    protected $asset_models;
    protected $companies;
    protected $status_labels;
    protected $suppliers;
    protected $assets;
    protected $accessories;
    protected $consumables;
    protected $customFields;

    public function import()
    {
//        dd($this->csv->fetchAssoc());
        $results = $this->normalizeInputArray($this->csv->fetchAssoc());
        $this->initializeLookupArrays();
        DB::transaction(function () use (&$results) {
            Model::unguard();
            $resultsCount = sizeof($results);
            foreach ($results as $row) {

                // Let's just map some of these entries to more user friendly words

                // Fetch general items here, fetch item type specific items in respective methods
                /** @var Asset, License, Accessory, or Consumable $item_type */
                $this->handle($row);
                call_user_func($this->progressCallback, $resultsCount);

                $this->log('------------- Action Summary ----------------');

            }
        });
    }

    abstract protected function handle($row);

    /**
     * @param $results
     * @return array
     */
    public function normalizeInputArray($results): array
    {
        $newArray = [];

        foreach ($results as $index => $arrayToNormalize) {
            $newArray[$index] = array_change_key_case($arrayToNormalize);
        }
        return $newArray;
    }

    /**
     * Load Cached versions of all used methods.
     */
    public function initializeLookupArrays()
    {
        $this->locations = Location::All(['name', 'id']);
        $this->categories = Category::All(['name', 'category_type', 'id']);
        $this->manufacturers = Manufacturer::All(['name', 'id']);
        $this->asset_models = AssetModel::All(['name', 'model_number', 'category_id', 'manufacturer_id', 'id']);
        $this->companies = Company::All(['name', 'id']);
        $this->status_labels = Statuslabel::All(['name', 'id']);
        $this->suppliers = Supplier::All(['name', 'id']);
        $this->customFields = CustomField::All(['name']);

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

    protected function log($string) {
        call_user_func($this->logCallback, $string);
    }

    protected function jsonError($item, $field, $errorString) {
        call_user_func($this->errorCallback, $item, $field, $errorString);
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
    protected function createOrFetchUser($row)
    {
        $user_name = $this->array_smart_fetch($row, "name");
        $user_email = $this->array_smart_fetch($row, "email");
        $user_username = $this->array_smart_fetch($row, "username");
        $first_name = '';
        $last_name = '';
        // A number was given instead of a name
        if (is_numeric($user_name)) {
            $this->log('User '.$user_name.' is not a name - assume this user already exists');
            $user_username = '';
            // No name was given
        } elseif (empty($user_name)) {
            $this->log('No user data provided - skipping user creation, just adding asset');
            //$user_username = '';
        } else {
            $user_email_array = User::generateFormattedNameFromFullName(Setting::getSettings()->email_format, $user_name);
            $first_name = $user_email_array['first_name'];
            $last_name = $user_email_array['last_name'];

            if ($user_email=='') {
                if (Setting::getSettings()->email_domain) {
                    $user_email = str_slug($user_email_array['username']).'@'.Setting::getSettings()->email_domain;
                }
            }

            if ($user_username=='') {
                if ($this->usernameFormat =='email') {
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

        $user = new User;
        if ($this->testRun) {
            return $user;
        }
        if (!empty($user_username)) {
            if ($user = User::MatchEmailOrUsername($user_username, $user_email)
                ->whereNotNull('username')->first()) {
                $this->log('User '.$user_username.' already exists');
            } elseif (( $first_name != '') && ($last_name != '') && ($user_username != '')) {
                $user = new User;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->username = $user_username;
                $user->email = $user_email;
                $user->activated = 1;
                $user->password = $this->tempPassword;

                if ($user->save()) {
                    $this->log('User '.$first_name.' created');
                } else {
                    $this->jsonError($user,'User "' . $first_name . '"', $user->getErrors());
                }
            }
        }
        return $user;
    }
}