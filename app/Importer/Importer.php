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
     */
    public function __construct(string $filename)
    {

        $this->filename = $filename;
        $this->csv = Reader::createFromPath($filename);
        $this->csv->setNewLine('\r\n');
        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
        $this->tempPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
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
        $results = $this->normalizeInputArray($this->csv->fetchAssoc());
        $this->initializeLookupArrays();
        DB::transaction(function () use (&$results) {
            Model::unguard();
            $resultsCount = sizeof($results);
            foreach ($results as $row) {
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
        $val = $default;
        if (array_key_exists(trim($key), $array)) {
            $val = e(Encoding::toUTF8(trim($array[ $key ])));
        }
        $key = title_case($key);
        $this->log("${key}: ${val}");
        return $val;
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

    protected function log($string)
    {
        call_user_func($this->logCallback, $string);
    }

    protected function jsonError($item, $field)
    {
        call_user_func($this->errorCallback, $item, $field, $item->getErrors());
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
                    $this->jsonError($user, 'User "' . $first_name . '"');
                }
            }
        }
        return $user;
    }



    /**
     * Sets the value of filename.
     *
     * @param string $filename the filename
     *
     * @return self
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Sets the Should we persist to database?.
     *
     * @param bool $testRun the test run
     *
     * @return self
     */
    public function setTestRun($testRun)
    {
        $this->testRun = $testRun;

        return $this;
    }

    /**
     * Sets the Id of User performing import.
     *
     * @param mixed $user_id the user id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Sets the Are we updating items in the import.
     *
     * @param bool $updating the updating
     *
     * @return self
     */
    public function setUpdating($updating)
    {
        $this->updating = $updating;

        return $this;
    }

    /**
     * Sets the callbacks for the import
     *
     * @param callable $logCallback Function to call when we have data to log
     * @param callable $progressCallback Function to call to display progress
     * @param callable $errorCallback Function to call when we have errors
     *
     * @return self
     */
    public function setCallbacks(callable $logCallback, callable $progressCallback, callable $errorCallback)
    {
        $this->logCallback = $logCallback;
        $this->progressCallback = $progressCallback;
        $this->errorCallback = $errorCallback;

        return $this;
    }
    /**
     * Sets the value of usernameFormat.
     *
     * @param string $usernameFormat the username format
     *
     * @return self
     */
    public function setUsernameFormat($usernameFormat)
    {
        $this->usernameFormat = $usernameFormat;

        return $this;
    }
}
