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
use Company;
use Lang;
use Accessory;
use DB;
use Slack;
use Setting;
use Config;
use Mail;
use User;


class ViewAssetsController extends AuthorizedController
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {

      $user = User::with('assets', 'assets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find(Sentry::getUser()->id);

      $userlog = $user->userlog->load('assetlog', 'consumablelog', 'assetlog.model', 'licenselog', 'accessorylog', 'userlog', 'adminlog');



        if (isset($user->id)) {
            return View::make('frontend/account/view-assets', compact('user', 'userlog'));
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

        $user = Sentry::getUser();

    	// Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            // Redirect to the asset management page
            return Redirect::route('requestable-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist_or_not_requestable'));
        }
        else if (!Company::isCurrentUserHasAccess($asset)) {
            return Redirect::route('requestable-assets')->with('error', Lang::get('general.insufficient_permissions'));
        }
        else {

            $logaction = new Actionlog();
            $logaction->asset_id = $data['asset_id'] = $asset->id;
            $logaction->asset_type = $data['asset_type']  = 'hardware';
            $logaction->created_at = $data['requested_date'] = date("Y-m-d h:i:s");

            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->user_id = $data['user_id'] = Sentry::getUser()->id;
            $log = $logaction->logaction('requested');

            $data['requested_by'] = $user->fullName();
            $data['asset_name'] = $asset->showAssetName();

            $settings = Setting::getSettings();

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!Config::get('app.lock_passwords'))) {
                Mail::send('emails.asset-requested', $data, function ($m) use ($user, $settings) {
                	$m->to($settings->alert_email, $settings->site_name);
                	$m->subject('Asset Requested');
                });
            }


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
      						            'title' => 'REQUESTED:',
      						            'value' => strtoupper($logaction->asset_type).' asset <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.Sentry::getUser()->fullName().'>.'
      						        ]

      						    ]
      						])->send('Asset Requested');

      					} catch (Exception $e) {

      					}

      			}

            return Redirect::route('requestable-assets')->with('success')->with('success', Lang::get('admin/hardware/message.requests.success'));
        }


    }



    // Get the acceptance screen
    public function getAcceptAsset($logID = null) {

	    if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }

        $user = Sentry::getUser();

        if ($user->id != $findlog->checkedout_to) {
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.incorrect_user_accepted'));
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
        else if (!Company::isCurrentUserHasAccess($item)) {
            return Redirect::route('requestable-assets')->with('error', Lang::get('general.insufficient_permissions'));
        }
        else {
            return View::make('frontend/account/accept-asset', compact('item'))->with('findlog', $findlog);
        }
    }

    // Save the acceptance
    public function postAcceptAsset($logID = null) {

	  	// Check if the asset exists
        if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }

        // NOTE: make sure the global scope is applied
        $is_unauthorized = is_null(Actionlog::where('id', '=', $logID)->first());
        if ($is_unauthorized) {
            return Redirect::route('requestable-assets')->with('error', Lang::get('general.insufficient_permissions'));
        }

        if ($findlog->accepted_id!='') {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.asset_already_accepted'));
        }

        if (!Input::has('asset_acceptance')) {
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.accept_or_decline'));
        }

    	$user = Sentry::getUser();

        if ($user->id != $findlog->checkedout_to) {
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.incorrect_user_accepted'));
        }

		$logaction = new Actionlog();

        if (Input::get('asset_acceptance')=='accepted') {
            $logaction_msg  = 'accepted';
            $accepted="accepted";
            $return_msg = Lang::get('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted="rejected";
            $return_msg = Lang::get('admin/users/message.declined');
        }

		// Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
        	$logaction->asset_id = $findlog->asset_id;
        	$logaction->accessory_id = NULL;
        	$logaction->asset_type = 'hardware';

            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                ->where('id', $findlog->asset_id)
                ->update(array('assigned_to' => null));
            }


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
		$log = $logaction->logaction($logaction_msg);

		$update_checkout = DB::table('asset_logs')
		->where('id',$findlog->id)
		->update(array('accepted_id' => $logaction->id));

            $affected_asset=$logaction->assetlog;
            $affected_asset->accepted=$accepted;
            $affected_asset->save();

		if ($update_checkout ) {
			return Redirect::to('account/view-assets')->with('success', $return_msg);

		} else {
			return Redirect::to('account/view-assets')->with('error', 'Something went wrong ');
		}
    }
}
