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
use Depreciation;
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
		// Show the page
		$depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
		return View::make('backend/licenses/edit')->with('license_options',$license_options)->with('depreciation_list',$depreciation_list)->with('license',new License);
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
			$license->depreciate 		= e(Input::get('depreciate'));
			$license->user_id 			= Sentry::getId();

			if (($license->purchase_date == "") || ($license->purchase_date == "0000-00-00")) {
				$license->purchase_date = NULL;
			}

			if (($license->purchase_cost == "") || ($license->purchase_cost == "0.00")) {
				$license->purchase_cost = NULL;
			}

			if ($license->depreciate == "") {
				$license->depreciate = 0;
			}


			// Was the license created?
			if($license->save())
			{
				$insertedId = $license->id;
				// Save the license seat data
				for ($x=0; $x<$license->seats; $x++) {
					$license_seat = new LicenseSeat();
					$license_seat->license_id 		= $insertedId;
					$license_seat->user_id 			= Sentry::getId();
					$license_seat->assigned_to 		= 0;
					$license_seat->notes 			= NULL;
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

			if ($license->purchase_date == "0000-00-00") {
				$license->purchase_date = NULL;
			}

			if ($license->purchase_cost == "0.00") {
				$license->purchase_cost = NULL;
			}

		// Show the page
		$license_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $licenseId)->lists('name', 'id');
		$depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
		return View::make('backend/licenses/edit', compact('license'))->with('license_options',$license_options)->with('depreciation_list',$depreciation_list);
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

			// Update the asset data
			if ( e(Input::get('purchase_date')) == '') {
					$license->purchase_date =  NULL;
			} else {
					$license->purchase_date = e(Input::get('purchase_date'));
			}

			if ( e(Input::get('purchase_cost')) == '') {
					$license->purchase_cost =  NULL;
			} else {
					$license->purchase_cost = e(Input::get('purchase_cost'));
			}


			//Are we changing the total number of seats?
			if( $license->seats != e(Input::get('seats')))
			{
				//Determine how many seats we are dealing with
				$difference = e(Input::get('seats')) - $license->licenseseats()->count();

				if( $difference < 0 )
				{
					//Filter out any license which have a user attached;
					$seats = $license->licenseseats->filter(function($seat)
					{
						return is_null($seat->user);
					});


					//If the remaining collection is as large or larger than the number of seats we want to delete
					if($seats->count() >= abs($difference))
					{
						for ($i=1; $i <= abs($difference); $i++) {
							//Delete the appropriate number of seats
							$seats->pop()->delete();
						}

						//Log the deletion of seats to the log
						$logaction = new Actionlog();
						$logaction->asset_id = $license->id;
						$logaction->asset_type = 'software';
						$logaction->user_id = Sentry::getUser()->id;
						$logaction->note = abs($difference)." seats";
						$logaction->checkedout_to =  NULL;
						$log = $logaction->logaction('delete seats');

					} else {
						// Redirect to the license edit page
						return Redirect::to("admin/licenses/$licenseId/edit")->with('error', Lang::get('admin/licenses/message.assoc_users'));
					}
				} else {

					for ($i=1; $i <= $difference; $i++) {
						//Create a seat for this license
						$license_seat = new LicenseSeat();
						$license_seat->license_id 		= $license->id;
						$license_seat->user_id 			= Sentry::getId();
						$license_seat->assigned_to 		= 0;
						$license_seat->notes 			= NULL;
						$license_seat->save();
					}

					//Log the addition of license to the log.
					$logaction = new Actionlog();
					$logaction->asset_id = $license->id;
					$logaction->asset_type = 'software';
					$logaction->user_id = Sentry::getUser()->id;
					$logaction->note = abs($difference)." seats";
					$log = $logaction->logaction('add seats');
				}
				$license->seats 			= e(Input::get('seats'));
			}

			// Was the asset created?
			if($license->save())
			{
				// Redirect to the new license page
				return Redirect::to("admin/licenses/$licenseId/view")->with('success', Lang::get('admin/licenses/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $license->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the license edit page
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
			// Redirect to the license management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}

		if (($license->assignedcount()) && ($license->assignedcount() > 0)) {

			// Redirect to the license management page
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.assoc_users'));

		} else {

			// Delete the license and the associated license seats
			$licenseseats = $license->licenseseats();
			$licenseseats->delete();
			$license->delete();


			// Redirect to the licenses management page
			return Redirect::to('admin/licenses')->with('success', Lang::get('admin/licenses/message.delete.success'));
		}


	}


	/**
	* Check out the asset to a person
	**/
	public function getCheckout($seatId)
	{
		// Check if the asset exists
		if (is_null($licenseseat = LicenseSeat::find($seatId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}

		// Get the dropdown of users and then pass it to the checkout view
		$users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->whereNull('deleted_at')->lists('full_name', 'id');

		//print_r($users);
		return View::make('backend/licenses/checkout', compact('licenseseat'))->with('users_list',$users_list);

	}



	/**
	* Check out the asset to a person
	**/
	public function postCheckout($seatId)
	{
		// Check if the asset exists
		if (is_null($licenseseat = LicenseSeat::find($seatId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}

		$assigned_to = e(Input::get('assigned_to'));

		// Declare the rules for the form validation
		$rules = array(
			'assigned_to'   => 'required|integer|min:1',
			'note'   => 'alpha_space',
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
		if ( e(Input::get('assigned_to')) == '') {
				$licenseseat->assigned_to =  NULL;
		} else {
				$licenseseat->assigned_to = e(Input::get('assigned_to'));
		}

		// Was the asset updated?
		if($licenseseat->save())
		{

			$logaction = new Actionlog();
			$logaction->asset_id = $licenseseat->license_id;
			$logaction->location_id = $assigned_to->location_id;
			$logaction->asset_type = 'software';
			$logaction->user_id = Sentry::getUser()->id;
			$logaction->note = e(Input::get('note'));


			// Update the asset data
			if ( e(Input::get('assigned_to')) == '') {
					$logaction->checkedout_to = NULL;
			} else {
					$logaction->checkedout_to = e(Input::get('assigned_to'));
			}

			$log = $logaction->logaction('checkout');


			// Redirect to the new asset page
			return Redirect::to("admin/licenses")->with('success', Lang::get('admin/licenses/message.checkout.success'));
		}

		// Redirect to the asset management page with error
		return Redirect::to('admin/licenses/$assetId/checkout')->with('error', Lang::get('admin/licenses/message.create.error'))->with('license',new License);
	}


	/**
	* Check the license back into inventory
	**/
	public function getCheckin($seatId)
	{
		// Check if the asset exists
		if (is_null($licenseseat = LicenseSeat::find($seatId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}
		return View::make('backend/licenses/checkin', compact('licenseseat'));

	}



	/**
	* Check in the item so that it can be checked out again to someone else
	**/
	public function postCheckin($seatId)
	{
		// Check if the asset exists
		if (is_null($licenseseat = LicenseSeat::find($seatId)))
		{
			// Redirect to the asset management page with error
			return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'note'   => 'alpha_space',
			'notes'   => 'alpha_space',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$logaction = new Actionlog();
		$logaction->checkedout_to = $licenseseat->assigned_to;

		// Update the asset data
		$licenseseat->assigned_to            		= '0';

		// Was the asset updated?
		if($licenseseat->save())
		{
			$logaction->asset_id = $licenseseat->license_id;
			$logaction->location_id = NULL;
			$logaction->asset_type = 'software';
			$logaction->note = e(Input::get('note'));
			$logaction->user_id = Sentry::getUser()->id;
			$log = $logaction->logaction('checkin from');

			// Redirect to the license page
			return Redirect::to("admin/licenses")->with('success', Lang::get('admin/licenses/message.checkin.success'));
		}

		// Redirect to the license page with error
		return Redirect::to("admin/licenses")->with('error', Lang::get('admin/licenses/message.checkin.error'));
	}

	/**
	*  Get the asset information to present to the asset view page
	*
	* @param  int  $assetId
	* @return View
	**/
	public function getView($licenseId = null)
	{
		$license = License::find($licenseId);

		if (isset($license->id)) {
				return View::make('backend/licenses/view', compact('license'));
		} else {
			// Prepare the error message
			$error = Lang::get('admin/licenses/message.does_not_exist', compact('id'));

			// Redirect to the user management page
			return Redirect::route('licenses')->with('error', $error);
		}
	}


}
