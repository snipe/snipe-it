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
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        } else {


			 return View::make('frontend/account/view-asset', compact('asset'));
        }


    }
    
    
    
    // Get the acceptance screen
    public function getAcceptAsset($assetId = null) {
	    
	    // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        
        return View::make('frontend/account/accept-asset', compact('asset'));
        
        

	    
    }
    
    // Save the acceptance
    public function postAcceptAsset($assetId = null) {
	  
	  	// Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        
        	$user = Sentry::getUser();
        
     
			$logaction = new Actionlog();
			$logaction->asset_id = $assetId;
			$logaction->checkedout_to = $asset->assigned_to;
			$logaction->asset_type = 'hardware';
			$logaction->note = e(Input::get('note'));
			$logaction->user_id = $user->id;
			$logaction->accepted_at = date("Y-m-d h:i:s");
			$log = $logaction->logaction('accepted');
			
			return Redirect::to('account/view-assets')->with('success', 'You have successfully accept this asset.');
		

  
	    
    }
    
     // Save the acceptance
    public function postAcceptAccessory($accessoryUserID = null) {
	  
	  	// Check if the asset exists
	

        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }
        	$accessory = Accessory::find($accessory_user->accessory_id);
        
        	$user = Sentry::getUser();
        
     
			$logaction = new Actionlog();
			$logaction->asset_id = $accessory->id;
			$logaction->checkedout_to = $accessory->assigned_to;
			$logaction->asset_type = 'accessory';
			$logaction->note = e(Input::get('note'));
			$logaction->user_id = $user->id;
			$logaction->accepted_at = date("Y-m-d h:i:s");
			$log = $logaction->logaction('accepted');
			
			return Redirect::to('account/view-assets')->with('success', 'You have successfully accept this asset.');
		
	    
    }




}
