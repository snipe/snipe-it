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
	 * Show a list of all the blog posts.
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



}
