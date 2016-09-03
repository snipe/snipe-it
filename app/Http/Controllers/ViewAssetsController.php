<?php
namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
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

        $userlog = $user->userlog->load('item', 'item.model', 'user', 'target');



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
        $models = AssetModel::with('category')->RequestableModels()->get();

        return View::make('account/requestable-assets', compact('user', 'assets', 'models'));
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
        }
        // If it's requested, cancel the request.
        if ($asset->isRequestedBy(Auth::user())) {
            $asset->cancelRequest();
            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        } else {

            $logaction = new Actionlog();
            $logaction->item_id = $data['asset_id'] = $asset->id;
            $logaction->item_type = Asset::class;
            $logaction->created_at = $data['requested_date'] = date("Y-m-d h:i:s");
            $data['asset_type'] = 'hardware';
            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->target_id = $data['user_id'] = Auth::user()->id;
            $logaction->target_type = User::class;
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

            $asset->request();


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
                                    'value' => class_basename(strtoupper($logaction->item_type)).' asset <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.Auth::user()->fullName().'>.'
                                ]

                            ]
                        ])->send('Asset Requested');

                } catch (Exception $e) {

                }

            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }


    }

    public function getRequestedAssets()
    {
        $checkoutrequests = CheckoutRequest::all();

        return View::make('account/requested-items', compact($checkoutrequests));
    }



    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

        if (!$findlog = Actionlog::where('id', $logID)->first()) {
            echo 'no record';
            //return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        }


        $user = Auth::user();

        if ($user->id != $findlog->checkedout_to) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        $item = $findlog->item;

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
        if (is_null($findlog = Actionlog::where('id', $logID)->first())) {
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
            $logaction->item_id      = $findlog->item_id;
            $logaction->item_type    = $findlog->item_type;
        // Asset
        if (($findlog->item_id!='') && ($findlog->item_type==Asset::class)) {
            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                ->where('id', $findlog->item_id)
                ->update(array('assigned_to' => null));
            }
        }
        $logaction->target_id = $findlog->target_id;

        $logaction->note = e(Input::get('note'));
        $logaction->user_id = $user->id;
        $logaction->accepted_at = date("Y-m-d h:i:s");
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('action_logs')
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
