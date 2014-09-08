<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Asset;
use Supplier;
use Statuslabel;
use User;
use Setting;
use Redirect;
use DB;
use Actionlog;
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

use BaconQrCode\Renderer\Image as QrImage;

class AssetsController extends AdminController
{
    protected $qrCodeDimensions = array( 'height' => 170, 'width' => 170);

    /**
     * Show a list of all the assets.
     *
     * @return View
     */

    public function getIndex()
    {
       
        // Grab all the assets
        if (Input::get('withTrashed')) {
            $assets = Asset::orderBy('asset_tag', 'DESC');
            $assets = $assets->withTrashed()->paginate(Setting::getSettings()->per_page);;           
        } elseif (Input::get('onlyTrashed')) {	
            $assets = Asset::onlyTrashed()->orderBy('asset_tag', 'DESC');
            $assets = $assets->paginate(Setting::getSettings()->per_page);;
        }
        // Filter results
        elseif (Input::get('Pending')) {
            $assets = Asset::Pending()->orderBy('asset_tag', 'ASC')->get();
        } elseif (Input::get('RTD')) {
            $assets = Asset::ReadyToDeploy()->orderBy('asset_tag', 'ASC')->get();
        } elseif (Input::get('Undeployable')) {
            $assets = Asset::Undelpoyable()->orderBy('asset_tag', 'ASC')->get();
        } elseif (Input::get('Deployed')) {
            $assets = Asset::deployed()->orderBy('asset_tag', 'ASC')->get();
        } else {
            $assets = Asset::orderBy('asset_tag', 'ASC')->where('physical', '=', 1)->get();
        }

        return View::make('backend/hardware/index', compact('assets'));
    }

    public function getReports()
    {
        // Grab all the assets
        $assets = Asset::orderBy('created_at', 'DESC')->get();
        return View::make('backend/reports/index', compact('assets'));
    }

    public function exportReports()
    {
        // @todo - It may be worthwhile creating a separate controller for reporting

        // Grab all the assets
        $assets = Asset::orderBy('created_at', 'DESC')->get();

        $rows = array();

        // Create the header row
        $header = array(
            Lang::get('admin/hardware/table.asset_tag'),
            Lang::get('admin/hardware/table.title'),
            Lang::get('admin/hardware/table.serial'),
            Lang::get('admin/hardware/table.checkoutto'),
            Lang::get('admin/hardware/table.location'),
            Lang::get('admin/hardware/table.purchase_date'),
            Lang::get('admin/hardware/table.purchase_cost'),
            Lang::get('admin/hardware/table.book_value'),
            Lang::get('admin/hardware/table.diff')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        // Create a row per asset
        foreach ($assets as $asset) {
            $row = array();
            $row[] = $asset->asset_tag;
            $row[] = $asset->name;
            $row[] = $asset->serial;


            if ($asset->assigned_to > 0) {
              $user = User::find($asset->assigned_to);
              $row[] = $user->fullName();
              } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0)) {
                $location = Location::find($asset->assigneduser->location_id);
                if ($location->city) {
                    $row[] = '"'.$location->city . ', ' . $location->state.'"';
                } elseif ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            $depreciation = $asset->depreciate();

            $row[] = $asset->purchase_date;
            $row[] = '"'.number_format($asset->purchase_cost).'"';
            $row[] = '"'.number_format($depreciation).'"';
            $row[] = '"'.number_format($asset->purchase_cost - $depreciation).'"';
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * Asset create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Grab the dropdown list of models
        $model_list = array('' => '') + Model::orderBy('name', 'asc')->lists('name', 'id');
        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $assigned_to = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->whereNull('deleted_at')->lists('full_name', 'id');

        // Grab the dropdown list of status
        //$statuslabel_list = array('' => Lang::get('general.pending')) + array('0' => Lang::get('general.ready_to_deploy')) + Statuslabel::orderBy('name', 'asc')->lists('name', 'id');
        // only use database values
        $statuslabel_list = Statuslabel::orderBy('id', 'asc')->lists('name', 'id');

        return View::make('backend/hardware/edit')->with('supplier_list',$supplier_list)->with('model_list',$model_list)->with('statuslabel_list',$statuslabel_list)->with('assigned_to',$assigned_to)->with('asset',new Asset);

    }
    
    public function getPrepare($assetId = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        
        if($asset->state->prepare())
        {
            $logaction = new Actionlog();
            $logaction->asset_id = $asset->id;            
            $logaction->asset_type = 'hardware';            
            $logaction->user_id = Sentry::getUser()->id;            
            $log = $logaction->logaction('prepare');
            
            return Redirect::to("hardware")->with('success', Lang::get('message.update.success'));
        }
        
        return Redirect::to('hardware')->with('error', Lang::get('general.error'));
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
 
        //attempt to validate
        $validator = Validator::make(Input::all(), $asset->validationRules());

        if ($validator->fails())
        {
            // The given data did not pass validation            
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
/**
            if ( e(Input::get('status_id')) == '') {
                $asset->status_id =  1;
            } else {
                $asset->status_id = e(Input::get('status_id'));
            }
**/
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
                $asset->assigned_to =  0;
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

            // Save the asset data
            $asset->name            		= e(Input::get('name'));
            $asset->serial            		= e(Input::get('serial'));
            $asset->model_id           		= e(Input::get('model_id'));
            $asset->order_number                = e(Input::get('order_number'));
            $asset->notes            		= e(Input::get('notes'));
            $asset->asset_tag            	= e(Input::get('asset_tag'));
    
            $asset->user_id          		= Sentry::getId();
            $asset->archived          			= '0';
            $asset->physical            		= '1';
            $asset->depreciate          		= '0';
            $asset->status_id                           =  1;

            // Was the asset created?
            if($asset->save()) {
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

        // Grab the dropdown list of models
        $model_list = array('' => '') + Model::orderBy('name', 'asc')->lists('name', 'id');
        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');

        // Grab the dropdown list of status
        //$statuslabel_list = array('' => Lang::get('general.pending')) + array('0' => Lang::get('general.ready_to_deploy')) + Statuslabel::orderBy('name', 'asc')->lists('name', 'id');
        // only use database values
        $statuslabel_list = Statuslabel::orderBy('id', 'asc')->lists('name', 'id');

        return View::make('backend/hardware/edit', compact('asset'))->with('model_list',$model_list)->with('supplier_list',$supplier_list)->with('statuslabel_list',$statuslabel_list);
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
        
        //cannot set to deployed
        if(e(Input::get('status_id')) == 3 && e(Input::get('assigned_to')) < 1)
            return Redirect::to('hardware/'.$assetId.'/edit')->with('error', 'cannot deploy without user');
       
        //attempt to validate
        $validator = Validator::make(Input::all(), $asset->validationRules($assetId));

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
                $asset->status_id = (e(Input::get('status_id')));
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

            // Update the asset data
            $asset->name            		= e(Input::get('name'));
            $asset->serial            		= e(Input::get('serial'));
            $asset->model_id           		= e(Input::get('model_id'));
            $asset->order_number                = e(Input::get('order_number'));
            $asset->asset_tag           	= e(Input::get('asset_tag'));
            $asset->notes            		= e(Input::get('notes'));           
            $asset->physical            	= '1';

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
        if (is_null($asset = Asset::withTrashed()->find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.not_found'));
        }

        if (isset($asset->assigneduser->id) && ($asset->assigneduser->id!=0)) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.assoc_users'));
        } else {
            
            //check in all licences 
            foreach($asset->licenseseats as $seat)
            {                
                $seat->checkin();
            }
            // Delete the asset
            if($asset->state->delete())  
            {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('success', Lang::get('admin/hardware/message.delete.success'));
            }
            else
            {
                return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.delete.error'));
            }
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
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.not_found'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat(first_name," ",last_name) as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');

        //print_r($users);
        return View::make('backend/hardware/checkout', compact('asset'))->with('users_list',$users_list);

    }

    /**
    * Check out the asset to a person
    **/
    public function postCheckout($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.not_found'));
        }

        $assigned_to = e(Input::get('assigned_to'));


        // Declare the rules for the form validation
        $rules = array(
            'assigned_to'   => 'required|min:1',
            'note'   => 'alpha_space',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }


        // Check if the user exists
        if (is_null($assigned_to = User::find($assigned_to))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.user_does_not_exist'));
        }

        // Update the asset data
        //$asset->assigned_to            		= e(Input::get('assigned_to'));

        // Was the asset updated?
        if($asset->state->checkout($assigned_to->id)) {
            $logaction = new Actionlog();
            $logaction->asset_id = $asset->id;
            $logaction->checkedout_to = $asset->assigned_to;
            $logaction->asset_type = 'hardware';
            $logaction->location_id = $assigned_to->location_id;
            $logaction->user_id = Sentry::getUser()->id;
            $logaction->note = e(Input::get('note'));
            $log = $logaction->logaction('checkout');

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
    public function getCheckin($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.not_found'));
        }

        return View::make('backend/hardware/checkin', compact('asset'));
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
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.not_found'));
        }

        if (!is_null($asset->assigned_to)) {
            $user = User::find($asset->assigned_to);
        }

        $logaction = new Actionlog();
        if($user)
            $logaction->checkedout_to = $user->id;	

        // Was the asset updated?
        if($asset->state->checkin()) {

            $logaction->asset_id = $asset->id;            
            $logaction->location_id = NULL;
            $logaction->asset_type = 'hardware';
            $logaction->note = e(Input::get('note'));
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('checkin from');

            // Redirect to the new asset page
            return Redirect::to("hardware")->with('success', Lang::get('admin/hardware/message.checkin.success'));
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
        $asset = Asset::find($assetId);

        if (isset($asset->id)) {

            $settings = Setting::getSettings();

            $qr_code = (object) array(
                'display' => $settings->qr_code == '1',
                'height' => $this->qrCodeDimensions['height'],
                'width' => $this->qrCodeDimensions['width'],
                'url' => route('qr_code/hardware', $asset->id)
            );

            return View::make('backend/hardware/view', compact('asset', 'qr_code'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('assets')->with('error', $error);
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
            if (isset($asset->id)) {


                $renderer = new \BaconQrCode\Renderer\Image\Png;
                $renderer->setWidth($this->qrCodeDimensions['height'])
                ->setHeight($this->qrCodeDimensions['height']);

                $writer = new \BaconQrCode\Writer($renderer);
                $content = $writer->writeString(route('view/hardware', $asset->id));

                $content_disposition = sprintf('attachment;filename=qr_code_%s.png', preg_replace('/\W/', '', $asset->asset_tag));
                $response = Response::make($content, 200);
                $response->header('Content-Type', 'image/png');
                $response->header('Content-Disposition', $content_disposition);
                return $response;
            }
        }

        $response = Response::make('', 404);
        return $response;
    }

    /**
     * Asset update.
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

        // Grab the dropdown list of models
        $model_list = array('' => '') + Model::lists('name', 'id');

        // Grab the dropdown list of status
        $statuslabel_list = array('' => 'Pending') + array('0' => 'Ready to Deploy') + Statuslabel::lists('name', 'id');

        // get depreciation list
        $depreciation_list = array('' => '') + Depreciation::lists('name', 'id');
        $supplier_list = array('' => '') + Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $assigned_to = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat (first_name," ",last_name) as full_name, id'))->whereNull('deleted_at')->lists('full_name', 'id');

          
        $asset = new Asset();
        
        //columns to copy
        $asset->name =              $asset_to_clone->name;
        $asset->serial =            $asset_to_clone->serial;
        $asset->order_number =      $asset_to_clone->order_number;
        $asset->model_id =          $asset_to_clone->model_id;
        $asset->purchase_date =     $asset_to_clone->purchase_date; 
        $asset->purchase_cost =     $asset_to_clone->purchase_cost; 
        $asset->order_number =      $asset_to_clone->order_number; 
        $asset->physical =          $asset_to_clone->physical; 
        $asset->warranty_months =   $asset_to_clone->warranty_months; 
        $asset->depreciate =        $asset_to_clone->depreciate; 
        $asset->supplier_id =       $asset_to_clone->supplier_id; 
        $asset->requestable =       $asset_to_clone->requestable;  
        
        return View::make('backend/hardware/edit')
                ->with('supplier_list',$supplier_list)
                ->with('model_list',$model_list)
                ->with('statuslabel_list',$statuslabel_list)
                ->with('assigned_to',$assigned_to)
                ->with('asset',$asset);

    }
    
    public function getRestore($assetID = null)
    {
        // Check if the location exists
        if (is_null($asset = Asset::onlyTrashed()->find($assetID))) {
            // Redirect to the blogs management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/locations/message.does_not_exist'));
        }
        
        $asset->deleted_at = null;
        $asset->status_id = 1;
        
        //set back to pedning        
        $asset->save();
        
        return Redirect::to('hardware')->with('success', Lang::get('message.restore.success'));
    }
    
    public function getPurge()
    {
        $assets=Asset::onlyTrashed()->forceDelete();
                
        return Redirect::to('hardware')->with('success', Lang::get('message.purge.success'));
    }

}
