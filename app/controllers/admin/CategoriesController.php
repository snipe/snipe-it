<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Category;
use Redirect;
use Setting;
use DB;
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
		// Grab all the categories
		$categories = Category::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

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
		return View::make('backend/categories/edit')->with('category',new Category);
	}


	/**
	 * Category create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// create a new model instance
		$category = new Category();

		// attempt validation
		if ($category->validate($new))
		{

			// Update the category data
			$category->name            = e(Input::get('name'));
			$category->user_id          = Sentry::getId();

			// Was the asset created?
			if($category->save())
			{
				// Redirect to the new category  page
				return Redirect::to("admin/settings/categories")->with('success', Lang::get('admin/categories/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $category->errors();
			return Redirect::back()->withInput()->withErrors($errors);
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
			return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
		}

		// Show the page
		//$category_options = array('' => 'Top Level') + Category::lists('name', 'id');

		$category_options = array('' => 'Top Level') + DB::table('categories')->where('id', '!=', $categoryId)->lists('name', 'id');
		return View::make('backend/categories/edit', compact('category'))->with('category_options',$category_options);
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


		// get the POST data
		$new = Input::all();

		// attempt validation
		if ($category->validate($new))
		{

			// Update the category data
			$category->name            = e(Input::get('name'));

			// Was the asset created?
			if($category->save())
			{
				// Redirect to the new category page
				return Redirect::to("admin/settings/categories")->with('success', Lang::get('admin/categories/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $category->errors();
			return Redirect::back()->withInput()->withErrors($errors);
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


		if ($category->has_models() > 0) {

			// Redirect to the asset management page
			return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.assoc_users'));
		} else {

			$category->delete();

			// Redirect to the locations management page
			return Redirect::to('admin/settings/categories')->with('success', Lang::get('admin/categories/message.delete.success'));
		}


	}



}
