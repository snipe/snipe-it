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


	/**
	 * Category create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		return View::make('backend/categories/create');
	}


	/**
	 * Category create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'parent'   => 'required|min:1',
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
		$category->parent    = e(Input::get('parent'));
		$category->user_id          = Sentry::getId();

		// Was the category created?
		if($category->save())
		{
			// Redirect to the new category  page
			return Redirect::to("admin/settings/categories/$category->id/edit")->with('success', Lang::get('admin/categories/message.create.success'));
		}

		// Redirect to the category create page
		return Redirect::to('admin/settings/categories/create')->with('error', Lang::get('admin/categories/message.create.error'));
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
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/settingscategories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
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
		// Check if the blog post exists
		if (is_null($category = Category::find($categoryId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'parent' => 'required|min:1',
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
		$category->name            = e(Input::get('name'));
		$category->parent    = e(Input::get('parent'));

		// Was the category updated?
		if($category->save())
		{
			// Redirect to the new category page
			return Redirect::to("admin/settings/categories/$categoryId/edit")->with('success', Lang::get('admin/categories/message.update.success'));
		}

		// Redirect to the category management page
		return Redirect::to("admin/settings/categories/$categoryID/edit")->with('error', Lang::get('admin/categories/message.update.error'));
	}

	/**
	 * Delete the given category.
	 *
	 * @param  int  $categoryId
	 * @return Redirect
	 */
	public function getDelete($categoryId)
	{
		// Check if the blog post exists
		if (is_null($category = Category::find($categoryId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.not_found'));
		}

		// Delete the blog post
		$category->delete();

		// Redirect to the blog posts management page
		return Redirect::to('admin/settings/categories')->with('success', Lang::get('admin/categories/message.delete.success'));
	}


}
