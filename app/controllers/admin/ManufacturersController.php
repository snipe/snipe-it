<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Manufacturer;
use Redirect;
use Setting;
use Sentry;
use Str;
use Validator;
use View;

class ManufacturersController extends AdminController {

	/**
	 * Show a list of all manufacturers
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the manufacturers
		$manufacturers = Manufacturer::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

		// Show the page
		return View::make('backend/manufacturers/index', compact('manufacturers'));
	}


	/**
	 * Manufacturer create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		return View::make('backend/manufacturers/edit')->with('manufacturer', new Manufacturer);
	}


	/**
	 * Manufacturer create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// Create a new manufacturer
		$manufacturer = new Manufacturer;

		// attempt validation
		if ($manufacturer->validate($new))
		{

			// Save the location data
			$manufacturer->name            = e(Input::get('name'));
			$manufacturer->user_id          = Sentry::getId();

			// Was it created?
			if($manufacturer->save())
			{
				// Redirect to the new manufacturer  page
				return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $manufacturer->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the manufacturer create page
		return Redirect::to('admin/settings/manufacturers/create')->with('error', Lang::get('admin/manufacturers/message.create.error'));

	}

	/**
	 * Manufacturer update.
	 *
	 * @param  int  $manufacturerId
	 * @return View
	 */
	public function getEdit($manufacturerId = null)
	{
		// Check if the manufacturer exists
		if (is_null($manufacturer = Manufacturer::find($manufacturerId)))
		{
			// Redirect to the manufacturer  page
			return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
		}

		// Show the page
		return View::make('backend/manufacturers/edit', compact('manufacturer'));
	}


	/**
	 * Manufacturer update form processing page.
	 *
	 * @param  int  $manufacturerId
	 * @return Redirect
	 */
	public function postEdit($manufacturerId = null)
	{
		// Check if the manufacturer exists
		if (is_null($manufacturer = Manufacturer::find($manufacturerId)))
		{
			// Redirect to the manufacturer  page
			return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
		}


		// get the POST data
		$new = Input::all();

		// attempt validation
		if ($manufacturer->validate($new))
		{

			// Save the  data
			$manufacturer->name 	= e(Input::get('name'));

			// Was it created?
			if($manufacturer->save())
			{
				// Redirect to the new manufacturer page
				return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $manufacturer->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the manufacturer management page
		return Redirect::to("admin/settings/manufacturers/$manufacturerId/edit")->with('error', Lang::get('admin/manufacturers/message.update.error'));

	}

	/**
	 * Delete the given manufacturer.
	 *
	 * @param  int  $manufacturerId
	 * @return Redirect
	 */
	public function getDelete($manufacturerId)
	{
		// Check if the manufacturer exists
		if (is_null($manufacturer = Manufacturer::find($manufacturerId)))
		{
			// Redirect to the manufacturers page
			return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.not_found'));
		}

		if ($manufacturer->has_models() > 0) {

			// Redirect to the asset management page
			return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.assoc_users'));
		} else {

			// Delete the manufacturer
			$manufacturer->delete();

			// Redirect to the manufacturers management page
		return Redirect::to('admin/settings/manufacturers')->with('success', Lang::get('admin/manufacturers/message.delete.success'));
		}






	}




}
