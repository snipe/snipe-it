<?php namespace Controllers\Admin;

use Assets;
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
use Supplier;
use Validator;
use View;
use Response;
use Datatable;

class LicensesController extends AdminController
{
    /**
     * Show a list of all the licenses.
     *
     * @return View
     */




    public function getIndex()
    {
        // Show the page
        return View::make('backend/licenses/index');
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
        $supplier_list = array('' => 'Select Supplier') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');
        return View::make('backend/licenses/edit')
            ->with('license_options',$license_options)
            ->with('depreciation_list',$depreciation_list)
            ->with('supplier_list',$supplier_list)
            ->with('maintained_list',$maintained_list)
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

            if ( e(Input::get('purchase_cost')) == '') {
                    $license->purchase_cost =  NULL;
            } else {
                    $license->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
                    //$license->purchase_cost = e(Input::get('purchase_cost'));
            }

            if ( e(Input::get('supplier_id')) == '') {
                $license->supplier_id = NULL;
            } else {
                $license->supplier_id = e(Input::get('supplier_id'));
            }

            if ( e(Input::get('maintained')) == '') {
                $license->maintained = 0;
            } else {
                $license->maintained = e(Input::get('maintained'));
            }

            if ( e(Input::get('purchase_order')) == '') {
                $license->purchase_order = '';
            } else {
                $license->purchase_order = e(Input::get('purchase_order'));
            }

            // Save the license data
            $license->name              = e(Input::get('name'));
            $license->serial            = e(Input::get('serial'));
            $license->license_email     = e(Input::get('license_email'));
            $license->license_name      = e(Input::get('license_name'));
            $license->notes             = e(Input::get('notes'));
            $license->order_number      = e(Input::get('order_number'));
            $license->seats             = e(Input::get('seats'));
            $license->purchase_date     = e(Input::get('purchase_date'));
            $license->purchase_order    = e(Input::get('purchase_order'));
            $license->depreciation_id   = e(Input::get('depreciation_id'));
            $license->expiration_date   = e(Input::get('expiration_date'));
            $license->user_id           = Sentry::getId();

            if (($license->purchase_date == "") || ($license->purchase_date == "0000-00-00")) {
                $license->purchase_date = NULL;
            }

            if (($license->expiration_date == "") || ($license->expiration_date == "0000-00-00")) {
                $license->expiration_date = NULL;
            }

            if (($license->purchase_cost == "") || ($license->purchase_cost == "0.00")) {
                $license->purchase_cost = NULL;
            }

            // Was the license created?
            if($license->save()) {
                $insertedId = $license->id;
                // Save the license seat data
                for ($x=0; $x<$license->seats; $x++) {
                    $license_seat = new LicenseSeat();
                    $license_seat->license_id       = $insertedId;
                    $license_seat->user_id          = Sentry::getId();
                    $license_seat->assigned_to      = NULL;
                    $license_seat->notes            = NULL;
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

        // Show the page
        $license_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $licenseId)->lists('name', 'id');
        $depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
        $supplier_list = array('' => 'Select Supplier') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');
        return View::make('backend/licenses/edit', compact('license'))
            ->with('license_options',$license_options)
            ->with('depreciation_list',$depreciation_list)
            ->with('supplier_list',$supplier_list)
            ->with('maintained_list',$maintained_list);
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
        if ($license->validate($new)) {

            // Update the license data
            $license->name              = e(Input::get('name'));
            $license->serial            = e(Input::get('serial'));
            $license->license_email     = e(Input::get('license_email'));
            $license->license_name      = e(Input::get('license_name'));
            $license->notes             = e(Input::get('notes'));
            $license->order_number      = e(Input::get('order_number'));
            $license->depreciation_id   = e(Input::get('depreciation_id'));
            $license->purchase_order    = e(Input::get('purchase_order'));
            $license->maintained        = e(Input::get('maintained'));

            if ( e(Input::get('supplier_id')) == '') {
                $license->supplier_id = NULL;
            } else {
                $license->supplier_id = e(Input::get('supplier_id'));
            }

            // Update the asset data
            if ( e(Input::get('purchase_date')) == '') {
                    $license->purchase_date =  NULL;
            } else {
                    $license->purchase_date = e(Input::get('purchase_date'));
            }

            if ( e(Input::get('expiration_date')) == '') {
                $license->expiration_date = NULL;
            } else {
                $license->expiration_date = e(Input::get('expiration_date'));
            }

            // Update the asset data
            if ( e(Input::get('termination_date')) == '') {
                $license->termination_date =  NULL;
            } else {
                $license->termination_date = e(Input::get('termination_date'));
            }

            if ( e(Input::get('purchase_cost')) == '') {
                    $license->purchase_cost =  NULL;
            } else {
                    $license->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
                    //$license->purchase_cost = e(Input::get('purchase_cost'));
            }

            if ( e(Input::get('maintained')) == '') {
                $license->maintained = 0;
            } else {
                $license->maintained = e(Input::get('maintained'));
            }

            if ( e(Input::get('purchase_order')) == '') {
                $license->purchase_order = '';
            } else {
                $license->purchase_order = e(Input::get('purchase_order'));
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
                        $license_seat->license_id       = $license->id;
                        $license_seat->user_id          = Sentry::getId();
                        $license_seat->assigned_to      = NULL;
                        $license_seat->notes            = NULL;
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
                $license->seats             = e(Input::get('seats'));
            }

            // Was the asset created?
            if($license->save()) {
                // Redirect to the new license page
                return Redirect::to("admin/licenses/$licenseId/view")->with('success', Lang::get('admin/licenses/message.update.success'));
            }
        } else {
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
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the license management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }

        if (($license->assignedcount()) && ($license->assignedcount() > 0)) {

            // Redirect to the license management page
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.assoc_users'));

        } else {

            // Delete the license and the associated license seats
            DB::table('license_seats')
            ->where('id', $license->id)
            ->update(array('assigned_to' => NULL,'asset_id' => NULL));

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
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }

        // Get the dropdown of users and then pass it to the checkout view
         $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat(last_name,", ",first_name) as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');


        // Left join to get a list of assets and some other helpful info
        $asset = DB::table('assets')
            ->leftJoin('users', 'users.id', '=', 'assets.assigned_to')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->select('assets.id', 'assets.name', 'first_name', 'last_name','asset_tag',
            DB::raw('concat(first_name," ",last_name) as full_name, assets.id as id, models.name as modelname'))
            ->whereNull('assets.deleted_at')
            ->get();

            $asset_array = json_decode(json_encode($asset), true);
            $asset_element[''] = 'Please select an asset';

            // Build a list out of the data results
            for ($x=0; $x<count($asset_array); $x++) {

                if ($asset_array[$x]['full_name']!='') {
                    $full_name = ' ('.$asset_array[$x]['full_name'].') '.$asset_array[$x]['modelname'];
                } else {
                    $full_name = ' (Unassigned) '.$asset_array[$x]['modelname'];
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
            'asset_id'  => 'required_without:assigned_to',
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

    if ( e(Input::get('asset_id')) == '') {
            $licenseseat->asset_id = NULL;
        } else {
            $licenseseat->asset_id = e(Input::get('asset_id'));
        }

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
            $logaction->asset_id = $licenseseat->license_id;


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
    public function getCheckin($seatId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return Redirect::to('admin/licenses')->with('error', Lang::get('admin/licenses/message.not_found'));
        }
        return View::make('backend/licenses/checkin', compact('licenseseat'))->with('backto',$backto);

    }



    /**
    * Check in the item so that it can be checked out again to someone else
    **/
    public function postCheckin($seatId = null, $backto = null)
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
		$return_to = $licenseseat->assigned_to;
        $logaction = new Actionlog();
        $logaction->checkedout_to = $licenseseat->assigned_to;

        // Update the asset data
        $licenseseat->assigned_to                   = NULL;
        $licenseseat->asset_id                      = NULL;

        // Was the asset updated?
        if($licenseseat->save()) {
            $logaction->asset_id = $licenseseat->license_id;
            $logaction->location_id = NULL;
            $logaction->asset_type = 'software';
            $logaction->note = e(Input::get('note'));
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('checkin from');

			if ($backto=='user') {
				return Redirect::to("admin/users/".$return_to.'/view')->with('success', Lang::get('admin/licenses/message.checkin.success'));
			} else {
				return Redirect::to("admin/licenses/".$licenseseat->license_id."/view")->with('success', Lang::get('admin/licenses/message.checkin.success'));
			}

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
		$maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');
        //clone the orig
        $license = clone $license_to_clone;
        $license->id = null;
        $license->serial = null;

        // Show the page
        $depreciation_list = array('0' => Lang::get('admin/licenses/form.no_depreciation')) + Depreciation::lists('name', 'id');
        $supplier_list = array('' => 'Select Supplier') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        return View::make('backend/licenses/edit')->with('license_options',$license_options)->with('depreciation_list',$depreciation_list)->with('supplier_list',$supplier_list)->with('license',$license)->with('maintained_list',$maintained_list);

    }


    /**
    *  Upload the file to the server
    *
    * @param  int  $assetId
    * @return View
    **/
    public function postUpload($licenseId = null)
    {
        $license = License::find($licenseId);

		// the license is valid
		$destinationPath = app_path().'/private_uploads';

        if (isset($license->id)) {

        	if (Input::hasFile('licensefile')) {

				foreach(Input::file('licensefile') as $file) {

				$rules = array(
				   'licensefile' => 'required|mimes:png,gif,jpg,jpeg,doc,docx,pdf,txt,zip,rar|max:2000'
				);
				$validator = Validator::make(array('licensefile'=> $file), $rules);

					if($validator->passes()){

						$extension = $file->getClientOriginalExtension();
						$filename = 'license-'.$license->id.'-'.str_random(8);
						$filename .= '-'.Str::slug($file->getClientOriginalName()).'.'.$extension;
						$upload_success = $file->move($destinationPath, $filename);

						//Log the deletion of seats to the log
						$logaction = new Actionlog();
						$logaction->asset_id = $license->id;
						$logaction->asset_type = 'software';
						$logaction->user_id = Sentry::getUser()->id;
						$logaction->note = e(Input::get('notes'));
						$logaction->checkedout_to =  NULL;
						$logaction->created_at =  date("Y-m-d h:i:s");
						$logaction->filename =  $filename;
						$log = $logaction->logaction('uploaded');
					} else {
						 return Redirect::back()->with('error', Lang::get('admin/licenses/message.upload.invalidfiles'));
					}


				}

				if ($upload_success) {
				  	return Redirect::back()->with('success', Lang::get('admin/licenses/message.upload.success'));
				} else {
				   return Redirect::back()->with('success', Lang::get('admin/licenses/message.upload.error'));
				}

			} else {
				 return Redirect::back()->with('success', Lang::get('admin/licenses/message.upload.nofiles'));
			}





        } else {
            // Prepare the error message
            $error = Lang::get('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('licenses')->with('error', $error);
        }
    }


    /**
    *  Delete the associated file
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getDeleteFile($licenseId = null, $fileId = null)
    {
        $license = License::find($licenseId);
        $destinationPath = app_path().'/private_uploads';

		// the license is valid
        if (isset($license->id)) {

			$log = Actionlog::find($fileId);
			$full_filename = $destinationPath.'/'.$log->filename;
			if (file_exists($full_filename)) {
				unlink($destinationPath.'/'.$log->filename);
			}
			$log->delete();
			return Redirect::back()->with('success', Lang::get('admin/licenses/message.deletefile.success'));

        } else {
            // Prepare the error message
            $error = Lang::get('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('licenses')->with('error', $error);
        }
    }



    /**
    *  Display/download the uploaded file
    *
    * @param  int  $assetId
    * @return View
    **/
    public function displayFile($licenseId = null, $fileId = null)
    {

        $license = License::find($licenseId);

		// the license is valid
        if (isset($license->id)) {
				$log = Actionlog::find($fileId);
				$file = $log->get_src();
				return Response::download($file);
        } else {
            // Prepare the error message
            $error = Lang::get('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('licenses')->with('error', $error);
        }
    }

    public function getDatatable() {
        $licenses = License::orderBy('created_at', 'DESC')->get();

        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions', function($licenses) {
            return '<a href="'.route('update/license', $licenses->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/license', $licenses->id).'" data-content="'.Lang::get('admin/licenses/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($licenses->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
        });

        return Datatable::collection($licenses)
        ->addColumn('name', function($licenses) {
            return link_to('/admin/licenses/'.$licenses->id.'/view', $licenses->name);
        })
        ->addColumn('serial', function($licenses) {
            return link_to('/admin/licenses/'.$licenses->id.'/view', mb_strimwidth($licenses->serial, 0, 50, "..."));
        })
        ->addColumn('totalSeats', function($licenses) {
            return $licenses->totalSeatsByLicenseID();
        })
        ->addColumn('remaining', function($licenses) {
            return $licenses->remaincount();
        })
        ->addColumn('purchase_date', function($licenses) {
            return $licenses->purchase_date;
        })
        ->addColumn($actions)
        ->searchColumns('name','serial','totalSeats','remaining','purchase_date','actions')
        ->orderColumns('name','serial','totalSeats','remaining','purchase_date','actions')
        ->make();
    }
}
