<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\StorageHelper;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\SettingsSamlRequest;
use App\Http\Requests\SetupUserRequest;
use App\Models\Setting;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\FirstAdminNotification;
use App\Notifications\MailTest;
use Auth;
use Crypt;
use DB;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Input;
use Redirect;
use Response;
use App\Http\Requests\SlackSettingsRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

/**
 * This controller handles all actions related to Settings for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class SettingsController extends Controller
{
    /**
     * Checks to see whether or not the database has a migrations table
     * and a user, otherwise display the setup view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return View
     */
    public function getSetupIndex()
    {
        $start_settings['php_version_min'] = false;

        if (version_compare(PHP_VERSION, config('app.min_php'), '<')) {
            return response('<center><h1>This software requires PHP version '.config('app.min_php').' or greater. This server is running '.PHP_VERSION.'. </h1><h2>Please upgrade PHP on this server and try again. </h2></center>', 500);
        }

        try {
            $conn = DB::select('select 2 + 2');
            $start_settings['db_conn'] = true;
            $start_settings['db_name'] = DB::connection()->getDatabaseName();
            $start_settings['db_error'] = null;
        } catch (\PDOException $e) {
            $start_settings['db_conn'] = false;
            $start_settings['db_name'] = config('database.connections.mysql.database');
            $start_settings['db_error'] = $e->getMessage();
        }

        $protocol = array_key_exists('HTTPS', $_SERVER) && ('on' == $_SERVER['HTTPS']) ? 'https://' : 'http://';

        $host = array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : null;
        $port = array_key_exists('SERVER_PORT', $_SERVER) ? $_SERVER['SERVER_PORT'] : null;
        if (('http://' === $protocol && '80' != $port) || ('https://' === $protocol && '443' != $port)) {
            $host .= ':'.$port;
        }
        $pageURL = $protocol.$host.$_SERVER['REQUEST_URI'];

        $start_settings['url_valid'] = (url('/').'/setup' === $pageURL);

        $start_settings['url_config'] = url('/');
        $start_settings['real_url'] = $pageURL;
        $start_settings['php_version_min'] = true;

        // Curl the .env file to make sure it's not accessible via a browser
        $ch = curl_init($protocol.$host.'/.env');
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (404 == $httpcode || 403 == $httpcode || 0 == $httpcode) {
            $start_settings['env_exposed'] = false;
        } else {
            $start_settings['env_exposed'] = true;
        }

        if (\App::Environment('production') && (true == config('app.debug'))) {
            $start_settings['debug_exposed'] = true;
        } else {
            $start_settings['debug_exposed'] = false;
        }

        $environment = app()->environment();
        if ('production' != $environment) {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = false;
        } else {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = true;
        }

        if (function_exists('posix_getpwuid')) { // Probably Linux
            $owner = posix_getpwuid(fileowner($_SERVER['SCRIPT_FILENAME']));
            $start_settings['owner'] = $owner['name'];
        } else { // Windows
            // TODO: Is there a way of knowing if a windows user has elevated permissions
            // This just gets the user name, which likely isn't 'root'
            // $start_settings['owner'] = getenv('USERNAME');
            $start_settings['owner'] = '';
        }

        if (('root' === $start_settings['owner']) || ('0' === $start_settings['owner'])) {
            $start_settings['owner_is_admin'] = true;
        } else {
            $start_settings['owner_is_admin'] = false;
        }

        if ((is_writable(storage_path()))
            && (is_writable(storage_path().'/framework'))
            && (is_writable(storage_path().'/framework/cache'))
            && (is_writable(storage_path().'/framework/sessions'))
            && (is_writable(storage_path().'/framework/views'))
            && (is_writable(storage_path().'/logs'))
        ) {
            $start_settings['writable'] = true;
        } else {
            $start_settings['writable'] = false;
        }

        $start_settings['gd'] = extension_loaded('gd');

        return view('setup/index')
            ->with('step', 1)
            ->with('start_settings', $start_settings)
            ->with('section', 'Pre-Flight Check');
    }

    /**
     * Save the first admin user from Setup.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return Redirect
     */
    public function postSaveFirstAdmin(SetupUserRequest $request)
    {
        $user = new User();
        $user->first_name = $data['first_name'] = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $data['email'] = $request->input('email');
        $user->activated = 1;
        $permissions = ['superuser' => 1];
        $user->permissions = json_encode($permissions);
        $user->username = $data['username'] = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $data['password'] = $request->input('password');

        $settings = new Setting();
        $settings->full_multiple_companies_support = $request->input('full_multiple_companies_support', 0);
        $settings->site_name = $request->input('site_name');
        $settings->alert_email = $request->input('email');
        $settings->alerts_enabled = 1;
        $settings->pwd_secure_min = 10;
        $settings->brand = 1;
        $settings->locale = $request->input('locale', 'en');
        $settings->default_currency = $request->input('default_currency', 'USD');
        $settings->user_id = 1;
        $settings->email_domain = $request->input('email_domain');
        $settings->email_format = $request->input('email_format');
        $settings->next_auto_tag_base = 1;
        $settings->auto_increment_assets = $request->input('auto_increment_assets', 0);
        $settings->auto_increment_prefix = $request->input('auto_increment_prefix');

        if ((! $user->isValid()) || (! $settings->isValid())) {
            return redirect()->back()->withInput()->withErrors($user->getErrors())->withErrors($settings->getErrors());
        } else {
            $user->save();
            Auth::login($user, true);
            $settings->save();

            if ($request->input('email_creds') == '1') {
                $data = [];
                $data['email'] = $user->email;
                $data['username'] = $user->username;
                $data['first_name'] = $user->first_name;
                $data['last_name'] = $user->last_name;
                $data['password'] = $request->input('password');
                $user->notify(new FirstAdminNotification($data));
            }

            return redirect()->route('setup.done');
        }
    }

    /**
     * Return the admin user creation form in Setup.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return View
     */
    public function getSetupUser()
    {
        return view('setup/user')
            ->with('step', 3)
            ->with('section', 'Create a User');
    }

    /**
     * Return the view that tells the user that the Setup is done.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return View
     */
    public function getSetupDone()
    {
        return view('setup/done')
            ->with('step', 4)
            ->with('section', 'Done!');
    }

    /**
     * Migrate the database tables, and return the output
     * to a view for Setup.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return View
     */
    public function getSetupMigrate()
    {
        Artisan::call('migrate', ['--force' => true]);
        if ((! file_exists(storage_path().'/oauth-private.key')) || (! file_exists(storage_path().'/oauth-public.key'))) {
            Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations', '--force' => true]);
            Artisan::call('passport:install');
        }

        return view('setup/migrate')
            ->with('output', 'Databases installed!')
            ->with('step', 2)
            ->with('section', 'Create Database Tables');
    }

    /**
     * Return a view that shows some of the key settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function index()
    {
        $settings = Setting::getSettings();

        return view('settings/index', compact('settings'));
    }

    /**
     * Return the admin settings page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getEdit()
    {
        $setting = Setting::getSettings();

        return view('settings/general', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getSettings()
    {
        $setting = Setting::getSettings();

        return view('settings/general', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postSettings(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->modellist_displays = '';

        if (($request->filled('show_in_model_list')) && (count($request->input('show_in_model_list')) > 0)) {
            $setting->modellist_displays = implode(',', $request->input('show_in_model_list'));
        }

        $setting->full_multiple_companies_support = $request->input('full_multiple_companies_support', '0');
        $setting->unique_serial = $request->input('unique_serial', '0');
        $setting->show_images_in_email = $request->input('show_images_in_email', '0');
        $setting->show_archived_in_list = $request->input('show_archived_in_list', '0');
        $setting->dashboard_message = $request->input('dashboard_message');
        $setting->email_domain = $request->input('email_domain');
        $setting->email_format = $request->input('email_format');
        $setting->username_format = $request->input('username_format');
        $setting->require_accept_signature = $request->input('require_accept_signature');
        $setting->show_assigned_assets = $request->input('show_assigned_assets', '0');
        if (! config('app.lock_passwords')) {
            $setting->login_note = $request->input('login_note');
        }

        $setting->default_eula_text = $request->input('default_eula_text');
        $setting->thumbnail_max_h = $request->input('thumbnail_max_h');
        $setting->privacy_policy_link = $request->input('privacy_policy_link');

        $setting->depreciation_method = $request->input('depreciation_method');

        if ($request->input('per_page') != '') {
            $setting->per_page = $request->input('per_page');
        } else {
            $setting->per_page = 200;
        }

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getBranding()
    {
        $setting = Setting::getSettings();

        return view('settings.branding', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postBranding(ImageUploadRequest $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->brand = $request->input('brand', '1');
        $setting->header_color = $request->input('header_color');
        $setting->support_footer = $request->input('support_footer');
        $setting->version_footer = $request->input('version_footer');
        $setting->footer_text = $request->input('footer_text');
        $setting->skin = $request->input('skin');
        $setting->allow_user_skin = $request->input('allow_user_skin');
        $setting->show_url_in_emails = $request->input('show_url_in_emails', '0');
        $setting->logo_print_assets = $request->input('logo_print_assets', '0');

        // Only allow the site name and CSS to be changed if lock_passwords is false
        // Because public demos make people act like dicks
        if (! config('app.lock_passwords')) {
            $setting->site_name = $request->input('site_name');
            $setting->custom_css = $request->input('custom_css');
        }

        $setting = $request->handleImages($setting, 600, 'logo', '', 'logo');

        if ('1' == $request->input('clear_logo')) {
                Storage::disk('public')->delete($setting->logo);
            $setting->logo = null;
                $setting->brand = 1;
        }


        $setting = $request->handleImages($setting, 600, 'email_logo', '', 'email_logo');


       if ('1' == $request->input('clear_email_logo')) {
            Storage::disk('public')->delete($setting->email_logo);
            $setting->email_logo = null;
            // If they are uploading an image, validate it and upload it
        }


        $setting = $request->handleImages($setting, 600, 'label_logo', '', 'label_logo');


        if ('1' == $request->input('clear_label_logo')) {
            Storage::disk('public')->delete($setting->label_logo);
            $setting->label_logo = null;
        }


        // If the user wants to clear the favicon...
         if ($request->hasFile('favicon')) {
            $favicon_image = $favicon_upload = $request->file('favicon');
            $favicon_ext = $favicon_image->getClientOriginalExtension();
            $setting->favicon = $favicon_file_name = 'favicon-uploaded.'.$favicon_ext;

            if (($favicon_image->getClientOriginalExtension() != 'ico') && ($favicon_image->getClientOriginalExtension() != 'svg')) {
                $favicon_upload = Image::make($favicon_image->getRealPath())->resize(null, 36, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // This requires a string instead of an object, so we use ($string)
                Storage::disk('public')->put($favicon_file_name, (string) $favicon_upload->encode());
            } else {
                Storage::disk('public')->put($favicon_file_name, file_get_contents($request->file('favicon')));
            }


            // Remove Current image if exists
            if (($setting->favicon) && (file_exists($favicon_file_name))) {
                Storage::disk('public')->delete($favicon_file_name);
            }
        } elseif ('1' == $request->input('clear_favicon')) {
             Storage::disk('public')->delete($setting->clear_favicon);
            $setting->favicon = null;

             // If they are uploading an image, validate it and upload it
         }

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getSecurity()
    {
        $setting = Setting::getSettings();

        return view('settings.security', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postSecurity(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }
        if (! config('app.lock_passwords')) {
            if ('' == $request->input('two_factor_enabled')) {
                $setting->two_factor_enabled = null;
            } else {
                $setting->two_factor_enabled = $request->input('two_factor_enabled');
            }

            // remote user login
            $setting->login_remote_user_enabled = (int) $request->input('login_remote_user_enabled');
            $setting->login_common_disabled = (int) $request->input('login_common_disabled');
            $setting->login_remote_user_custom_logout_url = $request->input('login_remote_user_custom_logout_url');
            $setting->login_remote_user_header_name = $request->input('login_remote_user_header_name');
        }

        $setting->pwd_secure_uncommon = (int) $request->input('pwd_secure_uncommon');
        $setting->pwd_secure_min = (int) $request->input('pwd_secure_min');
        $setting->pwd_secure_complexity = '';


        if ($request->filled('pwd_secure_complexity')) {
            $setting->pwd_secure_complexity = implode('|', $request->input('pwd_secure_complexity'));
        }

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getLocalization()
    {
        $setting = Setting::getSettings();

        return view('settings.localization', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postLocalization(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        if (! config('app.lock_passwords')) {
            $setting->locale = $request->input('locale', 'en');
        }
        $setting->default_currency = $request->input('default_currency', '$');
        $setting->date_display_format = $request->input('date_display_format');
        $setting->time_display_format = $request->input('time_display_format');
        $setting->digit_separator = $request->input('digit_separator');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getAlerts()
    {
        $setting = Setting::getSettings();

        return view('settings.alerts', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postAlerts(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        // Check if the audit interval has changed - if it has, we want to update ALL of the assets audit dates
        if ($request->input('audit_interval') != $setting->audit_interval) {

            // Be careful - this could be a negative number
            $audit_diff_months = ((int)$request->input('audit_interval') - (int)($setting->audit_interval));
            
            // Grab all of the assets that have an existing next_audit_date
            $assets = Asset::whereNotNull('next_audit_date')->get();

            // Update all of the assets' next_audit_date values
            foreach ($assets as $asset) {

                if ($asset->next_audit_date != '') {
                    $old_next_audit = new \DateTime($asset->next_audit_date);
                    $asset->next_audit_date = $old_next_audit->modify($audit_diff_months.' month')->format('Y-m-d');
                    $asset->forceSave();
                }
            }
        }

        $alert_email = rtrim($request->input('alert_email'), ',');
        $alert_email = trim($alert_email);
        $admin_cc_email = rtrim($request->input('admin_cc_email'), ',');
        $admin_cc_email = trim($admin_cc_email);

        $setting->alert_email = $alert_email;
        $setting->admin_cc_email = $admin_cc_email;
        $setting->alerts_enabled = $request->input('alerts_enabled', '0');
        $setting->alert_interval = $request->input('alert_interval');
        $setting->alert_threshold = $request->input('alert_threshold');
        $setting->audit_interval = $request->input('audit_interval');
        $setting->audit_warning_days = $request->input('audit_warning_days');
        $setting->show_alerts_in_menu = $request->input('show_alerts_in_menu', '0');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getSlack()
    {
        $setting = Setting::getSettings();

        return view('settings.slack', compact('setting'));
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postSlack(SlackSettingsRequest $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->slack_endpoint = $request->input('slack_endpoint');
        $setting->slack_channel = $request->input('slack_channel');
        $setting->slack_botname = $request->input('slack_botname');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getAssetTags()
    {
        $setting = Setting::getSettings();

        return view('settings.asset_tags', compact('setting'));
    }

    /**
     * Saves settings from form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postAssetTags(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->auto_increment_prefix = $request->input('auto_increment_prefix');
        $setting->auto_increment_assets = $request->input('auto_increment_assets', '0');
        $setting->zerofill_count = $request->input('zerofill_count');
        $setting->next_auto_tag_base = $request->input('next_auto_tag_base');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function getBarcodes()
    {
        $setting = Setting::getSettings();
        $is_gd_installed = extension_loaded('gd');

        return view('settings.barcodes', compact('setting'))->with('is_gd_installed', $is_gd_installed);
    }

    /**
     * Saves settings from form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return View
     */
    public function postBarcodes(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->qr_code = $request->input('qr_code', '0');
        $setting->alt_barcode = $request->input('alt_barcode');
        $setting->alt_barcode_enabled = $request->input('alt_barcode_enabled', '0');
        $setting->barcode_type = $request->input('barcode_type');
        $setting->qr_text = $request->input('qr_text');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function getPhpInfo()
    {
        if (true === config('app.debug')) {
            return view('settings.phpinfo');
        }

        return redirect()->route('settings.index')
            ->with('error', 'PHP syetem debugging information is only available when debug is enabled in your .env file.');
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function getLabels()
    {
        $setting = Setting::getSettings();

        return view('settings.labels', compact('setting'));
    }

    /**
     * Saves settings from form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function postLabels(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }
        $setting->labels_per_page = $request->input('labels_per_page');
        $setting->labels_width = $request->input('labels_width');
        $setting->labels_height = $request->input('labels_height');
        $setting->labels_pmargin_left = $request->input('labels_pmargin_left');
        $setting->labels_pmargin_right = $request->input('labels_pmargin_right');
        $setting->labels_pmargin_top = $request->input('labels_pmargin_top');
        $setting->labels_pmargin_bottom = $request->input('labels_pmargin_bottom');
        $setting->labels_display_bgutter = $request->input('labels_display_bgutter');
        $setting->labels_display_sgutter = $request->input('labels_display_sgutter');
        $setting->labels_fontsize = $request->input('labels_fontsize');
        $setting->labels_pagewidth = $request->input('labels_pagewidth');
        $setting->labels_pageheight = $request->input('labels_pageheight');
        $setting->labels_display_company_name = $request->input('labels_display_company_name', '0');
        $setting->labels_display_company_name = $request->input('labels_display_company_name', '0');



        if ($request->filled('labels_display_name')) {
            $setting->labels_display_name = 1;
        } else {
            $setting->labels_display_name = 0;
        }

        if ($request->filled('labels_display_serial')) {
            $setting->labels_display_serial = 1;
        } else {
            $setting->labels_display_serial = 0;
        }

        if ($request->filled('labels_display_tag')) {
            $setting->labels_display_tag = 1;
        } else {
            $setting->labels_display_tag = 0;
        }

        if ($request->filled('labels_display_tag')) {
            $setting->labels_display_tag = 1;
        } else {
            $setting->labels_display_tag = 0;
        }

        if ($request->filled('labels_display_model')) {
            $setting->labels_display_model = 1;
        } else {
            $setting->labels_display_model = 0;
        }

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function getLdapSettings()
    {
        $setting = Setting::getSettings();

        return view('settings.ldap', compact('setting'));
    }

    /**
     * Saves settings from form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function postLdapSettings(Request $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        if (! config('app.lock_passwords') === true) {
            $setting->ldap_enabled = $request->input('ldap_enabled', '0');
            $setting->ldap_server = $request->input('ldap_server');
            $setting->ldap_server_cert_ignore = $request->input('ldap_server_cert_ignore', false);
            $setting->ldap_uname = $request->input('ldap_uname');
            if ($request->filled('ldap_pword')) {
                $setting->ldap_pword = Crypt::encrypt($request->input('ldap_pword'));
            }
            $setting->ldap_basedn = $request->input('ldap_basedn');
            $setting->ldap_filter = $request->input('ldap_filter');
            $setting->ldap_username_field = $request->input('ldap_username_field');
            $setting->ldap_lname_field = $request->input('ldap_lname_field');
            $setting->ldap_fname_field = $request->input('ldap_fname_field');
            $setting->ldap_auth_filter_query = $request->input('ldap_auth_filter_query');
            $setting->ldap_version = $request->input('ldap_version');
            $setting->ldap_active_flag = $request->input('ldap_active_flag');
            $setting->ldap_emp_num = $request->input('ldap_emp_num');
            $setting->ldap_email = $request->input('ldap_email');
            $setting->ldap_manager = $request->input('ldap_manager');
            $setting->ad_domain = $request->input('ad_domain');
            $setting->is_ad = $request->input('is_ad', '0');
            $setting->ad_append_domain = $request->input('ad_append_domain', '0');
            $setting->ldap_tls = $request->input('ldap_tls', '0');
            $setting->ldap_pw_sync = $request->input('ldap_pw_sync', '0');
            $setting->custom_forgot_pass_url = $request->input('custom_forgot_pass_url');
            $setting->ldap_phone_field = $request->input('ldap_phone');
            $setting->ldap_jobtitle = $request->input('ldap_jobtitle');
            $setting->ldap_country = $request->input('ldap_country');
            $setting->ldap_dept = $request->input('ldap_dept');
            $setting->ldap_client_tls_cert   = $request->input('ldap_client_tls_cert');
            $setting->ldap_client_tls_key    = $request->input('ldap_client_tls_key');


        }

        if ($setting->save()) {
            $setting->update_client_side_cert_files();
            return redirect()->route('settings.ldap.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author Johnson Yi <jyi.dev@outlook.com>
     *
     * @since v5.0.0
     *
     * @return View
     */
    public function getSamlSettings()
    {
        $setting = Setting::getSettings();

        return view('settings.saml', compact('setting'));
    }

    /**
     * Saves settings from form.
     *
     * @author Johnson Yi <jyi.dev@outlook.com>
     *
     * @since v5.0.0
     *
     * @return View
     */
    public function postSamlSettings(SettingsSamlRequest $request)
    {
        if (is_null($setting = Setting::getSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->saml_enabled = $request->input('saml_enabled', '0');
        $setting->saml_idp_metadata = $request->input('saml_idp_metadata');
        $setting->saml_attr_mapping_username = $request->input('saml_attr_mapping_username');
        $setting->saml_forcelogin = $request->input('saml_forcelogin', '0');
        $setting->saml_slo = $request->input('saml_slo', '0');
        if (! empty($request->input('saml_sp_privatekey'))) {
            $setting->saml_sp_x509cert = $request->input('saml_sp_x509cert');
            $setting->saml_sp_privatekey = $request->input('saml_sp_privatekey');
        }
        if (! empty($request->input('saml_sp_x509certNew'))) {
            $setting->saml_sp_x509certNew = $request->input('saml_sp_x509certNew');
        } else {
            $setting->saml_sp_x509certNew = '';
        }
        $setting->saml_custom_settings = $request->input('saml_custom_settings');

        if ($setting->save()) {
            return redirect()->route('settings.saml.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }
    public static function getPDFBranding()
    {
        $pdf_branding= Setting::getSettings();

        return $pdf_branding;
    }

    /**
     * Show the listing of backups.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.8]
     *
     * @return View
     */
    public function getBackups()
    {
        $settings = Setting::getSettings();
        $path = 'app/backups';
        $backup_files = Storage::files($path);
        $files_raw = [];

        if (count($backup_files) > 0) {
            for ($f = 0; $f < count($backup_files); $f++) {

                // Skip dotfiles like .gitignore and .DS_STORE
                if ((substr(basename($backup_files[$f]), 0, 1) != '.')) {
                    //$lastmodified = Carbon::parse(Storage::lastModified($backup_files[$f]))->toDatetimeString();
                    $file_timestamp = Storage::lastModified($backup_files[$f]);

                    $files_raw[] = [
                        'filename' => basename($backup_files[$f]),
                        'filesize' => Setting::fileSizeConvert(Storage::size($backup_files[$f])),
                        'modified_value' => $file_timestamp,
                        'modified_display' => date($settings->date_display_format.' '.$settings->time_display_format, $file_timestamp),
                        
                    ];
                }

               
            }
        }

        // Reverse the array so it lists oldest first
        $files = array_reverse($files_raw);

        return view('settings/backups', compact('path', 'files'));
    }

    /**
     * Process the backup.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.8]
     *
     * @return Redirect
     */
    public function postBackups()
    {
        if (! config('app.lock_passwords')) {
            Artisan::call('backup:run');
            $output = Artisan::output();

            // Backup completed
            if (! preg_match('/failed/', $output)) {
                return redirect()->route('settings.backups.index')
                    ->with('success', trans('admin/settings/message.backup.generated'));
            }

            $formatted_output = str_replace('Backup completed!', '', $output);
            $output_split = explode('...', $formatted_output);

            if (array_key_exists(2, $output_split)) {
                return redirect()->route('settings.backups.index')->with('error', $output_split[2]);
            }

            return redirect()->route('settings.backups.index')->with('error', $formatted_output);
        }

        return redirect()->route('settings.backups.index')->with('error', trans('general.feature_disabled'));
    }

    /**
     * Download the backup file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.8]
     *
     * @return Storage
     */
    public function downloadFile($filename = null)
    {
        $path = 'app/backups';

        if (! config('app.lock_passwords')) {
            if (Storage::exists($path.'/'.$filename)) {
                return StorageHelper::downloader($path.'/'.$filename);
            } else {
                // Redirect to the backup page
                return redirect()->route('settings.backups.index')->with('error', trans('admin/settings/message.backup.file_not_found'));
            }
        } else {
            // Redirect to the backup page
            return redirect()->route('settings.backups.index')->with('error', trans('general.feature_disabled'));
        }
    }

    /**
     * Delete the backup file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.8]
     *
     * @return View
     */
    public function deleteFile($filename = null)
    {
        if (! config('app.lock_passwords')) {
            $path = 'app/backups';

            if (Storage::exists($path.'/'.$filename)) {
                try {
                    Storage::delete($path.'/'.$filename);

                    return redirect()->route('settings.backups.index')->with('success', trans('admin/settings/message.backup.file_deleted'));
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            } else {
                return redirect()->route('settings.backups.index')->with('error', trans('admin/settings/message.backup.file_not_found'));
            }
        } else {
            return redirect()->route('settings.backups.index')->with('error', trans('general.feature_disabled'));
        }
    }


    /**
     * Uploads a backup file
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v6.0]
     *
     * @return Redirect
     */

    public function postUploadBackup(Request $request) {

        if (! config('app.lock_passwords')) {
            if (!$request->hasFile('file')) {
                return redirect()->route('settings.backups.index')->with('error', 'No file uploaded');
            } else {
                $max_file_size = Helper::file_upload_max_size();

                $rules = [
                    'file' => 'required|mimes:zip|max:'.$max_file_size,
                ];

                $validator = \Validator::make($request->all(), $rules);

                if ($validator->passes()) {

                        $upload_filename = 'uploaded-'.date('U').'-'.Str::slug(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME)).'.zip';

                        Storage::putFileAs('app/backups', $request->file('file'), $upload_filename);
            
                        return redirect()->route('settings.backups.index')->with('success', 'File uploaded');
                } else {
                    return redirect()->route('settings.backups.index')->withErrors($request->getErrors());
                }
            }

        } else {
            return redirect()->route('settings.backups.index')->with('error', trans('general.feature_disabled'));
        }    

        
        
    }

    /**
     * Restore the backup file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v6.0]
     *
     * @return View
     */
    public function postRestore($filename = null)
    {
        
        if (! config('app.lock_passwords')) {
            $path = 'app/backups';

            if (Storage::exists($path.'/'.$filename)) {

                // grab the user's info so we can make sure they exist in the system
                $user = User::find(Auth::user()->id);

                // TODO: run a backup


                Artisan::call('db:wipe', [
                    '--force' => true,
                ]);

                \Log::debug('Attempting to restore from: '. storage_path($path).'/'.$filename);

                // run the restore command
                Artisan::call('snipeit:restore', 
                [
                    '--force' => true, 
                    '--no-progress' => true, 
                    'filename' => storage_path($path).'/'.$filename
                ]);

                // If it's greater than 300, it probably worked
                $output = Artisan::output();

                if (strlen($output) > 300) {
                    $find_user = DB::table('users')->where('first_name', $user->first_name)->where('last_name', $user->last_name)->exists();

                    if (!$find_user){
                        \Log::warning('Attempting to restore user: ' . $user->first_name . ' ' . $user->last_name);
                        $new_user = $user->replicate();
                        $new_user->push();
                    }


                    \Log::debug('Logging all users out..');
                    Artisan::call('snipeit:global-logout', ['--force' => true]);
                    
                    /* run migrations */
                    \Log::debug('Migrating database...');
                    Artisan::call('migrate', ['--force' => true]);
                    $migrate_output = Artisan::output();
                    \Log::debug($migrate_output);

                    DB::table('users')->update(['remember_token' => null]);
                    \Auth::logout();

                    return redirect()->route('login')->with('success', 'Your system has been restored. Please login again.');
                } else {
                    return redirect()->route('settings.backups.index')->with('error', $output);

                }

            } else {
                return redirect()->route('settings.backups.index')->with('error', trans('admin/settings/message.backup.file_not_found'));
            }
        } else {
            return redirect()->route('settings.backups.index')->with('error', trans('general.feature_disabled'));
        }
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function getPurge()
    {
        \Log::warning('User ID '.Auth::user()->id.' is attempting a PURGE');

        return view('settings.purge-form');
    }

    /**
     * Purges soft-deletes.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return View
     */
    public function postPurge(Request $request)
    {
        if (! config('app.lock_passwords')) {
            if ('DELETE' == $request->input('confirm_purge')) {
                \Log::warning('User ID '.Auth::user()->id.' initiated a PURGE!');
                // Run a backup immediately before processing
                Artisan::call('backup:run');
                Artisan::call('snipeit:purge', ['--force' => 'true', '--no-interaction' => true]);
                $output = Artisan::output();

                return view('settings/purge')
                    ->with('output', $output)->with('success', trans('admin/settings/message.purge.success'));
            } else {
                return redirect()->back()->with('error', trans('admin/settings/message.purge.validation_failed'));
            }
        } else {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }
    }

    /**
     * Returns a page with the API token generation interface.
     *
     * We created a controller method for this because closures aren't allowed
     * in the routes file if you want to be able to cache the routes.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function api()
    {
        return view('settings.api');
    }

    /**
     * Test the email configuration.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v3.0]
     *
     * @return Redirect
     */
    public function ajaxTestEmail()
    {
        try {
            (new User())->forceFill([
                'name'  => config('mail.from.name'),
                'email' => config('mail.from.address'),
            ])->notify(new MailTest());

            return response()->json(Helper::formatStandardApiResponse('success', null, 'Maiol sent!'));
        } catch (Exception $e) {
            return response()->json(Helper::formatStandardApiResponse('success', null, $e->getMessage()));
        }
    }

    public function getLoginAttempts()
    {
        return view('settings.logins');
    }
}
