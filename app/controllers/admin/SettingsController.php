<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Setting;
use Redirect;
use DB;
use Sentry;
use Str;
use Validator;
use View;
use Image;
use Config;
use Response;
use Artisan;
use Crypt;


class SettingsController extends AdminController
{
    /**
     * Show a list of all the settings.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the settings
        $settings = Setting::all();

        // Show the page
        return View::make('backend/settings/index', compact('settings'));
    }


    /**
     * Setting update.
     * @return View
     */
    public function getEdit()
    {
        $setting = Setting::first();
        $is_gd_installed = extension_loaded('gd');

        // echo '<pre>';
        // print_r($settings);
        // echo '</pre>';
        // exit;

        if ($setting->ldap_pword!='') {
          $show_ldap_pword = Crypt::decrypt($setting->ldap_pword);
        } else {
          $show_ldap_pword = '';
        }
        return View::make('backend/settings/edit', compact('setting'))->with('is_gd_installed',$is_gd_installed)->with('show_ldap_pword',$show_ldap_pword);
    }


    /**
     * Setting update form processing page.
     *
     * @return Redirect
     */
    public function postEdit()
    {

        // Check if the asset exists
        if (is_null($setting = Setting::find(1))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin')->with('error', Lang::get('admin/settings/message.update.error'));
        }

        $new = Input::all();


        // Declare the rules for the form validation

        $rules = array(
	        "brand"     => 'required|min:1|numeric',
            "per_page"   	=> 'required|min:1|numeric',
	        "qr_text"		=> 'min:1|max:31',
	        "logo"   		=> 'mimes:jpeg,bmp,png,gif',
            "custom_css"   => 'alpha_space',
	        "alert_email"   => 'email',
	        "slack_endpoint"   => 'url',
            "default_currency"   => 'required',
	        "slack_channel"   => 'regex:/(?<!\w)#\w+/',
	        "slack_botname"   => 'alpha_dash',
            "ldap_server"   => 'sometimes|required_if:ldap_enabled,1|url',
            "ldap_uname"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_pword"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_basedn"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_filter"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_username_field"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_lname_field"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_auth_filter_query"     => 'sometimes|required_if:ldap_enabled,1',
            "ldap_version"     => 'sometimes|required_if:ldap_enabled,1',
	        );

        if (Config::get('app.lock_passwords')==false) {
	        $rules['site_name'] = 'required|min:3';
	      }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);


        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (Input::get('clear_logo')=='1') {
	        $setting->logo = NULL;
        } elseif (Input::file('logo')) {
            if (!Config::get('app.lock_passwords')) {
                $image = Input::file('logo');
                $file_name = "logo.".$image->getClientOriginalExtension();
                $path = public_path('uploads/'.$file_name);
                Image::make($image->getRealPath())->resize(null, 40, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $setting->logo = $file_name;
            }
        }


        // Update the asset data
            $setting->id = '1';

             if (Config::get('app.lock_passwords')==false) {
	             $setting->site_name = e(Input::get('site_name'));
                 $setting->brand = e(Input::get('brand'));
                 $setting->custom_css = e(Input::get('custom_css'));
             }

            $setting->per_page = e(Input::get('per_page'));
            $setting->qr_code = e(Input::get('qr_code', '0'));
            $setting->barcode_type = e(Input::get('barcode_type'));
            $setting->load_remote = e(Input::get('load_remote', '0'));
            $setting->default_currency = Input::get('default_currency', '$');
            $setting->qr_text = e(Input::get('qr_text'));
            $setting->auto_increment_prefix = e(Input::get('auto_increment_prefix'));
            $setting->auto_increment_assets = e(Input::get('auto_increment_assets', '0'));
            $setting->alert_email = e(Input::get('alert_email'));
            $setting->alerts_enabled = e(Input::get('alerts_enabled', '0'));
            $setting->header_color = e(Input::get('header_color'));
            $setting->default_eula_text = e(Input::get('default_eula_text'));
            $setting->slack_endpoint = e(Input::get('slack_endpoint'));
            $setting->slack_channel = e(Input::get('slack_channel'));
            $setting->slack_botname = e(Input::get('slack_botname'));
            $setting->ldap_enabled = Input::get('ldap_enabled', '0');
            $setting->ldap_server = Input::get('ldap_server');
            $setting->ldap_server_cert_ignore = Input::get('ldap_server_cert_ignore', false);
            $setting->ldap_uname = Input::get('ldap_uname');
            $setting->ldap_pword = Crypt::encrypt(Input::get('ldap_pword'));
            $setting->ldap_basedn = Input::get('ldap_basedn');
            $setting->ldap_filter = Input::get('ldap_filter');
            $setting->ldap_username_field = Input::get('ldap_username_field');
            $setting->ldap_lname_field = Input::get('ldap_lname_field');
            $setting->ldap_fname_field = Input::get('ldap_fname_field');
            $setting->ldap_auth_filter_query = Input::get('ldap_auth_filter_query');
            $setting->ldap_version = Input::get('ldap_version');
            $setting->ldap_active_flag = Input::get('ldap_active_flag');
            $setting->ldap_emp_num = Input::get('ldap_emp_num');
            $setting->ldap_email = Input::get('ldap_email');

            if (Sentry::getUser()->isSuperUser()) {
                $setting->full_multiple_companies_support = e(Input::get('full_multiple_companies_support', '0'));
            }


            // Was the asset updated?
            if($setting->save()) {
                // Redirect to the settings page
                return Redirect::to("admin/settings/app")->with('success', Lang::get('admin/settings/message.update.success'));
            }

            // Redirect to the setting management page
            return Redirect::to("admin/settings/app/edit")->with('error', Lang::get('admin/settings/message.update.error'));

    }


    /**
    * Generate the backup page
    *
    * @return View
    **/

    public function getBackups()
    {
        $path = Config::get('backup::path');
        $files = array();

        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                clearstatcache();
                if (substr(strrchr($entry,'.'),1)=='zip') {
                    $files[] = array(
                            'filename' => $entry,
                            'filesize' => Setting::fileSizeConvert(filesize(Config::get('backup::path').$entry)),
                            'modified' => filemtime(Config::get('backup::path').$entry)
                        );
                }

            }
            closedir($handle);
            $files = array_reverse($files);
        }


        return View::make('backend/settings/backups', compact('path','files'));
    }


    /**
    * Generate the backup page
    *
    * @return View
    **/

    public function postBackups()
    {
        if (!Config::get('app.lock_passwords')) {
            Artisan::call('snipe:backup');
            return Redirect::to("admin/settings/backups")->with('success', Lang::get('admin/settings/message.backup.generated'));
        } else {
            Artisan::call('snipe:backup');
            return Redirect::to("admin/settings/backups")->with('error', Lang::get('general.feature_disabled'));
        }


    }


    /**
     * Download the dump file
     *
     * @param string|null $filename
     * @return View
     */
    public function downloadFile($filename = null)
    {
        if (!Config::get('app.lock_passwords')) {
            $file = Config::get('backup::path').'/'.$filename;
            if (file_exists($file)) {
    				return Response::download($file);
            } else {

                // Redirect to the backup page
                return Redirect::route('settings/backups')->with('error',  Lang::get('admin/settings/message.backup.file_not_found'));
            }
        } else {
            // Redirect to the backup page
            return Redirect::route('settings/backups')->with('error',  Lang::get('general.feature_disabled'));
        }


    }

    /**
     * Download the dump file
     *
     * @param string|null $filename
     * @return View
     */
    public function deleteFile($filename = null)
    {

        if (!Config::get('app.lock_passwords')) {

            $file = Config::get('backup::path').'/'.$filename;
            if (file_exists($file)) {
    			unlink($file);
                return Redirect::route('settings/backups')->with('success', Lang::get('admin/settings/message.backup.file_deleted'));
            } else {
                return Redirect::route('settings/backups')->with('error', Lang::get('admin/settings/message.backup.file_not_found'));
            }
        } else {
            return Redirect::route('settings/backups')->with('error',  Lang::get('general.feature_disabled'));
        }

    }




}
