<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Model;
use Redirect;
use Setting;
use Sentry;
use DB;
use Depreciation;
use Manufacturer;
use Str;
use Validator;
use View;

class ModelsController extends AdminController {

	/**
	 * Show a list of all the models.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the models
		$models = Model::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

		// Show the page
		return View::make('backend/models/index', compact('models'));
	}

/**
	 * Model create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		$depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
		$manufacturer_list = array('' => 'Select One') + Manufacturer::lists('name', 'id');
		$category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
		$view = View::make('backend/models/edit');
		$view->with('category_list',$category_list);
		$view->with('depreciation_list',$depreciation_list);
		$view->with('manufacturer_list',$manufacturer_list);
		$view->with('model',new Model);
		return $view;
	}


	/**
	 * Model create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// Create a new manufacturer
		$model = new Model;

		// attempt validation
		if ($model->validate($new))
		{

			// Save the model data
			$model->name            	= e(Input::get('name'));
			$model->modelno            	= e(Input::get('modelno'));
			$model->depreciation_id    	= e(Input::get('depreciation_id'));
			$model->manufacturer_id    	= e(Input::get('manufacturer_id'));
			$model->category_id    		= e(Input::get('category_id'));
			$model->user_id          	= Sentry::getId();
			$model->eol    				= e(Input::get('eol'));


			// Was it created?
			if($model->save())
			{
				// Redirect to the new model  page
				return Redirect::to("hardware/models")->with('success', Lang::get('admin/models/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $model->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the model create page
		return Redirect::to('hardware/models/create')->with('error', Lang::get('admin/models/message.create.error'));

	}

	/**
	 * Model update.
	 *
	 * @param  int  $modelId
	 * @return View
	 */
	public function getEdit($modelId = null)
	{
		// Check if the model exists
		if (is_null($model = Model::find($modelId)))
		{
			// Redirect to the model management page
			return Redirect::to('assets/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
		}

		$depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
		$manufacturer_list = array('' => 'Select One') + Manufacturer::lists('name', 'id');
		$category_list = array('' => '') + DB::table('categories')->lists('name', 'id');
		$view = View::make('backend/models/edit', compact('model'));
		$view->with('category_list',$category_list);
		$view->with('depreciation_list',$depreciation_list);
		$view->with('manufacturer_list',$manufacturer_list);
		return $view;
	}


	/**
	 * Model update form processing page.
	 *
	 * @param  int  $modelId
	 * @return Redirect
	 */
	public function postEdit($modelId = null)
	{
		// Check if the model exists
		if (is_null($model = Model::find($modelId)))
		{
			// Redirect to the models management page
			return Redirect::to('admin/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
		}

		// get the POST data
		$new = Input::all();

		// attempt validation
		if ($model->validate($new))
		{

			// Update the model data
			$model->name            	= e(Input::get('name'));
			$model->modelno            	= e(Input::get('modelno'));
			$model->depreciation_id    	= e(Input::get('depreciation_id'));
			$model->manufacturer_id    	= e(Input::get('manufacturer_id'));
			$model->category_id    		= e(Input::get('category_id'));
			$model->eol    				= e(Input::get('eol'));


			// Was it created?
			if($model->save())
			{
				// Redirect to the new model  page
				return Redirect::to("hardware/models")->with('success', Lang::get('admin/models/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $model->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the model create page
		return Redirect::to("hardware/models/$modelId/edit")->with('error', Lang::get('admin/models/message.update.error'));

	}

	/**
	 * Delete the given model.
	 *
	 * @param  int  $modelId
	 * @return Redirect
	 */
	public function getDelete($modelId)
	{
		// Check if the model exists
		if (is_null($model = Model::find($modelId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('hardware/models')->with('error', Lang::get('admin/models/message.not_found'));
		}

		if ($model->assets->count() > 0) {
			// Throw an error that this model is associated with assets
			return Redirect::to('hardware/models')->with('error', Lang::get('admin/models/message.assoc_users'));

		} else {
			// Delete the model
			$model->delete();

			// Redirect to the models management page
			return Redirect::to('hardware/models')->with('success', Lang::get('admin/models/message.delete.success'));
		}
	}


	/**
	*  Get the asset information to present to the model view page
	*
	* @param  int  $assetId
	* @return View
	**/
	public function getView($modelId = null)
	{
		$model = Model::find($modelId);

		if (isset($model->id)) {
				return View::make('backend/models/view', compact('model'));
		} else {
			// Prepare the error message
			$error = Lang::get('admin/models/message.does_not_exist', compact('id'));

			// Redirect to the user management page
			return Redirect::route('models')->with('error', $error);
		}


	}


}
