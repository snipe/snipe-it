<?php
namespace App\Http\Controllers;

use Input;
use Lang;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Ldap;
use Redirect;
use DB;
use Str;
use View;
use Image;
use Config;
use Response;
use Artisan;
use Crypt;
use Mail;
use Auth;
use App\Models\User;
use App\Http\Requests\SetupUserRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\SettingsLdapRequest;
use App\Helpers\Helper;
use App\Notifications\FirstAdminNotification;

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
    * @since [v3.0]
    * @return View
    */
    public function getSetupIndex()
    {


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

        $protocol = array_key_exists('HTTPS', $_SERVER) && ( $_SERVER['HTTPS'] == "on") ? 'https://' : 'http://';

        $host = array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : null;
        $port = array_key_exists('SERVER_PORT', $_SERVER) ? $_SERVER['SERVER_PORT'] : null;
        if (($protocol === 'http://' && $port != '80') || ($protocol === 'https://' && $port != '443')) {
            $host .= ':' . $port;
        }
        $pageURL = $protocol . $host . $_SERVER['REQUEST_URI'];

        $start_settings['url_valid'] = (url('/').'/setup' === $pageURL);

        $start_settings['url_config'] = url('/');
        $start_settings['real_url'] = $pageURL;

        // Curl the .env file to make sure it's not accessible via a browser
        $ch = curl_init($protocol . $host.'/.env');
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 404 || $httpcode == 403) {
            $start_settings['env_exposed'] = false;
        } else {
            $start_settings['env_exposed'] = true;
        }


        if (\App::Environment('production') && (config('app.debug')==true)) {
            $start_settings['debug_exposed'] = true;
        } else {
            $start_settings['debug_exposed'] = false;
        }

        $environment = app()->environment();
        if ($environment!='production') {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = false;
        } else {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = true;

        }

        if (function_exists('posix_getpwuid')) { // Probably Linux
            $owner = posix_getpwuid(fileowner($_SERVER["SCRIPT_FILENAME"]));
            $start_settings['owner'] = $owner['name'];
        } else { // Windows
            // TODO: Is there a way of knowing if a windows user has elevated permissions
            // This just gets the user name, which likely isn't 'root'
            // $start_settings['owner'] = getenv('USERNAME');
            $start_settings['owner'] = '';
        }

        if (($start_settings['owner']==='root') || ($start_settings['owner']==='0')) {
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
    * @since [v3.0]
    * @return Redirect
    */
    public function postSaveFirstAdmin(SetupUserRequest $request)
    {


        $user = new User;
        $user->first_name  = $data['first_name']= $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $data['email'] = $request->input('email');
        $user->activated = 1;
        $permissions = array('superuser' => 1);
        $user->permissions = json_encode($permissions);
        $user->username = $data['username'] = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $data['password'] =  $request->input('password');

        $settings = new Setting;
        $settings->full_multiple_companies_support = $request->input('full_multiple_companies_support', 0);
        $settings->site_name = $request->input('site_name');
        $settings->alert_email = $request->input('email');
        $settings->alerts_enabled = 1;
        $settings->pwd_secure_min = 10;
        $settings->brand = 1;
        $settings->locale = $request->input('locale', 'en');
        $settings->default_currency = $request->input('default_currency', "USD");
        $settings->user_id = 1;
        $settings->email_domain = $request->input('email_domain');
        $settings->email_format = $request->input('email_format');
        $settings->next_auto_tag_base = 1;
        $settings->auto_increment_assets = $request->input('auto_increment_assets', 0);
        $settings->auto_increment_prefix = $request->input('auto_increment_prefix');


        if ((!$user->isValid()) || (!$settings->isValid())) {
            return redirect()->back()->withInput()->withErrors($user->getErrors())->withErrors($settings->getErrors());
        } else {
            $user->save();
            Auth::login($user, true);
            $settings->save();

            if (Input::get('email_creds')=='1') {
                $data = array();
                $data['email'] = $user->email;
                $data['username'] = $user->username;
                $data['first_name'] = $user->first_name;
                $data['last_name'] = $user->last_name;
                $data['password'] = $request->input('password');
                $user->notify(new FirstAdminNotification($data));

                /*Mail::send(['text' => 'emails.firstadmin'], $data, function ($m) use ($data) {
                    $m->to($data['email'], $data['first_name']);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.your_credentials'));
                });*/
            }



            return redirect()->route('setup.done');
        }


    }

    /**
    * Return the admin user creation form in Setup.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
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
    * @since [v3.0]
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
    * to a view for Setup
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
    * @return View
    */
    public function getSetupMigrate()
    {

        Artisan::call('migrate', ['--force' => true]);

        $output = Artisan::output();

        if ((!file_exists(storage_path().'/oauth-private.key')) || (!file_exists(storage_path().'/oauth-public.key'))) {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('passport:install');
        }


        return view('setup/migrate')
        ->with('output', $output)
        ->with('step', 2)
        ->with('section', 'Create Database Tables');

    }


    /**
    * Return a view that shows some of the key settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function index()
    {
        $settings = Setting::all();
        return view('settings/index', compact('settings'));
    }


    /**
    * Return the admin settings page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getEdit()
    {
        $setting = Setting::first();
        return view('settings/general', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getSettings()
    {
        $setting = Setting::first();
        return view('settings/general', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postSettings(Request $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->modellist_displays = '';

        if (($request->has('show_in_model_list')) && (count($request->input('show_in_model_list')) > 0))
        {
            $setting->modellist_displays = implode(',', $request->input('show_in_model_list'));
        }


        $setting->full_multiple_companies_support = $request->input('full_multiple_companies_support', '0');
        $setting->load_remote = $request->input('load_remote', '0');
        $setting->show_images_in_email = $request->input('show_images_in_email', '0');
        $setting->show_archived_in_list = $request->input('show_archived_in_list', '0');
        $setting->dashboard_message = $request->input('dashboard_message');
        $setting->email_domain = $request->input('email_domain');
        $setting->email_format = $request->input('email_format');
        $setting->username_format = $request->input('username_format');
        $setting->require_accept_signature = $request->input('require_accept_signature');
        if (!config('app.lock_passwords')) {
            $setting->login_note = $request->input('login_note');
        }

        $setting->default_eula_text = $request->input('default_eula_text');
        $setting->thumbnail_max_h = $request->input('thumbnail_max_h');

        if (Input::get('per_page')!='') {
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
     * @since [v1.0]
     * @return View
     */
    public function getBranding()
    {
        $setting = Setting::first();
        return view('settings.branding', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postBranding(ImageUploadRequest $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->brand = $request->input('brand', '1');
        $setting->header_color = $request->input('header_color');
        $setting->support_footer = $request->input('support_footer');
        $setting->footer_text = $request->input('footer_text');
        $setting->skin = $request->input('skin');
        $setting->show_url_in_emails = $request->input('show_url_in_emails', '0');


        // Only allow the site name and CSS to be changed if lock_passwords is false
        // Because public demos make people act like dicks
        if (!config('app.lock_passwords')) {
            $setting->site_name = $request->input('site_name');
            $setting->custom_css = $request->input('custom_css');
        }


        // If the user wants to clear the logo, reset the brand type
        if ($request->input('clear_logo')=='1') {
            $setting->logo = null;
            $setting->brand = 1;

        // If they are uploading an image, validate it and upload it
        } elseif ($request->hasFile('image')) {

            if (!config('app.lock_passwords')) {
                $image = $request->file('image');
                $file_name = "logo.".$image->getClientOriginalExtension();
                $path = public_path('uploads');
                if ($image->getClientOriginalExtension()!='svg') {
                    Image::make($image->getRealPath())->resize(null, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($path.'/'.$file_name);
                } else {
                    $image->move($path, $file_name);
                }
                $setting->logo = $file_name;
            }
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
     * @since [v1.0]
     * @return View
     */
    public function getSecurity()
    {
        $setting = Setting::first();
        return view('settings.security', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postSecurity(Request $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }


        if (!config('app.lock_passwords')) {

            if ($request->input('two_factor_enabled')=='') {
                $setting->two_factor_enabled = null;
            } else {
                $setting->two_factor_enabled = $request->input('two_factor_enabled');
            }

        }

        $setting->pwd_secure_uncommon = (int) $request->input('pwd_secure_uncommon');
        $setting->pwd_secure_min = (int) $request->input('pwd_secure_min');
        $setting->pwd_secure_complexity = '';

        # remote user login
        $setting->login_remote_user_enabled = (int)$request->input('login_remote_user_enabled');
        $setting->login_common_disabled= (int)$request->input('login_common_disabled');
        $setting->login_remote_user_custom_logout_url = $request->input('login_remote_user_custom_logout_url');

        if ($request->has('pwd_secure_complexity')) {
            $setting->pwd_secure_complexity =  implode('|', $request->input('pwd_secure_complexity'));
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
     * @since [v1.0]
     * @return View
     */
    public function getLocalization()
    {
        $setting = Setting::first();
        return view('settings.localization', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postLocalization(Request $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->locale = $request->input('locale', 'en');
        $setting->default_currency = $request->input('default_currency', '$');
        $setting->date_display_format = $request->input('date_display_format');
        $setting->time_display_format = $request->input('time_display_format');

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
     * @since [v1.0]
     * @return View
     */
    public function getAlerts()
    {
        $setting = Setting::first();
        return view('settings.alerts', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postAlerts(Request $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
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
     * @since [v1.0]
     * @return View
     */
    public function getSlack()
    {
        $setting = Setting::first();
        return view('settings.slack', compact('setting'));
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postSlack(Request $request)
    {

        if (is_null($setting = Setting::first())) {
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
     * @since [v1.0]
     * @return View
     */
    public function getAssetTags()
    {
        $setting = Setting::first();
        return view('settings.asset_tags', compact('setting'));
    }


    /**
     * Saves settings from form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postAssetTags(Request $request)
    {

        if (is_null($setting = Setting::first())) {
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
     * @since [v1.0]
     * @return View
     */
    public function getBarcodes()
    {
        $setting = Setting::first();
        $is_gd_installed = extension_loaded('gd');

        return view('settings.barcodes', compact('setting'))->with('is_gd_installed',$is_gd_installed);
    }


    /**
     * Saves settings from form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function postBarcodes(Request $request)
    {

        if (is_null($setting = Setting::first())) {
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
     * @since [v4.0]
     * @return View
     */
    public function getPhpInfo()
    {
        if (config('app.debug')=== true) {
            return view('settings.phpinfo');
        }
        return redirect()->route('settings.index')
            ->with('error', 'PHP syetem debugging information is only available when debug is enabled in your .env file.');
    }


    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return View
     */
    public function getLabels()
    {
        $setting = Setting::first();
        return view('settings.labels', compact('setting'));
    }


    /**
     * Saves settings from form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return View
     */
    public function postLabels(Request $request)
    {

        if (is_null($setting = Setting::first())) {
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



        if (Input::has('labels_display_name')) {
            $setting->labels_display_name = 1;
        } else {
            $setting->labels_display_name = 0;
        }

        if (Input::has('labels_display_serial')) {
            $setting->labels_display_serial = 1;
        } else {
            $setting->labels_display_serial = 0;
        }

        if (Input::has('labels_display_tag')) {
            $setting->labels_display_tag = 1;
        } else {
            $setting->labels_display_tag = 0;
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
     * @since [v4.0]
     * @return View
     */
    public function getLdapSettings()
    {
        $setting = Setting::first();
        return view('settings.ldap', compact('setting'));
    }


    /**
     * Saves settings from form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return View
     */
    public function postLdapSettings(Request $request)
    {

        if (is_null($setting = Setting::first())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }

        $setting->ldap_enabled = $request->input('ldap_enabled', '0');
        $setting->ldap_server = $request->input('ldap_server');
        $setting->ldap_server_cert_ignore = $request->input('ldap_server_cert_ignore', false);
        $setting->ldap_uname = $request->input('ldap_uname');
        if (Input::has('ldap_pword')) {
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
        $setting->ad_domain = $request->input('ad_domain');
        $setting->is_ad = $request->input('is_ad', '0');
        $setting->ldap_tls = $request->input('ldap_tls', '0');
        $setting->ldap_pw_sync = $request->input('ldap_pw_sync', '0');
        $setting->custom_forgot_pass_url = $request->input('custom_forgot_pass_url');

        if ($setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($setting->getErrors());

    }






    /**
    * Show the listing of backups
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.8]
    * @return View
    */
    public function getBackups()
    {

        $path = storage_path().'/app/'.config('laravel-backup.backup.name');

        $files = array();

        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                clearstatcache();
                if (substr(strrchr($entry, '.'), 1)=='zip') {
                    $files[] = array(
                          'filename' => $entry,
                          'filesize' => Setting::fileSizeConvert(filesize($path.'/'.$entry)),
                          'modified' => filemtime($path.'/'.$entry)
                      );
                }

            }
            closedir($handle);
            rsort($files);
        }


        return view('settings/backups', compact('path', 'files'));
    }


    /**
    * Process the backup.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.8]
    * @return Redirect
    */

    public function postBackups()
    {

        if (!config('app.lock_passwords')) {
            Artisan::call('backup:run');
            $output = Artisan::output();

            // Backup completed
            if (!preg_match('/failed/', $output)) {
                return redirect()->route('settings.backups.index')
                    ->with('success', trans('admin/settings/message.backup.generated'));
            }


            $formatted_output = str_replace('Backup completed!', '', $output);
            $output_split = explode('...', $formatted_output);

            if (array_key_exists(2, $output_split)) {
                return redirect()->route("settings.backups.index")->with('error', $output_split[2]);
            }
            return redirect()->route("settings.backups.index")->with('error', $formatted_output);

            }
        return redirect()->route("settings.backups.index")->with('error', trans('general.feature_disabled'));




    }


    /**
    * Download the backup file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.8]
    * @return Redirect
    */
    public function downloadFile($filename = null)
    {
        if (!config('app.lock_passwords')) {
            $path = storage_path().'/app/'.config('laravel-backup.backup.name');
            $file = $path.'/'.$filename;
            if (file_exists($file)) {
                return Response::download($file);
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
    * Delete the backup file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.8]
    * @return View
    */
    public function deleteFile($filename = null)
    {

        if (!config('app.lock_passwords')) {

            $path = storage_path().'/app/'.config('laravel-backup.backup.name');
            $file = $path.'/'.$filename;
            if (file_exists($file)) {
                unlink($file);
                return redirect()->route('settings.backups.index')->with('success', trans('admin/settings/message.backup.file_deleted'));
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
     * @since [v4.0]
     * @return View
     */
    public function getPurge()
    {
        return view('settings.purge-form');
    }

    /**
    * Purges soft-deletes
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
    * @return View
    */
    public function postPurge()
    {
        if (!config('app.lock_passwords')) {
            if (Input::get('confirm_purge')=='DELETE') {
                // Run a backup immediately before processing
                Artisan::call('backup:run');
                Artisan::call('snipeit:purge', ['--force'=>'true','--no-interaction'=>true]);
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
     * @since [v4.0]
     * @return View
     */
    public function api() {
        return view('settings.api');
    }



    /**
     * Test the email configuration
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function ajaxTestEmail()
    {
        try {
            Mail::send('emails.test', [], function ($m) {
                $m->to(config('mail.from.address'), config('mail.from.name'));
                $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                $m->subject(trans('mail.test_email'));
            });
            return response()->json(Helper::formatStandardApiResponse('success', null, 'Maiol sent!'));
        } catch (Exception $e) {
            return response()->json(Helper::formatStandardApiResponse('success', null, $e->getMessage()));
        }

    }
}
