<?php namespace Controllers\Admin;

use Actionlog;
use AdminController;
use Asset;
use DB;
use Depreciation;
use Family;
use Input;
use Lang;
use License;
use LicenseSeat;
use Manufacturer;
use Redirect;
use Setting;
use Sentry;
use Supplier;
use User;
use Validator;
use View;
use Location;


class LicensesController extends AdminController
{
    /**
     * Show a list of all the licenses.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the licenses
        $licenses = License::orderBy('created_at', 'DESC');
        
        if (Input::get('withTrashed')) {
            $licenses = $licenses->withTrashed();    
        } elseif (Input::get('onlyTrashed')) {	
            $licenses = $licenses->onlyTrashed();  
        }
        
        $licenses = $licenses->paginate(Setting::getSettings()->per_page);  
        
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
        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $manufacturer_list = array('' => '') + Manufacturer::orderBy('name', 'asc')->lists('name', 'id');
        $family_list = array('' => '') + Family::orderBy('common_name', 'asc')->lists('common_name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');
        $service_agreement_list = array('' => '') + \ServiceAgreement::orderBy('name', 'asc')->lists('name', 'id');
        
        // Show the page
        $depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
        return View::make('backend/licenses/edit')
                ->with('license_options',$license_options)
                ->with('supplier_list',$supplier_list)
                ->with('family_list',$family_list)
                ->with('location_list',$location_list)
                ->with('manufacturer_list',$manufacturer_list)
                ->with('depreciation_list',$depreciation_list)
                ->with('service_agreement_list',$service_agreement_list)
                ->with('license',new License);
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
        if ($license->validate($new)) {

            // Save the license data
            $license->name 				= e(Input::get('name'));
            $license->serial 			= e(Input::get('serial'));
            $license->license_email 	= e(Input::get('license_email'));
            $license->license_name 		= e(Input::get('license_name'));
            $license->notes 			= e(Input::get('notes'));
            $license->order_number 		= e(Input::get('order_number'));
            $license->seats 			= e(Input::get('seats'));
            $license->purchase_date 	= e(Input::get('purchase_date'));
            $license->depreciation_id 	= e(Input::get('depreciation_id'));
            $license->user_id 			= Sentry::getId();
            
            // Values that need to be cleansed before saving
            
            if ( e(Input::get('purchase_cost')) == '') {
                    $license->purchase_cost =  NULL;
            } else {
                    $license->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
            }

            if ( e(Input::get('supplier_id')) == '') {
                    $license->supplier_id =  NULL;
            } else {
                    $license->supplier_id = e(Input::get('supplier_id'));
            }
            
            if ( e(Input::get('family_id')) == '') {
                    $license->family_id =  NULL;
            } else {
                    $license->family_id = e(Input::get('family_id'));
            }
            
            if ( e(Input::get('location_id')) == '') {
                    $license->location_id =  NULL;
            } else {
                    $license->location_id = e(Input::get('location_id'));
            }
            
            if ( e(Input::get('manufacturer_id')) == '') {
                    $license->manufacturer_id =  NULL;
            } else {
                    $license->manufacturer_id = e(Input::get('manufacturer_id'));
            }

            if (($license->purchase_date == "") || ($license->purchase_date == "0000-00-00")) {
                $license->purchase_date = NULL;
            }

            if (($license->purchase_cost == "") || ($license->purchase_cost == "0.00")) {
                $license->purchase_cost = NULL;
            }
            
            if (e(Input::get('service_agreement_id')) == '') {
                $license->service_agreement_id =  0;
            } else {
                $license->service_agreement_id        = e(Input::get('service_agreement_id'));
            }

            // Was the license created?
            if($license->save()) {
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
        } else {
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
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.does_not_exist'));
        }

            if ($license->purchase_date == "0000-00-00") {
                $license->purchase_date = NULL;
            }

            if ($license->purchase_cost == "0.00") {
                $license->purchase_cost = NULL;
            }

        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $manufacturer_list = array('' => '') + Manufacturer::orderBy('name', 'asc')->lists('name', 'id');
        $family_list = array('' => '') + Family::orderBy('common_name', 'asc')->lists('common_name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');
        $service_agreement_list = array('' => '') + \ServiceAgreement::orderBy('name', 'asc')->lists('name', 'id');
        
        // Show the page
        $license_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $licenseId)->lists('name', 'id');
        $depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
        return View::make('backend/licenses/edit', compact('license'))
                ->with('license_options',$license_options)
                ->with('supplier_list',$supplier_list)
                ->with('family_list',$family_list)
                ->with('location_list',$location_list)
                ->with('manufacturer_list',$manufacturer_list)
                ->with('service_agreement_list',$service_agreement_list)
                ->with('depreciation_list',$depreciation_list);
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
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.does_not_exist'));
        }

        // get the POST data
        $new = Input::all();

        // attempt validation
        $validator = Validator::make(Input::all(), $license->validationRules($licenseId));

        if ($validator->fails())
        {
            // The given data did not pass validation            
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        //  validation succeeds
        else {
        
            // Update the license data
            $license->name 			= e(Input::get('name'));
            $license->serial 			= e(Input::get('serial'));
            $license->license_email             = e(Input::get('license_email'));
            $license->license_name 		= e(Input::get('license_name'));
            $license->notes 			= e(Input::get('notes'));
            $license->order_number 		= e(Input::get('order_number'));
            $license->depreciation_id           = e(Input::get('depreciation_id'));
            
            // Values that need to be cleansed before saving
            
            if ( e(Input::get('purchase_date')) == '') {
                    $license->purchase_date =  NULL;
            } else {
                    $license->purchase_date = e(Input::get('purchase_date'));
            }

            if ( e(Input::get('purchase_cost')) == '') {
                    $license->purchase_cost =  NULL;
            } else {
                    $license->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
            }

            if ( e(Input::get('supplier_id')) == '') {
                    $license->supplier_id =  NULL;
            } else {
                    $license->supplier_id = e(Input::get('supplier_id'));
            }

            if ( e(Input::get('family_id')) == '') {
                    $license->family_id =  NULL;
            } else {
                    $license->family_id = e(Input::get('family_id'));
            }
                    
            if ( e(Input::get('location_id')) == '') {
                    $license->location_id =  NULL;
            } else {
                    $license->location_id = e(Input::get('location_id'));
            }           
            
            if ( e(Input::get('manufacturer_id')) == '') {
                    $license->manufacturer_id =  NULL;
            } else {
                    $license->manufacturer_id = e(Input::get('manufacturer_id'));
            }
            
            if (e(Input::get('service_agreement_id')) == '') {
                $license->service_agreement_id =  0;
            } else {
                $license->service_agreement_id        = e(Input::get('service_agreement_id'));
            }

            //Are we changing the total number of seats?
            if( $license->seats != e(Input::get('seats'))) {
                //Determine how many seats we are dealing with
                $difference = e(Input::get('seats')) - $license->licenseseats()->count();

                if( $difference < 0 ) {
                    //Filter out any license which have a user attached;
                    $seats = $license->licenseseats->filter(function ($seat) {
                        return is_null($seat->user);
                    });


                    //If the remaining collection is as large or larger than the number of seats we want to delete
                    if($seats->count() >= abs($difference)) {
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
            if($license->save()) {
                // Redirect to the new license page
                return Redirect::to("admin/licenses/$licenseId/view")->with('success', Lang::get('admin/licenses/message.update.success'));
            }
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
        if (is_null($license = License::withTrashed()->find($licenseId))) {
            // Redirect to the license management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }

        if (($license->assignedcount()) && ($license->assignedcount() > 0)) {

            // Redirect to the license management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.assoc_users'));

        } else {
            $licenseseats = $license->licenseseats();
            
            if($license->trashed())
            {                
                $licenseseats->forceDelete();
                $license->forceDelete();
               
            } else {
                // Delete the license and the associated license seats                
                $licenseseats->delete();
                $license->delete();
            }

            // Redirect to the licenses management page
            return Redirect::to('admin/licenses')->with('success', $license ? Lang::get('message.delete.success') : Lang::get('message.purge.success'));
        }


    }
    
    public function getRestore($licenseId)
    {
    
        if (is_null($license = License::withTrashed()->find($licenseId))) {
            // Redirect to the license management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }
        
        $license->restore();
        
        
        LicenseSeat::withTrashed()->where('license_id', $license->id)->restore();
        
        
        return Redirect::to('admin/licenses')->with('success', Lang::get('message.restore.success'));
    }
    
    public function getPurge()
    {
        //delete all licenses
        $licenses=License::onlyTrashed()->forceDelete();
        
        //delete all seats
        $licenceseats=LicenseSeat::onlyTrashed()->forceDelete();
        
        return Redirect::to('admin/licenses')->with('success', 'Purge Submitted');
    }

    /**
    * Check out the asset to a person
    **/
    public function getCheckout($seatId)
    {
        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->whereNull('deleted_at')->lists('full_name', 'id');

		// Left join to get a list of assets and some other helpful info
		$asset = DB::table('assets')
			->leftJoin('users', 'users.id', '=', 'assets.assigned_to')
			->select('assets.id', 'name', 'first_name', 'last_name','asset_tag',
			DB::raw('concat (first_name," ",last_name) as full_name, assets.id as id'))
			->whereNull('assets.deleted_at')
			->get();

			$asset_array = json_decode(json_encode($asset), true);
			$asset_element[''] = 'Please select an asset';

			// Build a list out of the data results
			for ($x=0; $x<count($asset_array); $x++) {

				if ($asset_array[$x]['full_name']!='') {
					$full_name = ' ('.$asset_array[$x]['full_name'].')';
				} else {
					$full_name = ' (Unassigned)';
				}
				$asset_element[$asset_array[$x]['id']] = $asset_array[$x]['asset_tag'].' - '.$asset_array[$x]['name'].$full_name;

			}

        return View::make('backend/licenses/checkout', compact('licenseseat'))->with('users_list',$users_list)->with('asset_list',$asset_element);

    }

    /**
    * Check out the asset to a person
    **/
    public function postCheckout($seatId)
    {


        $assigned_to = e(Input::get('assigned_to'));
        $asset_id = e(Input::get('asset_id'));

        // Declare the rules for the form validation
        $rules = array(

            'note'   => 'alpha_space',
//            'asset_id'	=> 'required_without:assigned_to:min:1',
            'asset_id'	=> 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

		if ($assigned_to!='') {
        // Check if the user exists
			if (is_null($is_assigned_to = User::find($assigned_to))) {
				// Redirect to the asset management page with error
				return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.user_does_not_exist'));
			}
        }

        if ($asset_id!='') {

			if (is_null($is_asset_id = Asset::find($asset_id))) {
				// Redirect to the asset management page with error
				return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.asset_does_not_exist'));
			}

			if (($is_asset_id->assigned_to!=$assigned_to) && ($assigned_to!=''))  {
				//echo 'asset assigned to: '.$is_asset_id->assigned_to.'<br>license assigned to: '.$assigned_to;
				return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.owner_doesnt_match_asset'));
			}

        }



        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }

	$licenseseat->asset_id = e(Input::get('asset_id'));

        // Update the asset data
        if ( e(Input::get('assigned_to')) == '') {
                $licenseseat->assigned_to =  NULL;

        } else {
                $licenseseat->assigned_to = e(Input::get('assigned_to'));
        }

        // Was the asset updated?
        if($licenseseat->save()) {

            $logaction = new Actionlog();

            //$logaction->location_id = $assigned_to->location_id;
            $logaction->asset_type = 'software';
            $logaction->user_id = Sentry::getUser()->id;
            $logaction->note = e(Input::get('note'));
            $logaction->asset_id = $licenseseat->license->id;

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
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
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
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
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
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $logaction = new Actionlog();
        $logaction->checkedout_to = $licenseseat->assigned_to;     
        $logaction->asset_id = $licenseseat->license->id;
        
        // Was the asset updated?
        if($licenseseat->checkin()) {
            $logaction->asset_id = $licenseseat->license->id;
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

    public function getClone($licenseId = null)
    {
         // Check if the license exists
        if (is_null($license_to_clone = License::find($licenseId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.does_not_exist'));
        }

          // Show the page
        $license_options = array('0' => 'Top Level') + License::lists('name', 'id');
        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $manufacturer_list = array('' => '') + Manufacturer::orderBy('name', 'asc')->lists('name', 'id');
        $family_list = array('' => '') + Family::orderBy('common_name', 'asc')->lists('common_name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');
        
        //clone the orig
        $license = clone $license_to_clone;
        $license->id = null;
        $license->serial = null;

        // Show the page
        $depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
        return View::make('backend/licenses/edit')
                ->with('license_options',$license_options)
                ->with('supplier_list',$supplier_list)
                ->with('family_list',$family_list)     
                ->with('location_list',$location_list)
                ->with('manufacturer_list',$manufacturer_list)
                ->with('depreciation_list',$depreciation_list)
                ->with('clone_license',$license_to_clone)
                ->with('license',$license);

    }
    
}
