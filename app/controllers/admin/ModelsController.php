<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Model;
use Redirect;
use Sentry;
use DB;
use Depreciation;
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
		$models = Model::orderBy('created_at', 'DESC')->paginate(10);

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
		//$model_options = array('0' => 'Top Level') + Model::lists('name', 'id');
		//return View::make('backend/models/edit')->with('model_options',$model_options)->with('model',new Model);
		$depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
		return View::make('backend/models/edit')->with('depreciation_list',$depreciation_list)->with('model',new Model);
	}


	/**
	 * Model create form processing.
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

		// Create a new model
		$model = new Model;

		// Update the model data
		$model->name            = e(Input::get('name'));
		$model->modelno            = e(Input::get('modelno'));
		$model->depreciation_id    = e(Input::get('depreciation_id'));
		$model->user_id          = Sentry::getId();

		// Was the model created?
		if($model->save())
		{
			// Redirect to the new model  page
			return Redirect::to("assets/models")->with('success', Lang::get('admin/models/message.create.success'));
		}

		// Redirect to the model create page
		return Redirect::to('assets/models/create')->with('error', Lang::get('admin/models/message.create.error'));
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
			// Redirect to the blogs management page
			return Redirect::to('assets/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
		}

		// Show the page
		//$model_options = array('' => 'Top Level') + Model::lists('name', 'id');

		$model_options = array('' => 'Top Level') + DB::table('models')->where('id', '!=', $modelId)->lists('name', 'id');
		return View::make('backend/models/edit', compact('model'))->with('model_options',$model_options);
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
			// Redirect to the blogs management page
			return Redirect::to('admin/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
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

		// Update the model data
		$model->name            = e(Input::get('name'));
		$model->modelno            = e(Input::get('modelno'));
		$model->depreciation_id    = e(Input::get('depreciation_id'));

		// Was the model updated?
		if($model->save())
		{
			// Redirect to the new model page
			return Redirect::to("assets/models/$modelId/edit")->with('success', Lang::get('admin/models/message.update.success'));
		}

		// Redirect to the model management page
		return Redirect::to("assets/models/$modelId/edit")->with('error', Lang::get('admin/models/message.update.error'));
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
			return Redirect::to('assets/models')->with('error', Lang::get('admin/models/message.not_found'));
		}

		// Delete the model
		$model->delete();

		// Redirect to the models management page
		return Redirect::to('assets/models')->with('success', Lang::get('admin/models/message.delete.success'));
	}


}
