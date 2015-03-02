<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Redirect;
use Sentry;
use Validator;
use Location;
use View;
use Asset;
use Actionlog;
use Lang;
use Accessory;
use DB;

class ViewAssetsController extends AuthorizedController
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {
    	$user = Sentry::getUser();


            if (isset($user->id)) {
                return View::make('frontend/account/view-assets', compact('user'));
            } else {
                // Prepare the error message
                $error = Lang::get('admin/users/message.user_not_found', compact('id' ));

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }

	}


	public function getRequestableIndex() {

		$assets = Asset::with('model','defaultLoc')->Hardware()->RequestableAssets()->get();
        return View::make('frontend/account/requestable-assets', compact('user','assets'));
    }


    public function getRequestAsset($assetId = null) {

    	// Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('frontend/account/view-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        } else {


			 return View::make('frontend/account/view-assets', compact('asset'));
        }


    }
    
    
    
    // Get the acceptance screen
    public function getAcceptAsset($logID = null) {
	    
	    if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        
        // Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
        	$item = Asset::find($findlog->asset_id);
        
        // software	
        } elseif (($findlog->asset_id!='') && ($findlog->asset_type=='software')) {     
	        $item = License::find($findlog->asset_id);
	    // accessories    
	    } elseif ($findlog->accessory_id!='') {
		   $item = Accessory::find($findlog->accessory_id);         
        }
        
	    // Check if the asset exists
        if (is_null($item)) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        
        return View::make('frontend/account/accept-asset', compact('item'))->with('findlog', $findlog);
        
        

	    
    }
    
    // Save the acceptance
    public function postAcceptAsset($logID = null) {
	  
	  	
	  	// Check if the asset exists
        if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
                
        
        if ($findlog->accepted_id!='') {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.asset_already_accepted'));
        }
        
    	$user = Sentry::getUser();
		$logaction = new Actionlog();
			
		// Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
        	$logaction->asset_id = $findlog->asset_id;
        	$logaction->accessory_id = NULL;
        	$logaction->asset_type = 'hardware';
        
        // software	
        } elseif (($findlog->asset_id!='') && ($findlog->asset_type=='software')) {     
	        $logaction->asset_id = $findlog->asset_id;
        	$logaction->accessory_id = NULL;
        	$logaction->asset_type = 'software';
        	
		// accessories    
	    } elseif ($findlog->accessory_id!='') {
		    $logaction->asset_id = NULL;
        	$logaction->accessory_id = $findlog->accessory_id;
        	$logaction->asset_type = 'accessory';         
        }
			
		$logaction->checkedout_to = $findlog->checkedout_to;
		
		$logaction->note = e(Input::get('note'));
		$logaction->user_id = $user->id;
		$logaction->accepted_at = date("Y-m-d h:i:s");
		$log = $logaction->logaction('accepted');
		
      
		$update_checkout = DB::table('asset_logs')
			->where('id',$findlog->id)
			->update(array('accepted_id' => $logaction->id));
		
		if ($update_checkout ) {
			return Redirect::to('account/view-assets')->with('success', 'You have successfully accept this asset.');
			
		} else {
			return Redirect::to('account/view-assets')->with('error', 'Something went wrong ');
		}
		
		

  
	    
    }
    



}
