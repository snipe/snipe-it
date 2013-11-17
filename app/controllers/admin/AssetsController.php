<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Asset;
use Redirect;
use DB;
use Model;
use Depreciation;
use Sentry;
use Str;
use Validator;
use View;

class AssetsController extends AdminController {

	/**
	 * Show a list of all the assets.
	 *
	 * @return View
	 */

	public function getIndex()
	{
		// Grab all the assets
		$assets = Asset::orderBy('created_at', 'DESC')->where('physical', '=', 1)->paginate(10);
		return View::make('backend/assets/index', compact('assets'));
	}


	/**
	 * Asset create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Grab the dropdown list of models
		$model_list = array('' => 'Select') + Model::lists('name', 'id');
		$depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');

		return View::make('backend/assets/edit')->with('model_list',$model_list)->with('depreciation_list',$depreciation_list)->with('asset',new Asset);

	}


	/**
	 * Asset create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'asset_tag'   => 'required|min:3|unique:assets',
			'model_id'   => 'required',
			'serial'   => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Create a new asset
		$asset = new Asset;

		// Save the asset data
		$asset->name            		= e(Input::get('name'));
		$asset->serial            		= e(Input::get('serial'));
		$asset->model_id           		= e(Input::get('model_id'));
		$asset->purchase_date           = e(Input::get('purchase_date'));
		$asset->purchase_cost           = e(Input::get('purchase_cost'));
		$asset->order_number            = e(Input::get('order_number'));
		$asset->notes            		= e(Input::get('notes'));
		$asset->asset_tag            	= e(Input::get('asset_tag'));
		$asset->user_id          		= Sentry::getId();


		// Was the asset created?
		if($asset->save())
		{
			// Redirect to the asset listing page
			return Redirect::to("admin")->with('success', Lang::get('admin/assets/message.create.success'));
		}

		// Redirect to the asset create page with an error
		return Redirect::to('assets/create')->with('error', Lang::get('admin/assets/message.create.error'));
	}

	/**
	 * Asset update.
	 *
	 * @param  int  $assetId
	 * @return View
	 */
	public function getEdit($assetId = null)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.does_not_exist'));
		}

		// Grab the dropdown list of models
		$model_list = array('' => 'Select') + Model::lists('name', 'id');

		// get depreciation list
		$depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
		return View::make('backend/assets/edit', compact('asset'))->with('model_list',$model_list)->with('depreciation_list',$depreciation_list);
	}


	/**
	 * Asset update form processing page.
	 *
	 * @param  int  $assetId
	 * @return Redirect
	 */
	public function postEdit($assetId = null)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'asset_tag'   => 'required|min:3',
			'model_id'   => 'required',
			'serial'   => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the asset data
		$asset->name            		= e(Input::get('name'));
		$asset->serial            		= e(Input::get('serial'));
		$asset->model_id           		= e(Input::get('model_id'));
		$asset->purchase_date           = e(Input::get('purchase_date'));
		$asset->purchase_cost           = e(Input::get('purchase_cost'));
		$asset->order_number            = e(Input::get('order_number'));
		$asset->asset_tag           	= e(Input::get('asset_tag'));
		$asset->notes            		= e(Input::get('notes'));


		// Was the asset updated?
		if($asset->save())
		{
			// Redirect to the new asset page
			return Redirect::to("assets/$assetId/edit")->with('success', Lang::get('admin/assets/message.update.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to("assets/$assetId/edit")->with('error', Lang::get('admin/assets/message.update.error'));
	}

	/**
	 * Delete the given asset.
	 *
	 * @param  int  $assetId
	 * @return Redirect
	 */
	public function getDelete($assetId)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		// Delete the asset
		$asset->delete();

		// Redirect to the asset management page
		return Redirect::to('admin')->with('success', Lang::get('admin/assets/message.delete.success'));
	}


}
