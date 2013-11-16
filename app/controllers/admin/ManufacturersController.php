<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Manufacturer;
use Redirect;
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
		// Grab all the blog posts
		$manufacturers = Manufacturer::orderBy('created_at', 'DESC')->paginate(10);

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
		// Show the page
		$manufacturer_options = array('0' => 'Top Level') + Manufacturer::lists('name', 'id');
		return View::make('backend/manufacturers/edit')->with('manufacturer_options',$manufacturer_options)->with('manufacturer', new Manufacturer);
	}


	/**
	 * Manufacturer create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Create a new manufacturer
		$manufacturer = new Manufacturer;

		// Update the manufacturer data
		$manufacturer->name            = e(Input::get('name'));
		$manufacturer->user_id          = Sentry::getId();

		// Was the manufacturer created?
		if($manufacturer->save())
		{
			// Redirect to the new manufacturer  page
			return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.create.success'));
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
		// Check if the blog post exists
		if (is_null($manufacturer = Manufacturer::find($manufacturerId)))
		{
			// Redirect to the manufacturer  page
			return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the manufacturer data
		$manufacturer->name  = e(Input::get('name'));

		// Was the manufacturer updated?
		if($manufacturer->save())
		{
			// Redirect to the new manufacturer page
			return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.update.success'));
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

		// Delete the manufacturer
		$manufacturer->delete();

		// Redirect to the manufacturers management page
		return Redirect::to('admin/settings/manufacturers')->with('success', Lang::get('admin/manufacturers/message.delete.success'));
	}




}
