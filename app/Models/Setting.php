<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use Schema;

class Setting extends Model
{
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    protected $rules = [
    "brand"     => 'required|min:1|numeric',
    "qr_text"       => 'min:1|max:31',
    "custom_css"   => 'string',
    "slack_endpoint"   => 'url',
    "default_currency"   => 'required',
    "slack_channel"   => 'regex:/(?<!\w)#\w+/',
    "slack_botname"   => 'string',
    "ldap_server"   => 'sometimes|required_if:ldap_enabled,1|url',
    "ldap_uname"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_pword"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_basedn"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_filter"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_username_field"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_lname_field"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_auth_filter_query"     => 'sometimes|required_if:ldap_enabled,1',
    "ldap_version"     => 'sometimes|required_if:ldap_enabled,1',
    ];

    protected $fillable = ['site_name'];

    public static function getSettings()
    {
        static $static_cache = null;

        if (!$static_cache) {
            $static_cache = Setting::first();
        }
        return $static_cache;
    }

    public static function setupCompleted() {
        
            $users_table_exists = Schema::hasTable('users');
            $settings_table_exists = Schema::hasTable('settings');


            if ($users_table_exists && $settings_table_exists) {
                $usercount = User::withTrashed()->count();

                if ($usercount > 0) {
                    return true;
                }
                return false;
            } else {
                return false;
            }
        return false;



    }

    public function lar_ver()
    {
        $app = \App::getFacadeApplication();
        return $app::VERSION;
    }

    public static function getDefaultEula()
    {

        $Parsedown = new \Parsedown();
        if (Setting::getSettings()->default_eula_text) {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        } else {
            return null;
        }

    }

    public function show_custom_css()
    {
        $custom_css = Setting::getSettings()->custom_css;
        $custom_css = e($custom_css);
        // Needed for modifying the bootstrap nav :(
        $custom_css = str_ireplace('script', 'SCRIPTS-NOT-ALLOWED-HERE', $custom_css);
        $custom_css = str_replace('&gt;', '>', $custom_css);
        return $custom_css;
    }

    /**
    * Converts bytes into human readable file size.
    *
    * @param string $bytes
    * @return string human readable file size (2,87 Мб)
    * @author Mogilev Arseny
    */
    public static function fileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
            $arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

            foreach ($arBytes as $arItem) {
                if ($bytes >= $arItem["VALUE"]) {
                    $result = $bytes / $arItem["VALUE"];
                    $result = round($result, 2) .$arItem["UNIT"];
                    break;
                }
            }
            return $result;
    }
}
