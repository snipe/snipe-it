<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Image;
use Lang;
use Asset;
use Supplier;
use AssetMaintenance;
use Statuslabel;
use User;
use Setting;
use Redirect;
use DB;
use Actionlog;
use Company;
use Model;
use Depreciation;
use Sentry;
use Str;
use Validator;
use View;
use Response;
use Config;
use Location;
use Log;
use Mail;
use TCPDF;
use Slack;
use Paginator;
use Manufacturer; //for embedded-create
use Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
use CustomField;
use Symfony\Component\HttpFoundation\JsonResponse;
use Models;


class AssetsController extends AdminController
{
    protected $qrCodeDimensions = array( 'height' => 3.5, 'width' => 3.5);
    protected $barCodeDimensions = array( 'height' => 2, 'width' => 22);

    /**
     * Show a list of all the assets.
     *
     * @return View
     */

    public function getIndex()
    {
        return View::make('backend/hardware/index');
    }

    /**
     * Asset create.
     *
     * @param null $model_id
     *
     * @return View
     */
    public function getCreate($model_id = null)
    {
        // Grab the dropdown lists
        $model_list = modelList();
        $statuslabel_list = statusLabelList();
        $location_list = locationsList();
        $manufacturer_list = manufacturerList();
        $category_list = categoryList();
        $supplier_list = suppliersList();
        $company_list = companyList();
        $assigned_to = usersList();
        $statuslabel_types = statusTypeList();

        $view = View::make('backend/hardware/edit');
        $view->with('supplier_list',$supplier_list);
        $view->with('company_list',$company_list);
        $view->with('model_list',$model_list);
        $view->with('statuslabel_list',$statuslabel_list);
        $view->with('assigned_to',$assigned_to);
        $view->with('location_list',$location_list);
        $view->with('asset',new Asset);
        $view->with('manufacturer',$manufacturer_list);
        $view->with('category',$category_list);
        $view->with('statuslabel_types',$statuslabel_types);

        if (!is_null($model_id)) {
            $selected_model = Model::find($model_id);
            $view->with('selected_model',$selected_model);
        }

        return $view;
    }

    /**
     * Asset create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        // create a new model instance
        $asset = new Asset();
        $asset->model()->associate(Model::find(e(Input::get('model_id'))));

        //attempt to validate
        $input=Input::all();

        $rules=$asset->validationRules();
        if($asset->model->fieldset)
        {
          foreach($asset->model->fieldset->fields AS $field) {
            $input[$field->db_column_name()]=$input['fields'][$field->db_column_name()];
            $asset->{$field->db_column_name()}=$input[$field->db_column_name()];
          }
          $rules+=$asset->model->fieldset->validation_rules();
          unset($input['fields']);
        }

        $validator = Validator::make($input,  $rules );
        $custom_errors=[];


        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            if ( e(Input::get('status_id')) == '') {
                $asset->status_id =  NULL;
            } else {
                $asset->status_id = e(Input::get('status_id'));
            }

            if (e(Input::get('warranty_months')) == '') {
                $asset->warranty_months =  NULL;
            } else {
                $asset->warranty_months        = e(Input::get('warranty_months'));
            }

            if (e(Input::get('purchase_cost')) == '') {
                $asset->purchase_cost =  NULL;
            } else {
                $asset->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
            }

            if (e(Input::get('purchase_date')) == '') {
                $asset->purchase_date =  NULL;
            } else {
                $asset->purchase_date        = e(Input::get('purchase_date'));
            }

            if (e(Input::get('assigned_to')) == '') {
                $asset->assigned_to =  NULL;
            } else {
                $asset->assigned_to        = e(Input::get('assigned_to'));
            }

            if (e(Input::get('supplier_id')) == '') {
                $asset->supplier_id =  0;
            } else {
                $asset->supplier_id        = e(Input::get('supplier_id'));
            }

            if (e(Input::get('requestable')) == '') {
                $asset->requestable =  0;
            } else {
                $asset->requestable        = e(Input::get('requestable'));
            }

            if (e(Input::get('rtd_location_id')) == '') {
                $asset->rtd_location_id = NULL;
            } else {
                $asset->rtd_location_id     = e(Input::get('rtd_location_id'));
            }

            $checkModel = Config::get('app.url').'/api/models/'.e(Input::get('model_id')).'/check';
            //$asset->mac_address = ($checkModel == true) ? e(Input::get('mac_address')) : NULL;

            // Save the asset data
            $asset->name            		= e(Input::get('name'));
            $asset->serial            		= e(Input::get('serial'));
            $asset->company_id              = Company::getIdForCurrentUser(Input::get('company_id'));
            $asset->model_id                = e(Input::get('model_id'));
            $asset->order_number            = e(Input::get('order_number'));
            $asset->notes            		= e(Input::get('notes'));
            $asset->asset_tag            	= e(Input::get('asset_tag'));
            $asset->user_id          		= Sentry::getId();
            $asset->archived          			= '0';
            $asset->physical            		= '1';
            $asset->depreciate          		= '0';

	    // Create the image (if one was chosen.)
            if (Input::file('image')) {
                $image = Input::file('image');
                $file_name = str_random(25).".".$image->getClientOriginalExtension();
                $path = public_path('uploads/assets/'.$file_name);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $asset->image = $file_name;

            }

            // Was the asset created?
            if($asset->save()) {

            	if (Input::get('assigned_to')!='') {
					$logaction = new Actionlog();
					$logaction->asset_id = $asset->id;
					$logaction->checkedout_to = $asset->assigned_to;
					$logaction->asset_type = 'hardware';
					$logaction->user_id = Sentry::getUser()->id;
					$logaction->note = e(Input::get('note'));
					$log = $logaction->logaction('checkout');
				}
                // Redirect to the asset listing page
                return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.create.success'));
            }
        }

        // Redirect to the asset create page with an error
        return Redirect::to('assets/create')->with('error', Lang::get('admin/hardware/message.create.error'));


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
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Grab the dropdown lists
        $model_list = modelList();
        $statuslabel_list = statusLabelList();
        $location_list = locationsList();
        $manufacturer_list = manufacturerList();
        $category_list = categoryList();
        $supplier_list = suppliersList();
        $company_list = companyList();
        $assigned_to = usersList();
        $statuslabel_types = statusTypeList();

        return View::make('backend/hardware/edit', compact('asset'))
        ->with('model_list',$model_list)
        ->with('supplier_list',$supplier_list)
        ->with('company_list',$company_list)
        ->with('location_list',$location_list)
        ->with('statuslabel_list',$statuslabel_list)
        ->with('assigned_to',$assigned_to)
        ->with('manufacturer',$manufacturer_list)
        ->with('statuslabel_types',$statuslabel_types)
        ->with('category',$category_list);
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
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        $input=Input::all();
        // return "INPUT IS: <pre>".print_r($input,true)."</pre>";
        $rules=$asset->validationRules($assetId);
        $model=Model::find(e(Input::get('model_id'))); //validate by the NEW model's custom fields, not the current one
        if($model->fieldset)
        {
          foreach($model->fieldset->fields AS $field) {
            $input[$field->db_column_name()]=$input['fields'][$field->db_column_name()];
            $asset->{$field->db_column_name()}=$input[$field->db_column_name()];
          }
          $rules+=$model->fieldset->validation_rules();
          unset($input['fields']);
        }

        //return "Rules: <pre>".print_r($rules,true)."</pre>";

        //attempt to validate
        $validator = Validator::make($input,  $rules );

        $custom_errors=[];

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {


            if ( e(Input::get('status_id')) == '' ) {
                $asset->status_id =  NULL;
            } else {
                $asset->status_id = e(Input::get('status_id'));
            }

            if (e(Input::get('warranty_months')) == '') {
                $asset->warranty_months =  NULL;
            } else {
                $asset->warranty_months = e(Input::get('warranty_months'));
            }

            if (e(Input::get('purchase_cost')) == '') {
                $asset->purchase_cost =  NULL;
            } else {
                $asset->purchase_cost = ParseFloat(e(Input::get('purchase_cost')));
            }

            if (e(Input::get('purchase_date')) == '') {
                $asset->purchase_date =  NULL;
            } else {
                $asset->purchase_date        = e(Input::get('purchase_date'));
            }

            if (e(Input::get('supplier_id')) == '') {
                $asset->supplier_id =  NULL;
            } else {
                $asset->supplier_id        = e(Input::get('supplier_id'));
            }

            if (e(Input::get('requestable')) == '') {
                $asset->requestable =  0;
            } else {
                $asset->requestable        = e(Input::get('requestable'));
            }

            if (e(Input::get('rtd_location_id')) == '') {
                $asset->rtd_location_id = 0;
            } else {
                $asset->rtd_location_id     = e(Input::get('rtd_location_id'));
            }

            if (Input::has('image_delete')) {
                unlink(public_path().'/uploads/assets/'.$asset->image);
                $asset->image = '';
            }



            $checkModel = Config::get('app.url').'/api/models/'.e(Input::get('model_id')).'/check';
            //$asset->mac_address = ($checkModel == true) ? e(Input::get('mac_address')) : NULL;

            // Update the asset data
            $asset->name         = e(Input::get('name'));
            $asset->serial       = e(Input::get('serial'));
            $asset->company_id   = Company::getIdForCurrentUser(Input::get('company_id'));
            $asset->model_id     = e(Input::get('model_id'));
            $asset->order_number = e(Input::get('order_number'));
            $asset->asset_tag    = e(Input::get('asset_tag'));
            $asset->notes        = e(Input::get('notes'));
            $asset->physical     = '1';

	    // Update the image
            if (Input::file('image')) {
                $image = Input::file('image');
		  $file_name = str_random(25).".".$image->getClientOriginalExtension();
                $path = public_path('uploads/assets/'.$file_name);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $asset->image = $file_name;
            }



            // Was the asset updated?
            if($asset->save()) {
                // Redirect to the new asset page
                return Redirect::to("hardware/$assetId/view")->with('success', Lang::get('admin/hardware/message.update.success'));
            }
            else
            {
                 return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
             }
        }


        // Redirect to the asset management page with error
        /** @noinspection PhpUnreachableStatementInspection Known to be unreachable but kept following discussion: https://github.com/snipe/snipe-it/pull/1423 */
        return Redirect::to("hardware/$assetId/edit")->with('error', Lang::get('admin/hardware/message.update.error'));

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
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        if (isset($asset->assigneduser->id) && ($asset->assigneduser->id!=0)) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.assoc_users'));
        } else {
            // Delete the asset

            DB::table('assets')
            ->where('id', $asset->id)
            ->update(array('assigned_to' => NULL));


            $asset->delete();

            // Redirect to the asset management page
            return Redirect::to('hardware')->with('success', Lang::get('admin/hardware/message.delete.success'));
        }



    }

    /**
    * Check out the asset to a person
    **/
    public function getCheckout($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = usersList();

        return View::make('backend/hardware/checkout', compact('asset'))->with('users_list',$users_list);

    }

    /**
    * Check out the asset to a person
    **/
    public function postCheckout($assetId)
    {

        // Check if the asset exists
        if (!$asset = Asset::find($assetId)) {
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Declare the rules for the form validation
        $rules = array(
            'assigned_to'   => 'required|min:1',
            'checkout_at'   => 'required|date',
            'note'   => 'alpha_space',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (!$user = User::find(e(Input::get('assigned_to')))) {
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.user_does_not_exist'));
        }

        if (!$admin = Sentry::getUser()) {
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.admin_user_does_not_exist'));
        }


    	if (Input::get('checkout_at')!= date("Y-m-d")){
			     $checkout_at = e(Input::get('checkout_at')).' 00:00:00';
    	} else {
            $checkout_at = date("Y-m-d H:i:s");
        }

        if (Input::has('expected_checkin')) {
			    $expected_checkin = e(Input::get('expected_checkin'));
    	  } else {
            $expected_checkin = '';
        }


        if ($asset->checkOutToUser($user, $admin, $checkout_at, $expected_checkin, e(Input::get('note')), e(Input::get('name')))) {
            // Redirect to the new asset page
            return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.checkout.success'));
        }

        // Redirect to the asset management page with error
        return Redirect::to("hardware/$assetId/checkout")->with('error', Lang::get('admin/hardware/message.checkout.error'));
    }


    /**
    * Check the asset back into inventory
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getCheckin($assetId, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }
        $statusLabel_list = statusLabelList();
        return View::make('backend/hardware/checkin', compact('asset'))->with('statusLabel_list',$statusLabel_list)->with('backto', $backto);
    }


    /**
    * Check in the item so that it can be checked out again to someone else
    *
    * @param  int  $assetId
    * @return View
    **/
    public function postCheckin($assetId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Check for a valid user to checkout fa-random
        // This will need to be tweaked for checkout to location
        if (!is_null($asset->assigned_to)) {
            $user = User::find($asset->assigned_to);
        } else {
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.already_checked_in'));
        }

        // This is just used for the redirect
        $return_to = $asset->assigned_to;

        $logaction = new Actionlog();
        $logaction->checkedout_to = $asset->assigned_to;

        // Update the asset data to null, since it's being checked in
        $asset->assigned_to            		= NULL;
        $asset->accepted                  = NULL;

        $asset->expected_checkin = NULL;
        $asset->last_checkout = NULL;

        if (Input::has('status_id')) {
          $asset->status_id =  e(Input::get('status_id'));
        }
        // Was the asset updated?
        if($asset->save()) {

        	 if (Input::has('checkin_at')) {

        	 	if (!strtotime(Input::get('checkin_at'))) {
					$logaction->created_at = date("Y-m-d H:i:s");
        	 	} elseif (Input::get('checkin_at')!= date("Y-m-d")) {
					$logaction->created_at = e(Input::get('checkin_at')).' 00:00:00';
				}
        	}

            $logaction->asset_id = $asset->id;
            $logaction->location_id = NULL;
            $logaction->asset_type = 'hardware';
            $logaction->note = e(Input::get('note'));
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('checkin from');

			$settings = Setting::getSettings();

			if ($settings->slack_endpoint) {

				$slack_settings = [
				    'username' => $settings->botname,
				    'channel' => $settings->slack_channel,
				    'link_names' => true
				];

				$client = new \Maknz\Slack\Client($settings->slack_endpoint,$slack_settings);

				try {
						$client->attach([
						    'color' => 'good',
						    'fields' => [
						        [
						            'title' => 'Checked In:',
						            'value' => strtoupper($logaction->asset_type).' asset <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> checked in by <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.Sentry::getUser()->fullName().'>.'
						        ],
						        [
						            'title' => 'Note:',
						            'value' => e($logaction->note)
						        ],

						    ]
						])->send('Asset Checked In');

					} catch (Exception $e) {

					}

			}

            $data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $asset->showAssetName();
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = $asset->asset_tag;
            $data['item_serial'] = $asset->serial;
            $data['note'] = $logaction->note;

            if ((($asset->checkin_email()=='1')) && ($user) && (!Config::get('app.lock_passwords'))) {
                Mail::send('emails.checkin-asset', $data, function ($m) use ($user) {
                	$m->to($user->email, $user->first_name . ' ' . $user->last_name);
                	$m->subject('Confirm Asset Checkin');
                });
            }

			if ($backto=='user') {
				return Redirect::to("admin/users/".$return_to.'/view')->with('success', Lang::get('admin/hardware/message.checkin.success'));
			} else {
				return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.checkin.success'));
			}

        }

        // Redirect to the asset management page with error
        return Redirect::to("hardware")->with('error', Lang::get('admin/hardware/message.checkin.error'));
    }


    /**
    *  Get the asset information to present to the asset view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($assetId = null)
    {
        $asset = Asset::withTrashed()->find($assetId);
        $settings = Setting::getSettings();

        if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }
        else if ($asset->userloc) {
            $use_currency = $asset->userloc->currency;
        } elseif ($asset->assetloc) {
            $use_currency = $asset->assetloc->currency;
        } else {
          $default_currency = Setting::first()->default_currency;

          if ($settings->default_currency!='') {
            $use_currency = $settings->default_currency;
          } else {
            $use_currency = Lang::get('general.currency');
          }

        }

        if (isset($asset->id)) {



            $qr_code = (object) array(
                'display' => $settings->qr_code == '1',
                'url' => route('qr_code/hardware', $asset->id)
            );

            return View::make('backend/hardware/view', compact('asset', 'qr_code','settings'))->with('use_currency',$use_currency);
        } else {
            // Prepare the error message
            $error = Lang::get('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('hardware')->with('error', $error);
        }

    }

    /**
    *  Get the QR code representing the asset
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getQrCode($assetId = null)
    {
        $settings = Setting::getSettings();

        if ($settings->qr_code == '1') {
            $asset = Asset::find($assetId);
            $size = barcodeDimensions($settings->barcode_type);

            if (!Company::isCurrentUserHasAccess($asset)) {
                return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
            }

            if (isset($asset->id,$asset->asset_tag)) {
                $barcode = new \Com\Tecnick\Barcode\Barcode();
                $barcode_obj =  $barcode->getBarcodeObj($settings->barcode_type, route('view/hardware', $asset->id), $size['height'], $size['width'], 'black', array(-2, -2, -2, -2));
                return $barcode_obj->getPngData();
            }
        }

    }


    public function getImportUpload() {

        $path = app_path().'/private_uploads/imports/assets';
        $files = array();

        if (!Company::isCurrentUserAuthorized()) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                clearstatcache();
                if (substr(strrchr($entry,'.'),1)=='csv') {
                    $files[] = array(
                            'filename' => $entry,
                            'filesize' => Setting::fileSizeConvert(filesize($path.'/'.$entry)),
                            'modified' => filemtime($path.'/'.$entry)
                        );
                }

            }
            closedir($handle);
            $files = array_reverse($files);
        }

        return View::make('backend/hardware/import')->with('files',$files);
    }



    public function postAPIImportUpload() {

        if (!Company::isCurrentUserAuthorized()) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }
        elseif (!Config::get('app.lock_passwords')) {

            $rules = array(
                'files' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->messages();
                $results['error']=$messages->first('files');
                return $results;

            } else {
                    $files = Input::file('files');
                    $path = app_path().'/private_uploads/imports/assets';
                    $results = array();

                    foreach ($files as $file) {

                        if (!in_array($file->getMimeType(), array(
                            'application/vnd.ms-excel',
                            'text/csv',
                            'text/plain',
                            'text/comma-separated-values',
                            'text/tsv'))) {
                            $results['error']='File type must be CSV';
                            return $results;
                        }

                        $date = date('Y-m-d-his');
                        $fixed_filename = str_replace(' ','-',$file->getClientOriginalName());
                        $file->move($path, $date.'-'.$fixed_filename);
                        $name = date('Y-m-d-his').'-'.$fixed_filename;
                        $filesize = Setting::fileSizeConvert(filesize($path.'/'.$name));
                        $results[] = compact('name', 'filesize');
                    }
            }

        } else {

            $results['error']=Lang::get('general.feature_disabled');
            return $results;
        }

        return array(
            'files' => $results
        );


    }

    public function getProcessImportFile($filename) {
        // php artisan asset-import:csv path/to/your/file.csv --domain=yourdomain.com --email_format=firstname.lastname

        if (!Company::isCurrentUserAuthorized()) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        $output = new BufferedOutput;
        Artisan::call('asset-import:csv', ['filename'=> app_path().'/private_uploads/imports/assets/'.$filename, '--email_format'=>'firstname.lastname', '--username_format'=>'firstname.lastname'], $output);
        $display_output =  $output->fetch();
        $file = app_path().'/private_uploads/imports/assets/'.str_replace('.csv','',$filename).'-output-'.date("Y-m-d-his").'.txt';
        file_put_contents($file, $display_output);


        return Redirect::to('hardware')->with('success','Your file has been imported');

    }

    /**
     * Asset clone.
     *
     * @param  int  $assetId
     * @return View
     */
    public function getClone($assetId = null)
    {
        // Check if the asset exists
        if (is_null($asset_to_clone = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        else if (!Company::isCurrentUserHasAccess($asset_to_clone)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Grab the dropdown lists
        $model_list = modelList();
        $statuslabel_list = statusLabelList();
        $location_list = locationsList();
        $manufacturer_list = manufacturerList();
        $category_list = categoryList();
        $supplier_list = suppliersList();
        $assigned_to = usersList();
        $statuslabel_types = statusTypeList();
        $company_list = companyList();

        $asset = clone $asset_to_clone;
        $asset->id = null;
        $asset->asset_tag = '';
        $asset->serial = '';
        $asset->assigned_to = '';

        return View::make('backend/hardware/edit')
        ->with('supplier_list',$supplier_list)
        ->with('model_list',$model_list)
        ->with('statuslabel_list',$statuslabel_list)
        ->with('statuslabel_types',$statuslabel_types)
        ->with('assigned_to',$assigned_to)
        ->with('asset',$asset)
        ->with('location_list',$location_list)
        ->with('manufacturer',$manufacturer_list)
        ->with('category',$category_list)
        ->with('company_list',$company_list);

    }


    public function getRestore($assetId = null)
    {

		// Get user information
		$asset = Asset::withTrashed()->find($assetId);

        if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
        }
		else if (isset($asset->id)) {

			// Restore the user
			$asset->restore();

			// Prepare the success message
			$success = Lang::get('admin/hardware/message.restore.success');

			// Redirect to the user management page
			return Redirect::route('hardware')->with('success', $success);

		 } else {
			 return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
		 }

    }


       /**
    *  Upload the file to the server
    *
    * @param  int  $assetId
    * @return View
    **/
    public function postUpload($assetId = null)
    {
        $asset = Asset::find($assetId);

		// the asset is valid
		$destinationPath = app_path().'/private_uploads';

        if (isset($asset->id)) {

            if (!Company::isCurrentUserHasAccess($asset)) {
                return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
            }

        	if (Input::hasFile('assetfile')) {

				foreach(Input::file('assetfile') as $file) {

				$rules = array(
				   'assetfile' => 'required|mimes:png,gif,jpg,jpeg,doc,docx,pdf,txt,zip,rar|max:2000'
				);
				$validator = Validator::make(array('assetfile'=> $file), $rules);

					if($validator->passes()){

						$extension = $file->getClientOriginalExtension();
						$filename = 'hardware-'.$asset->id.'-'.str_random(8);
						$filename .= '-'.Str::slug($file->getClientOriginalName()).'.'.$extension;
						$upload_success = $file->move($destinationPath, $filename);

						//Log the deletion of seats to the log
						$logaction = new Actionlog();
						$logaction->asset_id = $asset->id;
						$logaction->asset_type = 'hardware';
						$logaction->user_id = Sentry::getUser()->id;
						$logaction->note = e(Input::get('notes'));
						$logaction->checkedout_to =  NULL;
						$logaction->created_at =  date("Y-m-d H:i:s");
						$logaction->filename =  $filename;
						$log = $logaction->logaction('uploaded');
					} else {
						 return Redirect::back()->with('error', Lang::get('admin/hardware/message.upload.invalidfiles'));
					}


				}

				if ($upload_success) {
				  	return Redirect::back()->with('success', Lang::get('admin/hardware/message.upload.success'));
				} else {
				   return Redirect::back()->with('success', Lang::get('admin/hardware/message.upload.error'));
				}

			} else {
				 return Redirect::back()->with('error', Lang::get('admin/hardware/message.upload.nofiles'));
			}





        } else {
            // Prepare the error message
            $error = Lang::get('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the hardware management page
            return Redirect::route('hardware')->with('error', $error);
        }
    }


    /**
    *  Delete the associated file
    *
    * @param  int  $assetId
    * @param  int  $fileId
    * @return View
    **/
    public function getDeleteFile($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        $destinationPath = app_path().'/private_uploads';

		// the asset is valid
        if (isset($asset->id)) {


            if (!Company::isCurrentUserHasAccess($asset)) {
                return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
            }

			$log = Actionlog::find($fileId);
			$full_filename = $destinationPath.'/'.$log->filename;
			if (file_exists($full_filename)) {
				unlink($destinationPath.'/'.$log->filename);
			}
			$log->delete();
			return Redirect::back()->with('success', Lang::get('admin/hardware/message.deletefile.success'));

        } else {
            // Prepare the error message
            $error = Lang::get('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the hardware management page
            return Redirect::route('hardware')->with('error', $error);
        }
    }



    /**
    *  Display/download the uploaded file
    *
    * @param  int  $assetId
    * @param  int  $fileId
    * @return View
    **/
    public function displayFile($assetId = null, $fileId = null)
    {

        $asset = Asset::find($assetId);

		// the asset is valid
        if (isset($asset->id)) {


            if (!Company::isCurrentUserHasAccess($asset)) {
                return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
            }

		$log = Actionlog::find($fileId);
		$file = $log->get_src();

            $filetype = Asset::checkUploadIsImage($file);

            if ($filetype) {

                  $contents = file_get_contents($file);
                  $response = Response::make($contents);
                  $response->header('Content-Type', $filetype);
                  return $response;

            } else {
                  return Response::download($file);
            }

        } else {
            // Prepare the error message
            $error = Lang::get('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the hardware management page
            return Redirect::route('hardware')->with('error', $error);
        }
    }




    /**
    *  Display bulk edit screen
    *
    * @return View
    **/
    public function postBulkEdit($assets = null)
    {

      if (!Company::isCurrentUserAuthorized()) {
        return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));

      } elseif (!Input::has('edit_asset')) {
			     return Redirect::back()->with('error', 'No assets selected');

  		} else {
  			$asset_raw_array = Input::get('edit_asset');
  			foreach ($asset_raw_array as $asset_id => $value) {
  				$asset_ids[] = $asset_id;

  			}

  		}

	    if (Input::has('bulk_actions')) {


		    // Create labels
		    if (Input::get('bulk_actions')=='labels') {
          $settings = Setting::getSettings();
          if ($settings->qr_code=='1') {

            $assets = Asset::find($asset_ids);
            $assetcount = count($assets);
            $count = 0;

            return View::make('backend/hardware/labels')->with('assets',$assets)->with('settings',$settings)->with('count',$count);

          } else {
            // QR codes are not enabled
            return Redirect::to("hardware")->with('error','Barcodes are not enabled in Admin > Settings');
          }

      } elseif (Input::get('bulk_actions')=='delete') {


        $assets = Asset::with('assigneduser','assetloc')->find($asset_ids);
        return View::make('backend/hardware/bulk-delete')->with('assets',$assets);

			 // Bulk edit
			} elseif (Input::get('bulk_actions')=='edit') {

				$assets = Input::get('edit_asset');
				$supplier_list = array('' => '') + suppliersList();
        $statuslabel_list = array('' => '') + statusLabelList();
        $location_list = array('' => '') + locationsList();
        $models_list = array('' => '') + modelList();
        $companies_list = array('' => '') + array('clear' => Lang::get('general.remove_company')) + companyList();

        return View::make('backend/hardware/bulk')
        ->with('assets',$assets)
        ->with('supplier_list',$supplier_list)
        ->with('statuslabel_list',$statuslabel_list)
        ->with('location_list',$location_list)
        ->with('models_list',$models_list)
        ->with('companies_list',$companies_list);


			}

		} else {
			return Redirect::back()->with('error', 'No action selected');
		}



    }



    /**
    *  Save bulk edits
    *
    * @return View
    **/
    public function postBulkSave($assets = null)
    {

      if (!Company::isCurrentUserAuthorized()) {
          return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));

      } elseif (Input::has('bulk_edit')) {

			$assets = Input::get('bulk_edit');

			if ( (Input::has('purchase_date')) ||  (Input::has('purchase_cost'))  ||  (Input::has('supplier_id')) ||  (Input::has('order_number')) || (Input::has('warranty_months')) || (Input::has('rtd_location_id'))  || (Input::has('requestable')) ||  (Input::has('company_id')) || (Input::has('status_id')) ||  (Input::has('model_id')) )  {

				foreach ($assets as $key => $value) {

					$update_array = array();

					if (Input::has('purchase_date')) {
						$update_array['purchase_date'] =  e(Input::get('purchase_date'));
					}

					if (Input::has('purchase_cost')) {
						$update_array['purchase_cost'] =  e(Input::get('purchase_cost'));
					}

					if (Input::has('supplier_id')) {
						$update_array['supplier_id'] =  e(Input::get('supplier_id'));
					}

          if (Input::has('model_id')) {
						$update_array['model_id'] =  e(Input::get('model_id'));
					}

          if (Input::has('company_id')) {
            if (Input::get('company_id')=="clear") {
              $update_array['company_id'] =  null;
            } else {
              $update_array['company_id'] =  e(Input::get('company_id'));
            }

					}

					if (Input::has('order_number')) {
						$update_array['order_number'] =  e(Input::get('order_number'));
					}

					if (Input::has('warranty_months')) {
						$update_array['warranty_months'] =  e(Input::get('warranty_months'));
					}

					if (Input::has('rtd_location_id')) {
						$update_array['rtd_location_id'] = e(Input::get('rtd_location_id'));
					}

					if (Input::has('status_id')) {
						$update_array['status_id'] = e(Input::get('status_id'));
					}

          if (Input::has('requestable')) {
            $update_array['requestable'] = e(Input::get('requestable'));
          }


					if (DB::table('assets')
		            ->where('id', $key)
		            ->update($update_array)) {

			            $logaction = new Actionlog();
			            $logaction->asset_id = $key;
			            $logaction->asset_type = 'hardware';
			            $logaction->created_at =  date("Y-m-d H:i:s");

			            if (Input::has('rtd_location_id')) {
			            	$logaction->location_id = e(Input::get('rtd_location_id'));
			            }
			            $logaction->user_id = Sentry::getUser()->id;
			            $log = $logaction->logaction('update');

		            }

				} // endforeach

				return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.update.success'));

			// no values given, nothing to update
			} else {
				return Redirect::to("hardware")->with('info',Lang::get('admin/hardware/message.update.nothing_updated'));

			}


		} // endif

		return Redirect::to("hardware");

    }

    /**
    *  Save bulk edits
    *
    * @return View
    **/
    public function postBulkDelete($assets = null)
    {

      if (!Company::isCurrentUserAuthorized()) {
        return Redirect::to('hardware')->with('error', Lang::get('general.insufficient_permissions'));
      } elseif (Input::has('bulk_edit')) {
			  //$assets = Input::get('bulk_edit');
        $assets = Asset::find(Input::get('bulk_edit'));
        //print_r($assets);


				foreach ($assets as $asset) {
          //echo '<li>'.$asset;
          $update_array['deleted_at'] = date('Y-m-d h:i:s');
          $update_array['assigned_to'] = NULL;

					if (DB::table('assets')
            ->where('id', $asset->id)
            ->update($update_array)) {

	            $logaction = new Actionlog();
	            $logaction->asset_id = $asset->id;
	            $logaction->asset_type = 'hardware';
	            $logaction->created_at =  date("Y-m-d H:i:s");
	            $logaction->user_id = Sentry::getUser()->id;
	            $log = $logaction->logaction('deleted');

            }

				} // endforeach
				return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.delete.success'));

			// no values given, nothing to update
			} else {
				return Redirect::to("hardware")->with('info',Lang::get('admin/hardware/message.delete.nothing_updated'));

			}

		// Something weird happened here - default to hardware
    return Redirect::to("hardware");

    }



    public function getDatatable($status = null)
    {


       $assets = Asset::select('assets.*')->with('model','assigneduser','assigneduser.userloc','assetstatus','defaultLoc','assetlog','model','model.category','model.fieldset','assetstatus','assetloc', 'company')
       ->Hardware();

       if (Input::has('search')) {
             $assets = $assets->TextSearch(Input::get('search'));
       }

       if (Input::has('offset')) {
             $offset = e(Input::get('offset'));
       } else {
             $offset = 0;
       }

       if (Input::has('limit')) {
             $limit = e(Input::get('limit'));
       } else {
             $limit = 50;
       }

       if (Input::has('order_number')) {
           $assets->where('order_number','=',e(Input::get('order_number')));
       }

      switch ($status) {
      case 'Deleted':
        $assets->withTrashed()->Deleted();
        break;
      case 'Pending':
      	$assets->Pending();
      	break;
      case 'RTD':
      	$assets->RTD();
      	break;
      case 'Undeployable':
      	$assets->Undeployable();
      	break;
      case 'Archived':
      	$assets->Archived();
      	break;
      case 'Requestable':
      	$assets->RequestableAssets();
      	break;
      case 'Deployed':
      	$assets->Deployed();
      	break;

      }

    $allowed_columns = [
      'id',
      'name',
      'asset_tag',
      'serial',
      'model',
      'last_checkout',
      'category',
      'notes',
      'expected_checkin',
      'order_number',
      'companyName',
      'location',
      'image',
    ];

    $all_custom_fields=CustomField::all(); //used as a 'cache' of custom fields throughout this page load

    foreach($all_custom_fields AS $field) {
      $allowed_columns[]=$field->db_column_name();
    }

    $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
    $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'asset_tag';

    switch ($sort)
    {
        case 'model':
            $assets = $assets->OrderModels($order);
            break;
        case 'category':
            $assets = $assets->OrderCategory($order);
            break;
        case 'companyName':
            $assets = $assets->OrderCompany($order);
            break;
        case 'location':
            $assets = $assets->OrderLocation($order);
            break;
        case 'status':
            $assets = $assets->OrderCategory($order);
           break;
        default:
            $assets = $assets->orderBy($sort, $order);
            break;
    }

     $assetCount = $assets->count();
     $assets = $assets->skip($offset)->take($limit)->get();


      $rows = array();
      foreach ($assets as $asset) {
        $inout = '';
        $actions = '';
        if ($asset->deleted_at=='') {
            $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/hardware', $asset->id).'" class="btn btn-info btn-sm" title="Clone asset"><i class="fa fa-files-o"></i></a> <a href="'.route('update/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/hardware', $asset->id).'" data-content="'.Lang::get('admin/hardware/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($asset->asset_tag).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
        } elseif ($asset->model->deleted_at=='') {
            $actions = '<a href="'.route('restore/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
        }

        if ($asset->assetstatus) {
            if ($asset->assetstatus->deployable != 0) {
                if (($asset->assigned_to !='') && ($asset->assigned_to > 0)) {
                    $inout = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.Lang::get('general.checkin').'</a>';
                } else {
                    $inout = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.Lang::get('general.checkout').'</a>';
                }
            }
        }

        $row = array(
            'checkbox'      =>'<div class="text-center"><input type="checkbox" name="edit_asset['.$asset->id.']" class="one_required"></div>',
            'id'        => $asset->id,
            'image' => (($asset->image) && ($asset->image!='')) ? '<img src="'.Config::get('app.url').'/uploads/assets/'.$asset->image.'" height=50 width=50>' : ((($asset->model) && ($asset->model->image!='')) ? '<img src="'.Config::get('app.url').'/uploads/models/'.$asset->model->image.'" height=40 width=50>' : ''),
            'name'          => '<a title="'.$asset->name.'" href="hardware/'.$asset->id.'/view">'.$asset->name.'</a>',
            'asset_tag'     => '<a title="'.$asset->asset_tag.'" href="hardware/'.$asset->id.'/view">'.$asset->asset_tag.'</a>',
            'serial'        => $asset->serial,
            'model'         => ($asset->model) ? link_to('/hardware/models/'.$asset->model->id.'/view', $asset->model->name) : 'No model',
            'status'        => ($asset->assigneduser) ? link_to('../admin/users/'.$asset->assigned_to.'/view', $asset->assigneduser->fullName()) : (($asset->assetstatus) ? $asset->assetstatus->name : ''),
            'location'      => (($asset->assigneduser) && ($asset->assigneduser->userloc!='')) ? link_to('admin/settings/locations/'.$asset->assigneduser->userloc->id.'/edit', $asset->assigneduser->userloc->name) : (($asset->defaultLoc!='') ? link_to('admin/settings/locations/'.$asset->defaultLoc->id.'/edit', $asset->defaultLoc->name) : ''),
            'category'      => (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : '',
            'eol'           => ($asset->eol_date()) ? $asset->eol_date() : '',
            'notes'         => $asset->notes,
            'order_number'  => ($asset->order_number!='') ? '<a href="'.Config::get('app.url').'/hardware?order_number='.$asset->order_number.'">'.$asset->order_number.'</a>' : '',
            'last_checkout' => ($asset->last_checkout!='') ? $asset->last_checkout : '',
            'expected_checkin' => ($asset->expected_checkin!='')  ? $asset->expected_checkin : '',
            'change'        => ($inout) ? $inout : '',
            'actions'       => ($actions) ? $actions : '',
            'companyName'   => is_null($asset->company) ? '' : e($asset->company->name)
            );
        foreach($all_custom_fields AS $field) {
          $row[$field->db_column_name()]=$asset->{$field->db_column_name()};
        }
        $rows[]=$row;
      }

      $data = array('total'=>$assetCount, 'rows'=>$rows);

      return $data;
  }
}
