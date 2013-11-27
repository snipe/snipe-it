<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Location;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class LocationsController extends AdminController {

	/**
	 * Show a list of all the locations.
	 *
	 * @return View
	 */

	public function getIndex()
	{
		// Grab all the locations
		$locations = Location::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

		// Show the page
		return View::make('backend/locations/index', compact('locations'));
	}


	/**
	 * Location create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		$location_options = array('0' => 'Top Level') + Location::lists('name', 'id');
		return View::make('backend/locations/edit')->with('location_options',$location_options)->with('location',new Location);
	}


	/**
	 * Location create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// create a new location instance
		$location = new Location();

		// attempt validation
		if ($location->validate($new))
		{

			// Save the location data
			$location->name            	= e(Input::get('name'));
			$location->address			= e(Input::get('address'));
			$location->address2			= e(Input::get('address2'));
			$location->city    			= e(Input::get('city'));
			$location->state    		= e(Input::get('state'));
			$location->country    		= e(Input::get('country'));
			$location->zip    		= e(Input::get('zip'));
			$location->user_id          = Sentry::getId();

			// Was the asset created?
			if($location->save())
			{
				// Redirect to the new location  page
				return Redirect::to("admin/settings/locations")->with('success', Lang::get('admin/locations/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $location->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the location create page
		return Redirect::to('admin/settings/locations/create')->with('error', Lang::get('admin/locations/message.create.error'));

	}


	/**
	 * Location update.
	 *
	 * @param  int  $locationId
	 * @return View
	 */
	public function getEdit($locationId = null)
	{
		// Check if the location exists
		if (is_null($location = Location::find($locationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.does_not_exist'));
		}

		// Show the page
		//$location_options = array('' => 'Top Level') + Location::lists('name', 'id');

		$location_options = array('' => 'Top Level') + DB::table('locations')->where('id', '!=', $locationId)->lists('name', 'id');
		return View::make('backend/locations/edit', compact('location'))->with('location_options',$location_options);
	}


	/**
	 * Location update form processing page.
	 *
	 * @param  int  $locationId
	 * @return Redirect
	 */
	public function postEdit($locationId = null)
	{
		// Check if the location exists
		if (is_null($location = Location::find($locationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.does_not_exist'));
		}



		// get the POST data
		$new = Input::all();


		// attempt validation
		if ($location->validate($new))
		{

			// Update the location data
			$location->name            	= e(Input::get('name'));
			$location->address			= e(Input::get('address'));
			$location->address2			= e(Input::get('address2'));
			$location->city    			= e(Input::get('city'));
			$location->state    		= e(Input::get('state'));
			$location->country    		= e(Input::get('country'));
			$location->zip    		= e(Input::get('zip'));

			// Was the asset created?
			if($location->save())
			{
				// Redirect to the saved location page
				return Redirect::to("admin/settings/locations/$locationId/edit")->with('success', Lang::get('admin/locations/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $location->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the location management page
		return Redirect::to("admin/settings/locations/$locationId/edit")->with('error', Lang::get('admin/locations/message.update.error'));

	}

	/**
	 * Delete the given location.
	 *
	 * @param  int  $locationId
	 * @return Redirect
	 */
	public function getDelete($locationId)
	{
		// Check if the location exists
		if (is_null($location = Location::find($locationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.not_found'));
		}


		if ($location->has_users() > 0) {

			// Redirect to the asset management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.assoc_users'));
		} else {

			$location->delete();

			// Redirect to the locations management page
			return Redirect::to('admin/settings/locations')->with('success', Lang::get('admin/locations/message.delete.success'));
		}



	}



}
