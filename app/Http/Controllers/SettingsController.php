<?php
/**
 * This controller handles all actions related to Settings for
 * the Snipe-IT Asset Management application.
 *
 * PHP version 5.5.9
 * @package    Snipe-IT
 * @version    v1.0
 */

namespace App\Http\Controllers;

use Input;
use Lang;
use App\Models\Setting;
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
use App\Models\User;
use App\Http\Requests\SetupUserRequest;
use App\Http\Requests\SettingRequest;

/**
 * This class controls all actions related to settings
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

        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';

        $pageURL = $protocol;
        if ($_SERVER["SERVER_PORT"] != "80") {
            $main_page = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
            $pageURL .= $main_page.$_SERVER["REQUEST_URI"];
        } else {
            $main_page = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            $pageURL .= $main_page;
        }

        $start_settings['env_location'] = $pageURL.'../.env';


        if (config('app.url').'/setup'!=$pageURL) {
            $start_settings['url_valid']= false;
        } else {
            $start_settings['url_valid']= true;
        }

        $start_settings['url_config']= config('app.url');
        $start_settings['real_url']= $pageURL;

        $exposed_env = @file_get_contents($main_page.'/.env');

        if ($exposed_env) {
            $start_settings['env_exposed'] = true;
        } else {
            $start_settings['env_exposed'] = false;
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

        $owner = posix_getpwuid(fileowner($_SERVER["SCRIPT_FILENAME"]));
        $start_settings['owner'] = $owner['name'];

        if (($start_settings['owner']=='root') || ($start_settings['owner']=='0') || ($start_settings['owner']=='root')) {
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
        return View::make('setup/index')
        ->with('step', 1)
        ->with('start_settings', $start_settings)
        ->with('section', 'Pre-Flight Check');
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
                $m->subject('Test Email from Snipe-IT');
            });
            return 'success';
        } catch (Exception $e) {
            return 'error';
        }

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
        $user->first_name  = $data['first_name']= e(Input::get('first_name'));
        $user->last_name = e(Input::get('last_name'));
        $user->email = $data['email'] = e(Input::get('email'));
        $user->activated = 1;
        $user->username = $data['username'] = e(Input::get('username'));
        $user->password = bcrypt(Input::get('password'));
        $data['password'] =  Input::get('password');

        $settings = new Setting;
        $settings->site_name = e(Input::get('site_name'));
        $settings->alert_email = e(Input::get('email'));
        $settings->alerts_enabled = 1;
        $settings->brand = 1;
        $settings->default_currency = 'USD';
        $settings->user_id = 1;

        if ((!$user->isValid('initial')) && (!$settings->isValid('initial'))) {
            return Redirect::back()->withInput()->withErrors($user->getErrors())->withErrors($settings->getErrors());
        } else {
            $user->save();
            $settings->save();

            if (Input::get('email_creds')=='1') {
                Mail::send(['text' => 'emails.firstadmin'], $data, function ($m) use ($data) {
                    $m->to($data['email'], $data['first_name']);
                    $m->subject('Your Snipe-IT credentials');
                });
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
        return View::make('setup/user')
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
        return View::make('setup/done')
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
        return View::make('setup/migrate')
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
    public function getIndex()
    {
        // Grab all the settings
        $settings = Setting::all();

        // Show the page
        return View::make('settings/index', compact('settings'));
    }


    /**
    * Return a form to allow a super admin to update settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getEdit()
    {
        $setting = Setting::first();
        $is_gd_installed = extension_loaded('gd');

        return View::make('settings/edit', compact('setting'))->with('is_gd_installed', $is_gd_installed);
    }


    /**
    * Validate and process settings edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function postEdit(SettingRequest $request)
    {

        // Check if the asset exists
        if (is_null($setting = Setting::find(1))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin')->with('error', Lang::get('admin/settings/message.update.error'));
        }

        if (Input::get('clear_logo')=='1') {
            $setting->logo = null;
        } elseif (Input::file('logo_img')) {
            if (!config('app.lock_passwords')) {
                $image = Input::file('logo_img');
                $file_name = "logo.".$image->getClientOriginalExtension();
                $path = public_path('uploads/'.$file_name);
                Image::make($image->getRealPath())->resize(null, 40, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $setting->logo = $file_name;
            }
        }

        $setting->id = '1';

        if (config('app.lock_passwords')==false) {
            $setting->site_name = e(Input::get('site_name'));
            $setting->brand = e(Input::get('brand'));
            $setting->custom_css = e(Input::get('custom_css'));
        }

        if (Input::get('per_page')!='') {
            $setting->per_page = e(Input::get('per_page'));
        } else {
            $setting->per_page = 200;
        }

        $setting->locale = e(Input::get('locale', 'en'));
        $setting->qr_code = e(Input::get('qr_code', '0'));
        $setting->barcode_type = e(Input::get('barcode_type'));
        $setting->load_remote = e(Input::get('load_remote', '0'));
        $setting->default_currency = e(Input::get('default_currency', '$'));
        $setting->qr_text = e(Input::get('qr_text'));
        $setting->auto_increment_prefix = e(Input::get('auto_increment_prefix'));
        $setting->auto_increment_assets = e(Input::get('auto_increment_assets', '0'));

        $setting->labels_per_page = e(Input::get('labels_per_page'));
        $setting->labels_width = e(Input::get('labels_width'));
        $setting->labels_height = e(Input::get('labels_height'));
        $setting->labels_pmargin_left = e(Input::get('labels_pmargin_left'));
        $setting->labels_pmargin_right = e(Input::get('labels_pmargin_right'));
        $setting->labels_pmargin_top = e(Input::get('labels_pmargin_top'));
        $setting->labels_pmargin_bottom = e(Input::get('labels_pmargin_bottom'));
        $setting->labels_display_bgutter = e(Input::get('labels_display_bgutter'));
        $setting->labels_display_sgutter = e(Input::get('labels_display_sgutter'));
        $setting->labels_fontsize = e(Input::get('labels_fontsize'));
        $setting->labels_pagewidth = e(Input::get('labels_pagewidth'));
        $setting->labels_pageheight = e(Input::get('labels_pageheight'));

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

        $alert_email = rtrim(Input::get('alert_email'), ',');
        $alert_email = trim(Input::get('alert_email'));

        $setting->alert_email = e($alert_email);
        $setting->alerts_enabled = e(Input::get('alerts_enabled', '0'));
        $setting->header_color = e(Input::get('header_color'));
        $setting->default_eula_text = e(Input::get('default_eula_text'));
        $setting->slack_endpoint = e(Input::get('slack_endpoint'));
        $setting->slack_channel = e(Input::get('slack_channel'));
        $setting->slack_botname = e(Input::get('slack_botname'));
        $setting->ldap_enabled = e(Input::get('ldap_enabled', '0'));
        $setting->ldap_server = e(Input::get('ldap_server'));
        $setting->ldap_server_cert_ignore = e(Input::get('ldap_server_cert_ignore', false));
        $setting->ldap_uname = e(Input::get('ldap_uname'));
        if (Input::has('ldap_pword')) {
            $setting->ldap_pword = Crypt::encrypt(Input::get('ldap_pword'));
        }
        $setting->ldap_basedn = e(Input::get('ldap_basedn'));
        $setting->ldap_filter = Input::get('ldap_filter');
        $setting->ldap_username_field = Input::get('ldap_username_field');
        $setting->ldap_lname_field = e(Input::get('ldap_lname_field'));
        $setting->ldap_fname_field = e(Input::get('ldap_fname_field'));
        $setting->ldap_auth_filter_query = Input::get('ldap_auth_filter_query');
        $setting->ldap_version = e(Input::get('ldap_version'));
        $setting->ldap_active_flag = e(Input::get('ldap_active_flag'));
        $setting->ldap_emp_num = e(Input::get('ldap_emp_num'));
        $setting->ldap_email = e(Input::get('ldap_email'));

        // If validation fails, we'll exit the operation now.
        if ($setting->save()) {
            return Redirect::to("admin/settings/app")->with('success', Lang::get('admin/settings/message.update.success'));

        } else {
            return Redirect::back()->withInput()->withErrors($setting->getErrors());
        }


        // Redirect to the setting management page
        return Redirect::to("admin/settings/app/edit")->with('error', Lang::get('admin/settings/message.update.error'));

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

        $path = config('app.private_uploads').'/backups';

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
            $files = array_reverse($files);
        }


        return View::make('settings/backups', compact('path', 'files'));
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
            return Redirect::to("admin/settings/backups")->with('success', Lang::get('admin/settings/message.backup.generated'));
        } else {

            return Redirect::to("admin/settings/backups")->with('error', Lang::get('general.feature_disabled'));
        }


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
            $path = config('app.private_uploads').'/backups';
            $file = $path.'/'.$filename;
            if (file_exists($file)) {
                return Response::download($file);
            } else {

                // Redirect to the backup page
                return Redirect::route('settings/backups')->with('error', Lang::get('admin/settings/message.backup.file_not_found'));
            }
        } else {
            // Redirect to the backup page
            return Redirect::route('settings/backups')->with('error', Lang::get('general.feature_disabled'));
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

            $file = config('backup::path').'/'.$filename;
            if (file_exists($file)) {
                unlink($file);
                return Redirect::route('settings/backups')->with('success', Lang::get('admin/settings/message.backup.file_deleted'));
            } else {
                return Redirect::route('settings/backups')->with('error', Lang::get('admin/settings/message.backup.file_not_found'));
            }
        } else {
            return Redirect::route('settings/backups')->with('error', Lang::get('general.feature_disabled'));
        }

    }
}
