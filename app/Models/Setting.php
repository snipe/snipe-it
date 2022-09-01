<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Helper;
use Watson\Validating\ValidatingTrait;


/**
 * Settings model.
 */
class Setting extends Model
{
    use HasFactory;
    use Notifiable, ValidatingTrait;

    /**
     * The app settings cache key name.
     *
     * @var string
     */
    const APP_SETTINGS_KEY = 'snipeit_app_settings';

    /**
     * The setup check cache key name.
     *
     * @var string
     */
    const SETUP_CHECK_KEY = 'snipeit_setup_check';

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
     */
    protected $injectUniqueIdentifier = true;

    /**
     * Model rules.
     *
     * @var array
     */
    protected $rules = [
          'brand'                               => 'required|min:1|numeric',
          'qr_text'                             => 'max:31|nullable',
          'alert_email'                         => 'email_array|nullable',
          'admin_cc_email'                      => 'email|nullable',
          'default_currency'                    => 'required',
          'locale'                              => 'required',
          'labels_per_page'                     => 'numeric',
          'labels_width'                        => 'numeric',
          'labels_height'                       => 'numeric',
          'labels_pmargin_left'                 => 'numeric|nullable',
          'labels_pmargin_right'                => 'numeric|nullable',
          'labels_pmargin_top'                  => 'numeric|nullable',
          'labels_pmargin_bottom'               => 'numeric|nullable',
          'labels_display_bgutter'              => 'numeric|nullable',
          'labels_display_sgutter'              => 'numeric|nullable',
          'labels_fontsize'                     => 'numeric|min:5',
          'labels_pagewidth'                    => 'numeric|nullable',
          'labels_pageheight'                   => 'numeric|nullable',
          'login_remote_user_enabled'           => 'numeric|nullable',
          'login_common_disabled'               => 'numeric|nullable',
          'login_remote_user_custom_logout_url' => 'string|nullable',
          'login_remote_user_header_name'       => 'string|nullable',
          'thumbnail_max_h'                     => 'numeric|max:500|min:25',
          'pwd_secure_min'                      => 'numeric|required|min:8',
          'audit_warning_days'                  => 'numeric|nullable',
          'audit_interval'                      => 'numeric|nullable',
          'custom_forgot_pass_url'              => 'url|nullable',
          'privacy_policy_link'                 => 'nullable|url',
    ];

    protected $fillable = [
        'site_name',
        'email_domain',
        'email_format',
        'username_format',
    ];

    /**
     * Get the app settings.
     *  Cache is expired on Setting model saved in EventServiceProvider.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return \App\Models\Setting|null
     */
    public static function getSettings(): ?self
    {
        return Cache::rememberForever(self::APP_SETTINGS_KEY, function () {
            // Need for setup as no tables exist
            try {
                return self::first();
            } catch (\Throwable $th) {
                return null;
            }
        });
    }

    /**
     * Check to see if setup process is complete.
     *  Cache is expired on Setting model saved in EventServiceProvider.
     *
     * @return bool
     */
    public static function setupCompleted(): bool
    {
        try {
            $usercount = User::withTrashed()->count();
            $settingsCount = self::count();

            return $usercount > 0 && $settingsCount > 0;
        } catch (\Throwable $th) {
            \Log::debug('User table and settings table DO NOT exist or DO NOT have records');
            // Catch the error if the tables dont exit
            return false;
        }
    }

    /**
     * Get the current Laravel version.
     *
     * @return string
     */
    public function lar_ver(): string
    {
        $app = App::getFacadeApplication();
        return $app::VERSION;
    }

    /**
     * Get the default EULA text.
     *
     * @return string|null
     */
    public static function getDefaultEula(): ?string
    {
        if (self::getSettings()->default_eula_text) {
            return Helper::parseEscapedMarkedown(self::getSettings()->default_eula_text);
        }

        return null;
    }

    /**
     * Check wether to show in model dropdowns.
     *
     * @param string $element
     *
     * @return bool
     */
    public function modellistCheckedValue($element): bool
    {
        $settings = self::getSettings();
        // If the value is blank for some reason
        if ($settings->modellist_displays == '') {
            return false;
        }

        $values = explode(',', $settings->modellist_displays);

        foreach ($values as $value) {
            if ($value == $element) {
                return true;
            }
        }

        return false;
    }

    /**
     * Escapes the custom CSS, and then un-escapes the greater-than symbol
     * so it can work with direct descendant characters for bootstrap
     * menu overrides like:.
     *
     * .skin-blue .sidebar-menu>li.active>a, .skin-blue .sidebar-menu>li:hover>a
     *
     * Important: Do not remove the e() escaping here, as we output raw in the blade.
     *
     * @return string escaped CSS
     *
     * @author A. Gianotto <snipe@snipe.net>
     */
    public function show_custom_css(): string
    {
        $custom_css = self::getSettings()->custom_css;
        $custom_css = e($custom_css);
        // Needed for modifying the bootstrap nav :(
        $custom_css = str_ireplace('script', 'SCRIPTS-NOT-ALLOWED-HERE', $custom_css);
        $custom_css = str_replace('&gt;', '>', $custom_css);
        // Allow String output (needs quotes)
        $custom_css = str_replace('&quot;', '"', $custom_css);

        return $custom_css;
    }

    /**
     * Converts bytes into human readable file size.
     *
     * @param string $bytes
     *
     * @return string human readable file size (2,87 Мб)
     *
     * @author Mogilev Arseny
     */
    public static function fileSizeConvert($bytes): string
    {
        $result = 0;
        $bytes = floatval($bytes);
        $arBytes = [
                0 => [
                    'UNIT'  => 'TB',
                    'VALUE' => pow(1024, 4),
                ],
                1 => [
                    'UNIT'  => 'GB',
                    'VALUE' => pow(1024, 3),
                ],
                2 => [
                    'UNIT'  => 'MB',
                    'VALUE' => pow(1024, 2),
                ],
                3 => [
                    'UNIT'  => 'KB',
                    'VALUE' => 1024,
                ],
                4 => [
                    'UNIT'  => 'B',
                    'VALUE' => 1,
                ],
            ];

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem['VALUE']) {
                $result = $bytes / $arItem['VALUE'];
                $result = round($result, 2).$arItem['UNIT'];
                break;
            }
        }

        return $result;
    }

    /**
     * The url for slack notifications.
     *  Used by Notifiable trait.
     *
     * @return string
     */
    public function routeNotificationForSlack(): string
    {
        // At this point the endpoint is the same for everything.
        //  In the future this may want to be adapted for individual notifications.
        return self::getSettings()->slack_endpoint;
    }

    /**
     * Get the mail reply to address from configuration.
     *
     * @return string
     */
    public function routeNotificationForMail(): string
    {
        // At this point the endpoint is the same for everything.
        //  In the future this may want to be adapted for individual notifications.
        return config('mail.reply_to.address');
    }

    /**
     * Get the password complexity rule.
     *
     * @return string
     */
    public static function passwordComplexityRulesSaving($action = 'update'): string
    {
        $security_rules = '';
        $settings = self::getSettings();

        // Check if they have uncommon password enforcement selected in settings
        if ($settings->pwd_secure_uncommon == 1) {
            $security_rules .= '|dumbpwd';
        }

        // Check for any secure password complexity rules that may have been selected
        if ($settings->pwd_secure_complexity != '') {
            $security_rules .= '|'.$settings->pwd_secure_complexity;
        }

        if ($action == 'update') {
            return 'nullable|min:'.$settings->pwd_secure_min.$security_rules;
        }

        return 'required|min:'.$settings->pwd_secure_min.$security_rules;
    }

    /**
     * Get the specific LDAP settings
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return Collection
     */
    public static function getLdapSettings(): Collection
    {
        $ldapSettings = self::select([
            'ldap_enabled',
            'ldap_server',
            'ldap_uname',
            'ldap_pword',
            'ldap_basedn',
            'ldap_filter',
            'ldap_username_field',
            'ldap_lname_field',
            'ldap_fname_field',
            'ldap_auth_filter_query',
            'ldap_version',
            'ldap_active_flag',
            'ldap_emp_num',
            'ldap_email',
            'ldap_server_cert_ignore',
            'ldap_port',
            'ldap_tls',
            'ldap_pw_sync',
            'is_ad',
            'ad_domain',
            'ad_append_domain',
            'ldap_client_tls_key',
            'ldap_client_tls_cert'
            ])->first()->getAttributes();

        return collect($ldapSettings);
    }

    /**
     * Return the filename for the client-side SSL cert
     *
     * @var string
     */
    public static function get_client_side_cert_path()
    {
        return storage_path().'/ldap_client_tls.cert';
    }

    /**
     * Return the filename for the client-side SSL key
     *
     * @var string
     */
    public static function get_client_side_key_path()
    {
        return storage_path().'/ldap_client_tls.key';
    }

    public function update_client_side_cert_files()
    {
        /**
         * I'm not sure if it makes sense to have a cert but no key
         * nor vice versa, but for now I'm just leaving it like this.
         *
         * Also, we could easily set this up with an event handler and
         * self::saved() or something like that but there's literally only
         * one place where we will do that, so I'll just explicitly call
         * this method at that spot instead. It'll be easier to debug and understand.
         */
        if ($this->ldap_client_tls_cert) {
            file_put_contents(self::get_client_side_cert_path(), $this->ldap_client_tls_cert);
        } else {
            if (file_exists(self::get_client_side_cert_path())) {
                unlink(self::get_client_side_cert_path());
            }
        }

        if ($this->ldap_client_tls_key) {
            file_put_contents(self::get_client_side_key_path(), $this->ldap_client_tls_key);
        } else {
            if (file_exists(self::get_client_side_key_path())) {
                unlink(self::get_client_side_key_path());
            }
        }
    }


}
