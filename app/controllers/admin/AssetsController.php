<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Asset;
use Redirect;
use DB;
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
		$assets = Asset::orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('backend/assets/index', compact('assets'));
	}


	/**
	 * Asset create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		$asset_options = array('0' => 'Top Level') + Asset::lists('name', 'id');
		return View::make('backend/assets/create')->with('asset_options',$asset_options);
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
			'asset_tag'   => 'required|min:3',
			'model_id'   => 'required|min:1',
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

		// Update the asset data
		// Update the asset data
		$asset->name            		= e(Input::get('name'));
		$asset->serial            		= e(Input::get('serial'));
		$asset->model_id           		= e(Input::get('model_id'));
		$asset->purchase_date            = e(Input::get('purchase_date'));
		$asset->purchase_cost            = e(Input::get('purchase_cost'));
		$asset->order_number            = e(Input::get('order_number'));
		$asset->notes            		= e(Input::get('notes'));
		$asset->asset_tag            = e(Input::get('asset_tag'));
		$asset->user_id          		= Sentry::getId();


		// Was the asset created?
		if($asset->save())
		{
			// Redirect to the new asset  page
			return Redirect::to("assets/assets")->with('success', Lang::get('admin/assets/message.create.success'));
		}

		// Redirect to the asset create page
		return Redirect::to('assets/assets/create')->with('error', Lang::get('admin/assets/message.create.error'));
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
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/assets')->with('error', Lang::get('admin/assets/message.does_not_exist'));
		}

		// Show the page
		//$asset_options = array('' => 'Top Level') + Asset::lists('name', 'id');

		$asset_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $assetId)->lists('name', 'id');
		return View::make('backend/assets/edit', compact('asset'))->with('asset_options',$asset_options);
	}


	/**
	 * Asset update form processing page.
	 *
	 * @param  int  $assetId
	 * @return Redirect
	 */
	public function postEdit($assetId = null)
	{
		// Check if the blog post exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/assets')->with('error', Lang::get('admin/assets/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'asset_tag'   => 'required|min:3',
			'model_id'   => 'required|min:1',
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
		$asset->purchase_date            = e(Input::get('purchase_date'));
		$asset->purchase_cost            = e(Input::get('purchase_cost'));
		$asset->order_number            = e(Input::get('order_number'));
		$asset->asset_tag            = e(Input::get('asset_tag'));
		$asset->notes            		= e(Input::get('notes'));


		// Was the asset updated?
		if($asset->save())
		{
			// Redirect to the new asset page
			return Redirect::to("assets/assets/$assetId/edit")->with('success', Lang::get('admin/assets/message.update.success'));
		}

		// Redirect to the asset management page
		return Redirect::to("assets/assets/$assetID/edit")->with('error', Lang::get('admin/assets/message.update.error'));
	}

	/**
	 * Delete the given asset.
	 *
	 * @param  int  $assetId
	 * @return Redirect
	 */
	public function getDelete($assetId)
	{
		// Check if the blog post exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('assets/assets')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		// Delete the blog post
		$asset->delete();

		// Redirect to the blog posts management page
		return Redirect::to('assets/assets')->with('success', Lang::get('admin/assets/message.delete.success'));
	}



}
