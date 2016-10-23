<?php
namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Component;
use App\Models\Setting;
use App\Models\User;
use App\Models\License;
use Auth;
use Config;
use DB;
use Input;
use Lang;
use Mail;
use Redirect;
use Slack;
use Validator;
use View;

/**
 * This controller handles all actions related to the ability for users
 * to view their own assets in the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ViewAssetsController extends Controller
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {

        $user = User::with('assets', 'assets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find(Auth::user()->id);

        $userlog = $user->userlog->load('assetlog', 'consumablelog', 'assetlog.model', 'licenselog', 'accessorylog', 'userlog', 'adminlog');



        if (isset($user->id)) {
            return View::make('account/view-assets', compact('user', 'userlog'));
        } else {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return redirect()->route('users')->with('error', $error);
        }

    }


    public function getRequestableIndex()
    {

        $assets = Asset::with('model', 'defaultLoc', 'assetloc', 'assigneduser')->Hardware()->RequestableAssets()->get();

        return View::make('account/requestable-assets', compact('user', 'assets'));
    }


    public function getRequestAsset($assetId = null)
    {

        $user = Auth::user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            // Redirect to the asset management page
            return redirect()->route('requestable-assets')->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')->with('error', trans('general.insufficient_permissions'));
        } else {

            $logaction = new Actionlog();
            $logaction->asset_id = $data['asset_id'] = $asset->id;
            $logaction->asset_type = $data['asset_type']  = 'hardware';
            $logaction->created_at = $data['requested_date'] = date("Y-m-d h:i:s");

            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->user_id = $data['user_id'] = Auth::user()->id;
            $log = $logaction->logaction('requested');

            $data['requested_by'] = $user->fullName();
            $data['asset_name'] = $asset->showAssetName();

            $settings = Setting::getSettings();

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                Mail::send('emails.asset-requested', $data, function ($m) use ($user, $settings) {
                    $m->to(explode(',', $settings->alert_email), $settings->site_name);
                    $m->subject('Asset Requested');
                });
            }


            if ($settings->slack_endpoint) {


                $slack_settings = [
                    'username' => $settings->botname,
                    'channel' => $settings->slack_channel,
                    'link_names' => true
                ];

                $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

                try {
                        $client->attach([
                            'color' => 'good',
                            'fields' => [
                                [
                                    'title' => 'REQUESTED:',
                                    'value' => strtoupper($logaction->asset_type).' asset <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.Auth::user()->fullName().'>.'
                                ]

                            ]
                        ])->send('Asset Requested');

                } catch (Exception $e) {

                }

            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }


    }



    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

        if (!$findlog = DB::table('asset_logs')->where('id', '=', $logID)->first()) {
            echo 'no record';
            //return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        }


        $user = Auth::user();

        if ($user->id != $findlog->checkedout_to) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
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
        // consumable
        } elseif ($findlog->consumable_id!='') {
            $item = Consumable::find($findlog->consumable_id);
        // components
        } elseif ($findlog->component_id!='') {
            $item = Component::find($findlog->component_id);
        }

        // Check if the asset exists
        if (is_null($item)) {
            // Redirect to the asset management page
            return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->route('requestable-assets')->with('error', trans('general.insufficient_permissions'));
        } else {
            return View::make('account/accept-asset', compact('item'))->with('findlog', $findlog);
        }
    }

    // Save the acceptance
    public function postAcceptAsset($logID = null)
    {

        // Check if the asset exists
        if (is_null($findlog = DB::table('asset_logs')->where('id', '=', $logID)->first())) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        

        if ($findlog->accepted_id!='') {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        if (!Input::has('asset_acceptance')) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        $user = Auth::user();

        if ($user->id != $findlog->checkedout_to) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        $logaction = new Actionlog();

        if (Input::get('asset_acceptance')=='accepted') {
            $logaction_msg  = 'accepted';
            $accepted="accepted";
            $return_msg = trans('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted="rejected";
            $return_msg = trans('admin/users/message.declined');
        }

        // Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
            $logaction->asset_id = $findlog->asset_id;
            $logaction->accessory_id = null;
            $logaction->asset_type = 'hardware';

            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                ->where('id', $findlog->asset_id)
                ->update(array('assigned_to' => null));
            }


        // software
        } elseif (($findlog->asset_id!='') && ($findlog->asset_type=='software')) {
            $logaction->asset_id = $findlog->asset_id;
            $logaction->accessory_id = null;
            $logaction->component_id = null;
            $logaction->asset_type = 'software';

        // accessories
        } elseif ($findlog->accessory_id!='') {
            $logaction->asset_id = null;
            $logaction->component_id = null;
            $logaction->accessory_id = $findlog->accessory_id;
            $logaction->asset_type = 'accessory';
            // accessories
        } elseif ($findlog->consumable_id!='') {
            $logaction->asset_id = null;
            $logaction->accessory_id = null;
            $logaction->component_id = null;
            $logaction->consumable_id = $findlog->consumable_id;
            $logaction->asset_type = 'consumable';
        } elseif ($findlog->component_id!='') {
            $logaction->asset_id = null;
            $logaction->accessory_id = null;
            $logaction->consumable_id = null;
            $logaction->component_id = $findlog->component_id;
            $logaction->asset_type = 'component';
        }

        $logaction->checkedout_to = $findlog->checkedout_to;

        $logaction->note = e(Input::get('note'));
        $logaction->user_id = $user->id;
        $logaction->accepted_at = date("Y-m-d h:i:s");
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('asset_logs')
        ->where('id', $findlog->id)
        ->update(array('accepted_id' => $logaction->id));

            $affected_asset=$logaction->assetlog;
            $affected_asset->accepted=$accepted;
            $affected_asset->save();

        if ($update_checkout) {
            return redirect()->to('account/view-assets')->with('success', $return_msg);

        } else {
            return redirect()->to('account/view-assets')->with('error', 'Something went wrong ');
        }
    }
}
