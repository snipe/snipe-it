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
		$settings = Setting::orderBy('created_at', 'DESC')->paginate(10);

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
		return View::make('backend/settings/edit', compact('settings'));
	}


	/**
	 * Setting update form processing page.
	 *
	 * @param  int  $settingId
	 * @return Redirect
	 */
	public function postEdit()
	{

		$new = Input::all();

		// create a new model instance
		$setting = new Location();

		// attempt validation
		if ($setting->validate($new))
		{

			// Update the setting data
			$setting->option_value = e(Input::get('name'));


			// Was the asset created?
			if($setting->save())
			{
				// Redirect to the saved setting page
				return Redirect::to("admin/settings/app/$settingId/edit")->with('success', Lang::get('admin/settings/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $setting->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the setting management page
		return Redirect::to("admin/settings/app/$settingId/edit")->with('error', Lang::get('admin/settings/message.update.error'));

	}




}
