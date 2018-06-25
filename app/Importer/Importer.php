<?php
namespace App\Importer;

use App\Models\CustomField;
use App\Models\Setting;
use App\Models\User;
use ForceUTF8\Encoding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

abstract class Importer
{
    protected $csv;
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
     * Default Map of item fields->csv names
     * @var array
     */
    private $defaultFieldMap = [
        'asset_tag' => 'asset tag',
        'category' => 'category',
        'company' => 'company',
        'item_name' => 'item name',
        'image' => 'image',
        'expiration_date' => 'expiration date',
        'location' => 'location',
        'notes' => 'notes',
        'license_email' => 'licensed to email',
        'license_name' => "licensed to name",
        'maintained' => 'maintained',
        'manufacturer' => 'manufacturer',
        'asset_model' => "model name",
        'model_number' => 'model number',
        'order_number' => 'order number',
        'purchase_cost' => 'purchase cost',
        'purchase_date' => 'purchase date',
        'purchase_order' => 'purchase order',
        'qty' => 'quantity',
        'reassignable' => 'reassignable',
        'requestable' => 'requestable',
        'seats' => 'seats',
        'serial_number' => 'serial number',
        'status' => 'status',
        'supplier' => 'supplier',
        'termination_date' => 'termination date',
        'warranty_months' => 'warranty',
        'full_name' => 'full name',
        'email' => 'email',
        'username' => 'username'
    ];
    /**
     * Map of item fields->csv names
     * @var array
     */
    protected $fieldMap = [];
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
     * @param string $file
     */
    public function __construct($file)
    {
        $this->fieldMap = $this->defaultFieldMap;
        // By default the importer passes a url to the file.
        // However, for testing we also support passing a string directly
        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
        if (is_file($file)) {
            $this->csv = Reader::createFromPath($file);
        } else {
            $this->csv = Reader::createFromString($file);
        }
        $this->tempPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
    }
    // Cached Values for import lookups
    protected $customFields;

    public function import()
    {
        $headerRow = $this->csv->fetchOne();
        $results = $this->normalizeInputArray($this->csv->fetchAssoc());

        // Stolen From https://adamwathan.me/2016/07/14/customizing-keys-when-mapping-collections/
        // This 'inverts' the fields such that we have a collection of fields indexed by name.
        $cFs = CustomField::All();
        $this->customFields = $cFs->reduce(function ($nameLookup, $field) {
            $nameLookup[$field['name']] = $field;
            return $nameLookup;
        });
        // Remove any custom fields that do not exist in the header row.  This prevents nulling out values that shouldn't exist.
        // In detail, we compare the lower case name of custom fields (indexed by name) to the keys in the header row.  This
        // results in an array with only custom fields that are in the file.
        if ($this->customFields) {
            $this->customFields = array_intersect_key(
                array_change_key_case($this->customFields),
                array_change_key_case(array_flip($headerRow))
            );
        }



        DB::transaction(function () use (&$results) {
            Model::unguard();
            $resultsCount = sizeof($results);
            foreach ($results as $row) {
                $this->handle($row);
                if ($this->progressCallback) {
                    call_user_func($this->progressCallback, $resultsCount);
                }

                $this->log('------------- Action Summary ----------------');
            }
        });
    }

    abstract protected function handle($row);

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
    public function findCsvMatch(array $array, $key, $default = null)
    {

        $val = $default;

        $key = $this->lookupCustomKey($key);

        $this->log("Custom Key: ${key}");
        if (array_key_exists($key, $array)) {
            $val = Encoding::toUTF8(trim($array[ $key ]));
        }
        // $this->log("${key}: ${val}");
        return $val;
    }

    /**
     * Looks up A custom key in the custom field map
     *
     * @author Daniel Melzter
     * @since 4.0
     * @param $key string
     * @return string|null
     */
    public function lookupCustomKey($key)
    {
        // dd($this->fieldMap);
        if (array_key_exists($key, $this->fieldMap)) {
            $this->log("Found a match in our custom map: {$key} is " . $this->fieldMap[$key]);
            return $this->fieldMap[$key];
        }
        // Otherwise no custom key, return original.
        return $key;
    }

    /**
     * @param $results
     * @return array
     */
    public function normalizeInputArray($results)
    {
        $newArray = [];
        foreach ($results as $index => $arrayToNormalize) {
            $newArray[$index] = array_change_key_case($arrayToNormalize);
        }
        return $newArray;
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
        return array_key_exists($index_name, $array) ? trim($array[$index_name]) : false;
    }

    protected function log($string)
    {
        if ($this->logCallback) {
            call_user_func($this->logCallback, $string);
        }
    }

    protected function logError($item, $field)
    {
        if ($this->errorCallback) {
            call_user_func($this->errorCallback, $item, $field, $item->getErrors());
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
    protected function createOrFetchUser($row)
    {
        $user_name = $this->findCsvMatch($row, "full_name");
        $user_email = $this->findCsvMatch($row, "email");
        $user_username = $this->findCsvMatch($row, "username");
        $first_name = '';
        $last_name = '';
        if(empty($user_name) && empty($user_email) && empty($user_username)) {
            $this->log('No user data provided - skipping user creation, just adding asset');
            //$user_username = '';
            return false;
        }
        // A username was given.
        if( !empty($user_username)) {
            $user = User::where('username', $user_username)->first();
            if($user) {
                return $user;
            }
        }
        // A number was given instead of a name
        if (is_numeric($user_name)) {
            $this->log('User '.$user_name.' is not a name - assume this user already exists');
            $user = User::find($user_name);
            if($user) {
                return $user;
            }
            $this->log('User with id'.$user_name.' does not exist.  Continuing through our processes');
        }
        // Generate data based on user name.
        $user_email_array = User::generateFormattedNameFromFullName(Setting::getSettings()->email_format, $user_name);
        $first_name = $user_email_array['first_name'];
        $last_name = $user_email_array['last_name'];

        if (empty($user_email)) {
            if (Setting::getSettings()->email_domain) {
                $user_email = str_slug($user_email_array['username']).'@'.Setting::getSettings()->email_domain;
            }
        }

        if (empty($user_username)) {
            if ($this->usernameFormat =='email') {
                $user_username = $user_email;
            } else {
                $user_name_array = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format, $user_name);
                $user_username = $user_name_array['username'];
            }
        }
        $user = new User;

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
                    $this->logError($user, 'User "' . $first_name . '"');
                }
            }
        }
        return $user;
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
     * Defines mappings of csv fields
     *
     * @param bool $updating the updating
     *
     * @return self
     */
    public function setFieldMappings($fields)
    {
        // Some initial sanitization.
        $fields = array_map('strtolower', $fields);
        $this->fieldMap = array_merge($this->defaultFieldMap, $fields);

        // $this->log($this->fieldMap);
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
