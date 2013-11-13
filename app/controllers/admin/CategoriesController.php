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
		return View::make('backend/categories/index', compact('category'));
	}

	/**
	 * Blog post create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		return View::make('backend/categories/create');
	}

	/**
	 * Blog post create form processing.
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

		// Create a new category
		$category = new Category;

		// Update the category data
		$category->name            = e(Input::get('name'));
		$category->user_id          = Sentry::getId();

		// Was the category created?
		if($category->save())
		{
			// Redirect to the new category page
			return Redirect::to("assets/categories/$category->id/edit")->with('success', Lang::get('admin/categories/message.create.success'));
		}

		// Redirect to the category create page
		return Redirect::to('assets/categories/create')->with('error', Lang::get('assets/categories/message.create.error'));
	}

	/**
	 * Category update.
	 *
	 * @param  int  $categoryId
	 * @return View
	 */
	public function getEdit($categoryId = null)
	{
		// Check if the category exists
		if (is_null($category = Category::find($categoryId)))
		{
			// Redirect to the categories management page
			return Redirect::to('assets/categories')->with('error', Lang::get('assets/categories/message.does_not_exist'));
		}

		// Show the page
		return View::make('backend/categories/edit', compact('category'));
	}

	/**
	 * Category update form processing page.
	 *
	 * @param  int  $categoryId
	 * @return Redirect
	 */
	public function postEdit($categoryId = null)
	{
		// Check if the category exists
		if (is_null($category = Model::find($categoryId)))
		{
			// Redirect to the categories management page
			return Redirect::to('assets/categories')->with('error', Lang::get('assets/categories/message.does_not_exist'));
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

		// Update the category data
		$category->name = e(Input::get('name'));

		// Was the category updated?
		if($category->save())
		{
			// Redirect to the new category page
			return Redirect::to("admin/categories/$categoryId/edit")->with('success', Lang::get('assets/categories/message.update.success'));
		}

		// Redirect to the categories post management page
		return Redirect::to("admin/categories/$categoryId/edit")->with('error', Lang::get('assets/categories/message.update.error'));
	}

	/**
	 * Delete the given category.
	 *
	 * @param  int  $categoryId
	 * @return Redirect
	 */
	public function getDelete($categoryId)
	{
		// Check if the category exists
		if (is_null($category = Category::find($categoryId)))
		{
			// Redirect to the categories management page
			return Redirect::to('assets/categories')->with('error', Lang::get('assets/categories/message.not_found'));
		}

		// Delete the category
		$category->delete();

		// Redirect to the category management page
		return Redirect::to('assets/categories')->with('success', Lang::get('admin/categories/message.delete.success'));
	}

}
