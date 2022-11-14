<?php

namespace App\Helpers;
use App\Models\Accessory;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Depreciation;
use App\Models\Setting;
use App\Models\Statuslabel;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Image;

class Helper
{
    /**
     * Simple helper to invoke the markdown parser
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return string
     */
    public static function parseEscapedMarkedown($str = null)
    {
        $Parsedown = new \Parsedown();
        $Parsedown->setSafeMode(true);

        if ($str) {
            return $Parsedown->text($str);
        }
    }

    /**
     * The importer has formatted number strings since v3,
     * so the value might be a string, or an integer.
     * If it's a number, format it as a string.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return string
     */
    public static function formatCurrencyOutput($cost)
    {
        if (is_numeric($cost)) {

            if (Setting::getSettings()->digit_separator=='1.234,56') {
                return number_format($cost, 2, ',', '.');
            }
            return number_format($cost, 2, '.', ',');
        }
        // It's already been parsed.
        return $cost;
    }


    /**
     * Static colors for pie charts.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return array
     */
    public static function defaultChartColors($index = 0)
    {
        $colors = [
            '#008941',
            '#FF4A46',
            '#006FA6',
            '#A30059',
            '#1CE6FF',
            '#FFDBE5',
            '#7A4900',
            '#0000A6',
            '#63FFAC',
            '#B79762',
            '#004D43',
            '#8FB0FF',
            '#997D87',
            '#5A0007',
            '#809693',
            '#FEFFE6',
            '#1B4400',
            '#4FC601',
            '#3B5DFF',
            '#4A3B53',
            '#FF2F80',
            '#61615A',
            '#BA0900',
            '#6B7900',
            '#00C2A0',
            '#FFAA92',
            '#FF90C9',
            '#B903AA',
            '#D16100',
            '#DDEFFF',
            '#000035',
            '#7B4F4B',
            '#A1C299',
            '#300018',
            '#0AA6D8',
            '#013349',
            '#00846F',
            '#372101',
            '#FFB500',
            '#C2FFED',
            '#A079BF',
            '#CC0744',
            '#C0B9B2',
            '#C2FF99',
            '#001E09',
            '#00489C',
            '#6F0062',
            '#0CBD66',
            '#EEC3FF',
            '#456D75',
            '#B77B68',
            '#7A87A1',
            '#788D66',
            '#885578',
            '#FAD09F',
            '#FF8A9A',
            '#D157A0',
            '#BEC459',
            '#456648',
            '#0086ED',
            '#886F4C',
            '#34362D',
            '#B4A8BD',
            '#00A6AA',
            '#452C2C',
            '#636375',
            '#A3C8C9',
            '#FF913F',
            '#938A81',
            '#575329',
            '#00FECF',
            '#B05B6F',
            '#8CD0FF',
            '#3B9700',
            '#04F757',
            '#C8A1A1',
            '#1E6E00',
            '#7900D7',
            '#A77500',
            '#6367A9',
            '#A05837',
            '#6B002C',
            '#772600',
            '#D790FF',
            '#9B9700',
            '#549E79',
            '#FFF69F',
            '#201625',
            '#72418F',
            '#BC23FF',
            '#99ADC0',
            '#3A2465',
            '#922329',
            '#5B4534',
            '#FDE8DC',
            '#404E55',
            '#0089A3',
            '#CB7E98',
            '#A4E804',
            '#324E72',
            '#6A3A4C',
            '#83AB58',
            '#001C1E',
            '#D1F7CE',
            '#004B28',
            '#C8D0F6',
            '#A3A489',
            '#806C66',
            '#222800',
            '#BF5650',
            '#E83000',
            '#66796D',
            '#DA007C',
            '#FF1A59',
            '#8ADBB4',
            '#1E0200',
            '#5B4E51',
            '#C895C5',
            '#320033',
            '#FF6832',
            '#66E1D3',
            '#CFCDAC',
            '#D0AC94',
            '#7ED379',
            '#012C58',
            '#7A7BFF',
            '#D68E01',
            '#353339',
            '#78AFA1',
            '#FEB2C6',
            '#75797C',
            '#837393',
            '#943A4D',
            '#B5F4FF',
            '#D2DCD5',
            '#9556BD',
            '#6A714A',
            '#001325',
            '#02525F',
            '#0AA3F7',
            '#E98176',
            '#DBD5DD',
            '#5EBCD1',
            '#3D4F44',
            '#7E6405',
            '#02684E',
            '#962B75',
            '#8D8546',
            '#9695C5',
            '#E773CE',
            '#D86A78',
            '#3E89BE',
            '#CA834E',
            '#518A87',
            '#5B113C',
            '#55813B',
            '#E704C4',
            '#00005F',
            '#A97399',
            '#4B8160',
            '#59738A',
            '#FF5DA7',
            '#F7C9BF',
            '#643127',
            '#513A01',
            '#6B94AA',
            '#51A058',
            '#A45B02',
            '#1D1702',
            '#E20027',
            '#E7AB63',
            '#4C6001',
            '#9C6966',
            '#64547B',
            '#97979E',
            '#006A66',
            '#391406',
            '#F4D749',
            '#0045D2',
            '#006C31',
            '#DDB6D0',
            '#7C6571',
            '#9FB2A4',
            '#00D891',
            '#15A08A',
            '#BC65E9',
            '#FFFFFE',
            '#C6DC99',
            '#203B3C',
            '#671190',
            '#6B3A64',
            '#F5E1FF',
            '#FFA0F2',
            '#CCAA35',
            '#374527',
            '#8BB400',
            '#797868',
            '#C6005A',
            '#3B000A',
            '#C86240',
            '#29607C',
            '#402334',
            '#7D5A44',
            '#CCB87C',
            '#B88183',
            '#AA5199',
            '#B5D6C3',
            '#A38469',
            '#9F94F0',
            '#A74571',
            '#B894A6',
            '#71BB8C',
            '#00B433',
            '#789EC9',
            '#6D80BA',
            '#953F00',
            '#5EFF03',
            '#E4FFFC',
            '#1BE177',
            '#BCB1E5',
            '#76912F',
            '#003109',
            '#0060CD',
            '#D20096',
            '#895563',
            '#29201D',
            '#5B3213',
            '#A76F42',
            '#89412E',
            '#1A3A2A',
            '#494B5A',
            '#A88C85',
            '#F4ABAA',
            '#A3F3AB',
            '#00C6C8',
            '#EA8B66',
            '#958A9F',
            '#BDC9D2',
            '#9FA064',
            '#BE4700',
            '#658188',
            '#83A485',
            '#453C23',
            '#47675D',
            '#3A3F00',
            '#061203',
            '#DFFB71',
            '#868E7E',
            '#98D058',
            '#6C8F7D',
            '#D7BFC2',
            '#3C3E6E',
            '#D83D66',
            '#2F5D9B',
            '#6C5E46',
            '#D25B88',
            '#5B656C',
            '#00B57F',
            '#545C46',
            '#866097',
            '#365D25',
            '#252F99',
            '#00CCFF',
            '#674E60',
            '#FC009C',
            '#92896B',
        ];



        return $colors[$index];
    }

    /**
     * Increases or decreases the brightness of a color by a percentage of the current brightness.
     *
     * @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
     * @param   float   $adjustPercent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
     *
     * @return  string
     */
    public static function adjustBrightness($hexCode, $adjustPercent)
    {
        $hexCode = ltrim($hexCode, '#');

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0].$hexCode[0].$hexCode[1].$hexCode[1].$hexCode[2].$hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as &$color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#'.implode($hexCode);
    }

    /**
     * Static background (highlight) colors for pie charts
     * This is inelegant, and could be refactored later.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.2]
     * @return array
     */
    public static function chartBackgroundColors()
    {
        $colors = [
            '#f56954',
            '#00a65a',
            '#f39c12',
            '#00c0ef',
            '#3c8dbc',
            '#d2d6de',
            '#3c8dbc',
            '#3c8dbc',
            '#3c8dbc',

        ];

        return $colors;
    }


    /**
     * Format currency using comma for thousands until local info is property used.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.7]
     * @return string
     */
    public static function ParseFloat($floatString)
    {
        /*******
         * 
         * WARNING: This does conversions based on *locale* - a Unix-ey-like thing.
         * 
         * Everything else in the system tends to convert based on the Snipe-IT settings
         * 
         * So it's very likely this is *not* what you want - instead look for the new
         * 
         * ParseCurrency($currencyString)
         * 
         * Which should be directly below here
         * 
         */
        $LocaleInfo = localeconv();
        $floatString = str_replace(',', '', $floatString);
        $floatString = str_replace($LocaleInfo['decimal_point'], '.', $floatString);
        // Strip Currency symbol
        // If no currency symbol is set, default to $ because Murica
        $currencySymbol = $LocaleInfo['currency_symbol'];
        if (empty($currencySymbol)) {
            $currencySymbol = '$';
        }

        $floatString = str_replace($currencySymbol, '', $floatString);

        return floatval($floatString);
    }
    
    /**
     * Format currency using comma or period for thousands, and period or comma for decimal, based on settings.
     * 
     * @author [B. Wetherington] [<bwetherington@grokability.com>]
     * @since [v5.2]
     * @return Float
     */
    public static function ParseCurrency($currencyString) {
        $without_currency = str_replace(Setting::getSettings()->default_currency, '', $currencyString); //generally shouldn't come up, since we don't do this in fields, but just in case it does...
        if(Setting::getSettings()->digit_separator=='1.234,56') {
            //EU format
            $without_thousands = str_replace('.', '', $without_currency);
            $corrected_decimal = str_replace(',', '.', $without_thousands);
        } else {
            $without_thousands = str_replace(',', '', $without_currency);
            $corrected_decimal = $without_thousands;  // decimal is already OK
        }
        return floatval($corrected_decimal);
    }

    /**
     * Get the list of status labels in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function statusLabelList()
    {
        $statuslabel_list = ['' => trans('general.select_statuslabel')] + Statuslabel::orderBy('default_label', 'desc')->orderBy('name', 'asc')->orderBy('deployable', 'desc')
                ->pluck('name', 'id')->toArray();

        return $statuslabel_list;
    }

    /**
     * Get the list of deployable status labels in an array to make a dropdown menu
     *
     * @todo This should probably be a selectlist, same as the other endpoints
     * and we should probably add to the API controllers to make sure that
     * the status_id submitted is actually really deployable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.1.0]
     * @return array
     */
    public static function deployableStatusLabelList()
    {
        $statuslabel_list = Statuslabel::where('deployable', '=', '1')->orderBy('default_label', 'desc')
                ->orderBy('name', 'asc')
                ->orderBy('deployable', 'desc')
                ->pluck('name', 'id')->toArray();

        return $statuslabel_list;
    }

    /**
     * Get the list of status label types in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function statusTypeList()
    {
        $statuslabel_types =
              ['' => trans('admin/hardware/form.select_statustype')]
            + ['deployable' => trans('admin/hardware/general.deployable')]
            + ['pending' => trans('admin/hardware/general.pending')]
            + ['undeployable' => trans('admin/hardware/general.undeployable')]
            + ['archived' => trans('admin/hardware/general.archived')];

        return $statuslabel_types;
    }

    /**
     * Get the list of depreciations in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function depreciationList()
    {
        $depreciation_list = ['' => 'Do Not Depreciate'] + Depreciation::orderBy('name', 'asc')
                ->pluck('name', 'id')->toArray();

        return $depreciation_list;
    }

    /**
     * Get the list of category types in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function categoryTypeList()
    {
        $category_types = [
            '' => '',
            'accessory' => 'Accessory',
            'asset' => 'Asset',
            'consumable' => 'Consumable',
            'component' => 'Component',
            'license' => 'License',
        ];

        return $category_types;
    }

    /**
     * Get the list of custom fields in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function customFieldsetList()
    {
        $customfields = ['' => trans('admin/models/general.no_custom_field')] + CustomFieldset::pluck('name', 'id')->toArray();

        return  $customfields;
    }

    /**
     * Get the list of custom field formats in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.4]
     * @return array
     */
    public static function predefined_formats()
    {
        $keys = array_keys(CustomField::PREDEFINED_FORMATS);
        $stuff = array_combine($keys, $keys);

        return $stuff;
    }

    /**
     * Get the list of barcode dimensions
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return array
     */
    public static function barcodeDimensions($barcode_type = 'QRCODE')
    {
        if ($barcode_type == 'C128') {
            $size['height'] = '-1';
            $size['width'] = '-10';
        } elseif ($barcode_type == 'PDF417') {
            $size['height'] = '-3';
            $size['width'] = '-10';
        } else {
            $size['height'] = '-3';
            $size['width'] = '-3';
        }

        return $size;
    }

    /**
     * Generates a random string
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return array
     */
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * This nasty little method gets the low inventory info for the
     * alert dropdown
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return array
     */
    public static function checkLowInventory()
    {
        $consumables = Consumable::withCount('consumableAssignments as consumable_assignments_count')->whereNotNull('min_amt')->get();
        $accessories = Accessory::withCount('users as users_count')->whereNotNull('min_amt')->get();
        $components = Component::whereNotNull('min_amt')->get();

        $avail_consumables = 0;
        $items_array = [];
        $all_count = 0;

        foreach ($consumables as $consumable) {
            $avail = $consumable->numRemaining();
            if ($avail < ($consumable->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($consumable->qty > 0) {
                    $percent = number_format((($avail / $consumable->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $consumable->id;
                $items_array[$all_count]['name'] = $consumable->name;
                $items_array[$all_count]['type'] = 'consumables';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $consumable->min_amt;
                $all_count++;
            }
        }

        foreach ($accessories as $accessory) {
            $avail = $accessory->qty - $accessory->users_count;
            if ($avail < ($accessory->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($accessory->qty > 0) {
                    $percent = number_format((($avail / $accessory->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $accessory->id;
                $items_array[$all_count]['name'] = $accessory->name;
                $items_array[$all_count]['type'] = 'accessories';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $accessory->min_amt;
                $all_count++;
            }
        }

        foreach ($components as $component) {
            $avail = $component->numRemaining();
            if ($avail < ($component->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($component->qty > 0) {
                    $percent = number_format((($avail / $component->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $component->id;
                $items_array[$all_count]['name'] = $component->name;
                $items_array[$all_count]['type'] = 'components';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $component->min_amt;
                $all_count++;
            }
        }

        return $items_array;
    }

    /**
     * Check if the file is an image, so we can show a preview
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param File $file
     * @return string | Boolean
     */
    public static function checkUploadIsImage($file)
    {
        $finfo = @finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $filetype = @finfo_file($finfo, $file);
        finfo_close($finfo);

        if (($filetype == 'image/jpeg') || ($filetype == 'image/jpg') || ($filetype == 'image/png') || ($filetype == 'image/bmp') || ($filetype == 'image/gif')) {
            return $filetype;
        }

        return false;
    }

    /**
     * Walks through the permissions in the permissions config file and determines if
     * permissions are granted based on a $selected_arr array.
     *
     * The $permissions array is a multidimensional array broke down by section.
     * (Licenses, Assets, etc)
     *
     * The $selected_arr should be a flattened array that contains just the
     * corresponding permission name and a true or false boolean to determine
     * if that group/user has been granted that permission.
     *
     * @author [A. Gianotto] [<snipe@snipe.net]
     * @param array $permissions
     * @param array $selected_arr
     * @since [v1.0]
     * @return array
     */
    public static function selectedPermissionsArray($permissions, $selected_arr = [])
    {
        $permissions_arr = [];

        foreach ($permissions as $permission) {
            for ($x = 0; $x < count($permission); $x++) {
                $permission_name = $permission[$x]['permission'];

                if ($permission[$x]['display'] === true) {
                    if ($selected_arr) {
                        if (array_key_exists($permission_name, $selected_arr)) {
                            $permissions_arr[$permission_name] = $selected_arr[$permission_name];
                        } else {
                            $permissions_arr[$permission_name] = '0';
                        }
                    } else {
                        $permissions_arr[$permission_name] = '0';
                    }
                }
            }
        }

        return $permissions_arr;
    }

    /**
     * Introspects into the model validation to see if the field passed is required.
     * This is used by the blades to add a required class onto the HTML element.
     * This isn't critical, but is helpful to keep form fields in sync with the actual
     * model level validation.
     *
     * This does not currently handle form request validation requiredness :(
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return bool
     */
    public static function checkIfRequired($class, $field)
    {
        $rules = $class::rules();
        foreach ($rules as $rule_name => $rule) {
            if ($rule_name == $field) {
                if (strpos($rule, 'required') === false) {
                    return false;
                } else {
                    return true;
                }
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
    public static function array_smart_fetch(array $array, $key, $default = '')
    {
        array_change_key_case($array, CASE_LOWER);

        return array_key_exists(strtolower($key), array_change_key_case($array)) ? e(trim($array[$key])) : $default;
    }

    /**
     * Gracefully handle decrypting encrypted fields (custom fields, etc).
     *
     * @todo allow this to handle more than just strings (arrays, etc)
     *
     * @author A. Gianotto
     * @since 3.6
     * @param CustomField $field
     * @param string $string
     * @return string
     */
    public static function gracefulDecrypt(CustomField $field, $string)
    {
        if ($field->isFieldDecryptable($string)) {
            try {
                Crypt::decrypt($string);

                return Crypt::decrypt($string);
            } catch (DecryptException $e) {
                return 'Error Decrypting: '.$e->getMessage();
            }
            }

        return $string;
    }
    public static function formatStandardApiResponse($status, $payload = null, $messages = null)

    {
        $array['status'] = $status;
        $array['messages'] = $messages;
        if (($messages) && (is_array($messages)) && (count($messages) > 0)) {
            $array['messages'] = $messages;
        }
        ($payload) ? $array['payload'] = $payload : $array['payload'] = null;

        return $array;
    }

    /*
    Possible solution for unicode fieldnames
    */
    public static function make_slug($string)
    {
        return preg_replace('/\s+/u', '_', trim($string));
    }

    /**
     * Return an array (or null) of the the raw and formatted date object for easy use in
     * the API and the bootstrap table listings.
     *
     * @param $date
     * @param $type
     * @param $array
     * @return array|string|null
     */

    public static function getFormattedDateObject($date, $type = 'datetime', $array = true)
    {
        if ($date == '') {
            return null;
        }

        $settings = Setting::getSettings();

        /**
         * Wrap this in a try/catch so that if Carbon crashes, for example if the $date value
         * isn't actually valid, we don't crash out completely.
         *
         * While this *shouldn't* typically happen since we validate dates before entering them
         * into the database (and we use date/datetime fields for native fields in the system),
         * it is a possible scenario that a custom field could be created as an "ANY" field, data gets
         * added, and then the custom field format gets edited later. If someone put bad data in the
         * database before then - or if they manually edited the field's value - it will crash.
         *
         */


        try {
            $tmp_date = new \Carbon($date);

            if ($type == 'datetime') {
                $dt['datetime'] = $tmp_date->format('Y-m-d H:i:s');
                $dt['formatted'] = $tmp_date->format($settings->date_display_format.' '.$settings->time_display_format);
            } else {
                $dt['date'] = $tmp_date->format('Y-m-d');
                $dt['formatted'] = $tmp_date->format($settings->date_display_format);
            }

            if ($array == 'true') {
                return $dt;
            }

            return $dt['formatted'];

        } catch (\Exception $e) {
            \Log::warning($e);
            return $date.' (Invalid '.$type.' value.)';
        }

    }

    // Nicked from Drupal :)
    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    public static function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {

            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    public static function file_upload_max_size_readable()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = ini_get('post_max_size');
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));

            if ($upload_max > 0 && $upload_max < $post_max_size) {
                $max_size = ini_get('upload_max_filesize');
            }
        }

        return $max_size;
    }

    public static function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public static function filetype_icon($filename)
    {
        $extension = substr(strrchr($filename, '.'), 1);

        $allowedExtensionMap = [
            // Images
            'jpg'   => 'far fa-image',
            'jpeg'   => 'far fa-image',
            'gif'   => 'far fa-image',
            'png'   => 'far fa-image',
            // word
            'doc'   => 'far fa-file-word',
            'docx'   => 'far fa-file-word',
            // Excel
            'xls'   => 'far fa-file-excel',
            'xlsx'   => 'far fa-file-excel',
            // archive
            'zip'   => 'fas fa-file-archive',
            'rar'   => 'fas fa-file-archive',
            //Text
            'txt'   => 'far fa-file-alt',
            'rtf'   => 'far fa-file-alt',
            'xml'   => 'far fa-file-alt',
            // Misc
            'pdf'   => 'far fa-file-pdf',
            'lic'   => 'far fa-save',
        ];

        if ($extension && array_key_exists($extension, $allowedExtensionMap)) {
            return $allowedExtensionMap[$extension];
        }

        return 'far fa-file';
    }

    public static function show_file_inline($filename)
    {
        $extension = substr(strrchr($filename, '.'), 1);

        if ($extension) {
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                    return true;
                    break;
                default:
                    return false;
            }
        }

        return false;
    }

    /**
     * Generate a random encrypted password.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public static function generateEncyrptedPassword(): string
    {
        return bcrypt(self::generateUnencryptedPassword());
    }

    /**
     * Get a random unencrypted password.
     *
     * @author Steffen Buehl <sb@sbuehl.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public static function generateUnencryptedPassword(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = '';
        for ($i = 0; $i < 20; $i++) {
            $password .= substr($chars, random_int(0, strlen($chars) - 1), 1);
        }

        return $password;
    }

    /**
     * Process base64 encoded image data and save it on supplied path
     *
     * @param string $image_data base64 encoded image data with mime type
     * @param string $save_path path to a folder where the image should be saved
     * @return string path to uploaded image or false if something went wrong
     */
    public static function processUploadedImage(String $image_data, String $save_path)
    {
        if ($image_data == null || $save_path == null) {
            return false;
        }

        // After modification, the image is prefixed by mime info like the following:
        // data:image/jpeg;base64,; This causes the image library to be unhappy, so we need to remove it.
        $header = explode(';', $image_data, 2)[0];
        // Grab the image type from the header while we're at it.
        $extension = substr($header, strpos($header, '/') + 1);
        // Start reading the image after the first comma, postceding the base64.
        $image = substr($image_data, strpos($image_data, ',') + 1);

        $file_name = str_random(25).'.'.$extension;

        $directory = public_path($save_path);
        // Check if the uploads directory exists.  If not, try to create it.
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = public_path($save_path.$file_name);

        try {
            Image::make($image)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
        } catch (\Exception $e) {
            return false;
        }

        return $file_name;
    }

    public static function formatFilesizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    public static function SettingUrls(){
        $settings=['#','fields.index', 'statuslabels.index', 'models.index', 'categories.index', 'manufacturers.index', 'suppliers.index', 'departments.index', 'locations.index', 'companies.index', 'depreciations.index'];

        return $settings;
        }

}
