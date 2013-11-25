<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use License;
use Asset;
use User;
use Actionlog;
use DB;
use Redirect;
use LicenseSeat;
use Setting;
use Sentry;
use Str;
use Validator;
use View;

class LicensesController extends AdminController {

	/**
	 * Show a list of all the licenses.
	 *
	 * @return View
	 */

	public function getIndex()
	{
		// Grab all the licenses
		$licenses = License::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

		// Show the page
		return View::make('backend/licenses/index', compact('licenses'));
	}


	/**
	 * License create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		$license_options = array('0' => 'Top Level') + License::lists('name', 'id');
		return View::make('backend/licenses/edit')->with('license_options',$license_options)->with('license',new License);
	}


	/**
	 * License create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{


		// get the POST data
		$new = Input::all();

		// create a new model instance
		$license = new License();

		// attempt validation
		if ($license->validate($new))
		{

			// Save the license data
			$license->name 				= e(Input::get('name'));
			$license->serial 			= e(Input::get('serial'));
			$license->license_email 	= e(Input::get('license_email'));
			$license->license_name 		= e(Input::get('license_name'));
			$license->notes 			= e(Input::get('notes'));
			$license->order_number 		= e(Input::get('order_number'));
			$license->seats 			= e(Input::get('seats'));
			$license->purchase_date 	= e(Input::get('purchase_date'));
			$license->purchase_cost 	= e(Input::get('purchase_cost'));
			$license->user_id 			= Sentry::getId();





			// Was the license created?
			if($license->save())
			{
				$insertedId = $license->id;
				// Save the license seat data
				for ($x=0; $x<$license->seats; $x++) {
					$license_seat = new LicenseSeat();
					$license_seat->license_id 		= $insertedId;
					$license_seat->user_id 			= Sentry::getId();
					$license_seat->save();
				}


				// Redirect to the new license page
				return Redirect::to("admin/licenses")->with('success', Lang::get('admin/licenses/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $license->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the license create page
		return Redirect::to('admin/licenses/edit')->with('error', Lang::get('admin/licenses/message.create.error'))->with('license',new License);

	}

	/**
	 * License update.
	 *
	 * @param  int  $licenseId
	 * @return View
	 */
	public function getEdit($licenseId = null)
	{
		// Check if the license exists
		if (is_null($license = License::find($licenseId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.does_not_exist'));
		}

		// Show the page
		$license_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $licenseId)->lists('name', 'id');
		return View::make('backend/licenses/edit', compact('license'))->with('license_options',$license_options);
	}


	/**
	 * License update form processing page.
	 *
	 * @param  int  $licenseId
	 * @return Redirect
	 */
	public function postEdit($licenseId = null)
	{
		// Check if the license exists
		if (is_null($license = License::find($licenseId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.does_not_exist'));
		}


		// get the POST data
		$new = Input::all();


		// attempt validation
		if ($license->validate($new))
		{

			// Update the license data
			$license->name 				= e(Input::get('name'));
			$license->serial 			= e(Input::get('serial'));
			$license->license_email 	= e(Input::get('license_email'));
			$license->license_name 		= e(Input::get('license_name'));
			$license->notes 			= e(Input::get('notes'));
			$license->order_number 		= e(Input::get('order_number'));
			$license->purchase_date 	= e(Input::get('purchase_date'));
			$license->purchase_cost 	= e(Input::get('purchase_cost'));


			// Was the asset created?
			if($license->save())
			{
				// Redirect to the new license page
				return Redirect::to("admin/licenses/$licenseId/edit")->with('success', Lang::get('admin/licenses/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $license->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the category create page
		return Redirect::to("admin/licenses/$licenseId/edit")->with('error', Lang::get('admin/licenses/message.update.error'));

	}

	/**
	 * Delete the given license.
	 *
	 * @param  int  $licenseId
	 * @return Redirect
	 */
	public function getDelete($licenseId)
	{
		// Check if the license exists
		if (is_null($license = License::find($licenseId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}

		if (isset($license->assigneduser->id) && ($license->assigneduser->id!=0)) {
			// Redirect to the asset management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.assoc_users'));
		} else {
			// Delete the license
			$license->delete();

			// Redirect to the licenses management page
			return Redirect::to('admin/licenses')->with('success', Lang::get('admin/licenses/message.delete.success'));
		}


	}


	/**
	* Check out the asset to a person
	**/
	public function getCheckout($assetId)
	{
		// Check if the asset exists
		if (is_null($license = License::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		// Get the dropdown of users and then pass it to the checkout view
		$users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->lists('full_name', 'id');

		//print_r($users);
		return View::make('backend/licenses/checkout', compact('license'))->with('users_list',$users_list);

	}



		/**
	* Check out the asset to a person
	**/
	public function postCheckout($assetId)
	{
		// Check if the asset exists
		if (is_null($license = License::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/assets/message.not_found'));
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
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.user_does_not_exist'));
		}


		// Update the asset data
		$license->assigned_to            		= e(Input::get('assigned_to'));


		// Was the asset updated?
		if($license->save())
		{
			$logaction = new Actionlog();
			$logaction->asset_id = $license->id;
			$logaction->checkedout_to = $license->assigned_to;
			$logaction->location_id = $assigned_to->location_id;
			$logaction->user_id = Sentry::getUser()->id;
			$log = $logaction->logaction('checkout');

			// Redirect to the new asset page
			return Redirect::to("admin/licenses")->with('success', Lang::get('admin/licenses/message.checkout.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to('admin/licenses/$assetId/checkout')->with('error', Lang::get('admin/licenses/message.create.error'))->with('license',new License);
	}

	/**
	* Check in the item so that it can be checked out again to someone else
	**/
	public function postCheckin($assetId)
	{
		// Check if the asset exists
		if (is_null($license = License::find($assetId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/assets/message.not_found'));
		}

		$logaction = new Actionlog();
		$logaction->checkedout_to = $license->assigned_to;

		// Update the asset data
		$license->assigned_to            		= '';

		// Was the asset updated?
		if($license->save())
		{
			$logaction->asset_id = $license->id;

			$logaction->location_id = NULL;
			$logaction->user_id = Sentry::getUser()->id;
			$log = $logaction->logaction('checkin from');

			// Redirect to the new asset page
			return Redirect::to("admin/licenses")->with('success', Lang::get('admin/licenses/message.checkout.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to("admin/licenses")->with('error', Lang::get('admin/licenses/message.checkout.error'));
	}

	/**
	*  Get the asset information to present to the asset view page
	*
	* @param  int  $assetId
	* @return View
	**/
	public function getView($licenseId = null)
	{
		$license = Asset::find($licenseId);

		if (isset($license->id)) {
				return View::make('backend/licenses/view', compact('license'));
		} else {
			// Prepare the error message
			$error = Lang::get('admin/licenses/message.does_not_exist', compact('id' ));

			// Redirect to the user management page
			return Redirect::route('licenses')->with('error', $error);
		}


	}



}
