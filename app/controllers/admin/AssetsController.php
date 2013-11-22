<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Asset;
use Statuslabel;
use User;
use Redirect;
use DB;
use Actionlog;
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

		// Filter results
		if (Input::get('Pending'))
		{
			$assets = Asset::orderBy('asset_tag', 'ASC')->whereNull('status_id','and')->where('assigned_to','=','0')->where('physical', '=', 1);
		}
		else if (Input::get('RTD'))
		{
			$assets = Asset::orderBy('asset_tag', 'ASC')->where('status_id', '=', 0)->where('assigned_to','=','0')->where('physical', '=', 1);
		}
		else if (Input::get('Undeployable'))
		{
			$assets = Asset::orderBy('asset_tag', 'ASC')->where('status_id', '>', 1)->where('physical', '=', 1);
		}
		else if (Input::get('Deployed'))
		{
			$assets = Asset::orderBy('asset_tag', 'ASC')->where('status_id', '=', 0)->where('assigned_to','>','0')->where('physical', '=', 1);
		}
		else
		{
			$assets = Asset::orderBy('asset_tag', 'ASC')->where('physical', '=', 1);
		}

		// Paginate the users
		$assets = $assets->paginate(10)
			->appends(array(
				'Pending' => Input::get('Pending'),
				'RTD' => Input::get('RTD'),
				'Undeployable' => Input::get('Undeployable'),
				'Deployed' => Input::get('Deployed'),
			));

		return View::make('backend/assets/index', compact('assets'));
	}

	public function getReports()
	{
		// Grab all the assets
		$assets = Asset::orderBy('created_at', 'DESC')->get();
		return View::make('backend/reports/index', compact('assets'));
	}

	/**
	 * Asset create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Grab the dropdown list of models
		$model_list = array('' => '') + Model::lists('name', 'id');
		$depreciation_list = array('' => '') + Depreciation::lists('name', 'id');

		// Grab the dropdown list of status
		$statuslabel_list = array('' => 'Ready to Deploy') + Statuslabel::lists('name', 'id');

		return View::make('backend/assets/edit')->with('model_list',$model_list)->with('statuslabel_list',$statuslabel_list)->with('depreciation_list',$depreciation_list)->with('asset',new Asset);

	}


	/**
	 * Asset create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// create a new model instance
		$asset = new Asset();

		// attempt validation
		if ($asset->validate($new))
		{

			// Save the asset data
			$asset->name            		= e(Input::get('name'));
			$asset->serial            		= e(Input::get('serial'));
			$asset->model_id           		= e(Input::get('model_id'));
			$asset->purchase_date           = e(Input::get('purchase_date'));
			$asset->purchase_cost           = e(Input::get('purchase_cost'));
			$asset->order_number            = e(Input::get('order_number'));
			$asset->notes            		= e(Input::get('notes'));
			$asset->asset_tag            	= e(Input::get('asset_tag'));
			$asset->status_id            	= e(Input::get('status_id'));
			$asset->user_id          		= Sentry::getId();
			$asset->physical            		= '1';


			// Was the asset created?
			if($asset->save())
			{
				// Redirect to the asset listing page
				return Redirect::to("admin")->with('success', Lang::get('admin/assets/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $asset->errors();
			return Redirect::back()->withInput()->withErrors($errors);
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
		$model_list = array('' => '') + Model::lists('name', 'id');

		// Grab the dropdown list of status
		$statuslabel_list = array('' => '') + Statuslabel::lists('name', 'id');

		// get depreciation list
		$depreciation_list = array('' => '') + Depreciation::lists('name', 'id');

		return View::make('backend/assets/edit', compact('asset'))->with('model_list',$model_list)->with('depreciation_list',$depreciation_list)->with('statuslabel_list',$statuslabel_list);
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
			$asset->status_id            	= e(Input::get('status_id'));
			$asset->notes            		= e(Input::get('notes'));
			$asset->physical            		= '1';

			// Was the asset updated?
			if($asset->save())
			{
				// Redirect to the new asset page
				return Redirect::to("admin")->with('success', Lang::get('admin/assets/message.update.success'));
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

		if (isset($asset->assigneduser->id) && ($asset->assigneduser->id!=0)) {
			// Redirect to the asset management page
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.assoc_users'));
		} else {
			// Delete the asset
			$asset->delete();

			// Redirect to the asset management page
			return Redirect::to('admin')->with('success', Lang::get('admin/assets/message.delete.success'));
		}



	}

	/**
	* Check out the asset to a person
	**/
	public function getCheckout($assetId)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		// Get the dropdown of users and then pass it to the checkout view
		$users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->lists('full_name', 'id');




		//print_r($users);
		return View::make('backend/assets/checkout', compact('asset'))->with('users_list',$users_list);

	}

	/**
	* Check out the asset to a person
	**/
	public function postCheckout($assetId)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		$assigned_to = e(Input::get('assigned_to'));


		// Declare the rules for the form validation
		$rules = array(
			'assigned_to'   => 'required|min:1'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}


		// Check if the user exists
		if (is_null($assigned_to = User::find($assigned_to)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.user_does_not_exist'));
		}

		// Update the asset data
		$asset->assigned_to            		= e(Input::get('assigned_to'));

		// Was the asset updated?
		if($asset->save())
		{
			$logaction = new Actionlog();
			$logaction->asset_id = $asset->id;
			$logaction->checkedout_to = $asset->assigned_to;
			$logaction->location_id = $assigned_to->location_id;
			$logaction->user_id = Sentry::getUser()->id;
			$log = $logaction->logaction('checkout');



			// Redirect to the new asset page
			return Redirect::to("admin")->with('success', Lang::get('admin/assets/message.checkout.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to("assets/$assetId/checkout")->with('error', Lang::get('admin/assets/message.checkout.error'));
	}

	/**
	* Check in the item so that it can be checked out again to someone else
	*
	* @param  int  $assetId
	* @return View
	**/
	public function postCheckin($assetId)
	{
		// Check if the asset exists
		if (is_null($asset = Asset::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		if (!is_null($asset->assigned_to)) {
		 	$user = User::find($asset->assigned_to);
		}

		$logaction = new Actionlog();
		$logaction->checkedout_to = $asset->assigned_to;

		// Update the asset data to null, since it's being checked in
		$asset->assigned_to            		= '';

		// Was the asset updated?
		if($asset->save())
		{

			$logaction->asset_id = $asset->id;

			$logaction->location_id = NULL;
			$logaction->user_id = Sentry::getUser()->id;
			$log = $logaction->logaction('checkin from');

			// Redirect to the new asset page
			return Redirect::to("admin")->with('success', Lang::get('admin/assets/message.checkin.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to("admin")->with('error', Lang::get('admin/assets/message.checkin.error'));
	}


	/**
	*  Get the asset information to present to the asset view page
	*
	* @param  int  $assetId
	* @return View
	**/
	public function getView($assetId = null)
	{
		$asset = Asset::find($assetId);

		if (isset($asset->id)) {
				return View::make('backend/assets/view', compact('asset'));
		} else {
			// Prepare the error message
			$error = Lang::get('admin/assets/message.does_not_exist', compact('id' ));

			// Redirect to the user management page
			return Redirect::route('assets')->with('error', $error);
		}


	}



}
