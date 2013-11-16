<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Location;
use Redirect;
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
		$locations = Location::orderBy('created_at', 'DESC')->paginate(10);

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
		// Declare the rules for the form validation
		$rules = array(
			'name'  		=> 'required|min:3',
			'city'   		=> 'required|min:3',
			'state'   		=> 'required|min:2|max:2',
			'country'   	=> 'required|min:2|max:2',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Create a new location
		$location = new Location;

		// Update the location data
		$location->name            	= e(Input::get('name'));
		$location->city    			= e(Input::get('city'));
		$location->state    		= e(Input::get('state'));
		$location->country    		= e(Input::get('country'));
		$location->user_id          = Sentry::getId();

		// Was the location created?
		if($location->save())
		{
			// Redirect to the new location  page
			return Redirect::to("admin/settings/locations")->with('success', Lang::get('admin/locations/message.create.success'));
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
		// Check if the blog post exists
		if (is_null($location = Location::find($locationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'city'   => 'required|min:3',
			'state'   => 'required|min:2|max:2',
			'country'   => 'required|min:2|max:2',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the location data
		$location->name            	= e(Input::get('name'));
		$location->city    			= e(Input::get('city'));
		$location->state    		= e(Input::get('state'));
		$location->country    		= e(Input::get('country'));


		// Was the location updated?
		if($location->save())
		{
			// Redirect to the new location page
			return Redirect::to("admin/settings/locations/$locationId/edit")->with('success', Lang::get('admin/locations/message.update.success'));
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
		// Check if the blog post exists
		if (is_null($location = Location::find($locationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.not_found'));
		}

		// Delete the blog post
		$location->delete();

		// Redirect to the blog posts management page
		return Redirect::to('admin/settings/locations')->with('success', Lang::get('admin/locations/message.delete.success'));
	}



}
