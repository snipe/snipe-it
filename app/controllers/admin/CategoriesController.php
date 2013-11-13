<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Category;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class CategoriesController extends AdminController {

	/**
	 * Show a list of all the categories.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the categorys
		$categories = Category::orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('backend/categories/index', compact('categories'));
	}

}
