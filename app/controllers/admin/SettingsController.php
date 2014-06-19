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

class SettingsController extends AdminController {

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
	 *
	 * @param  int  $settingId
	 * @return View
	 */
	public function getEdit()
	{
		$settings = Setting::orderBy('created_at', 'DESC')->paginate(10);
		$is_gd_installed = extension_loaded('gd');
		return View::make('backend/settings/edit', compact('settings', 'is_gd_installed'));
	}


	/**
	 * Setting update form processing page.
	 *
	 * @param  int  $settingId
	 * @return Redirect
	 */
	public function postEdit()
	{

		// Check if the asset exists
		if (is_null($setting = Setting::find(1)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/settings/message.update.error'));
		}

		$new = Input::all();


		// Declare the rules for the form validation
		$rules = array(
		"site_name" 	=> 'required|min:3',
		"per_page"   		=> 'required|min:1|numeric',
		"qr_text"		=> 'min:1|max:31'
    	);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);


		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the asset data
			$setting->id = '1';
			$setting->site_name = e(Input::get('site_name'));
			$setting->display_asset_name = e(Input::get('display_asset_name', '0'));
			$setting->per_page = e(Input::get('per_page'));
			$setting->qr_code = e(Input::get('qr_code', '0'));
			$setting->qr_text = e(Input::get('qr_text'));

			// Was the asset updated?
			if($setting->save())
			{
				// Redirect to the settings page
				return Redirect::to("admin/settings/app")->with('success', Lang::get('admin/settings/message.update.success'));
			}

			// Redirect to the setting management page
			return Redirect::to("admin/settings/app/edit")->with('error', Lang::get('admin/settings/message.update.error'));

	}




}
