<?php
namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
<<<<<<< HEAD
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Component;
use App\Models\Setting;
use App\Models\User;
use App\Models\License;
=======
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Setting;
use App\Models\User;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
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

<<<<<<< HEAD
        $user = User::with('assets', 'assets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find(Auth::user()->id);

        $userlog = $user->userlog->load('assetlog', 'consumablelog', 'assetlog.model', 'licenselog', 'accessorylog', 'userlog', 'adminlog');


=======
        $user = User::with(
            'assets',
            'assets.model',
            'consumables',
            'accessories',
            'licenses',
            'userloc',
            'userlog'
        )->withTrashed()->find(Auth::user()->id);


        $userlog = $user->userlog->load('item', 'user', 'target');
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
<<<<<<< HEAD

        return View::make('account/requestable-assets', compact('user', 'assets'));
    }


=======
        $models = AssetModel::with('category')->RequestableModels()->get();

        return View::make('account/requestable-assets', compact('user', 'assets', 'models'));
    }

    public function getRequestedIndex()
    {
        $requestedItems = CheckoutRequest::with('user', 'requestedItem')->get();
        return View::make('admin/requested-assets', compact('requestedItems'));
    }


    public function getRequestItem($itemType, $itemId = null)
    {
        $item = null;
        $fullItemType = 'App\\Models\\' . studly_case($itemType);
        if ($itemType == "asset_model") {
            $itemType = "model";
        }
        $item = call_user_func(array($fullItemType, 'find'), $itemId);
        $user = Auth::user();
        $quantity = $data['item_quantity'] = Input::has('request-quantity') ? e(Input::get('request-quantity')) : 1;

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $item->id;
        $logaction->item_type = $fullItemType;
        $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");
        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;

        $data['requested_by'] = $user->fullName();
        $data['item_name'] = $item->name;
        $data['item_type'] = $itemType;

        if ($fullItemType == Asset::class) {
            $data['item_url'] = route('view/hardware', $item->id);
            $slackMessage = ' Asset <'.config('app.url').'/hardware/'.$item->id.'/view'.'|'.$item->showAssetName().'> requested by <'.config('app.url').'/users/'.$item->user_id.'/view'.'|'.$user->fullName().'>.';
        } else {
            $data['item_url'] = route("view/${itemType}", $item->id);
            $slackMessage = $quantity. ' ' . class_basename(strtoupper($logaction->item_type)).' <'.$data['item_url'].'|'.$item->name.'> requested by <'.config('app.url').'/user/'.$item->id.'/view'.'|'.$user->fullName().'>.';
        }

        $settings = Setting::getSettings();

        if ($settings->slack_endpoint) {

            $slack_settings = [
                'username' => $settings->botname,
                'channel' => $settings->slack_channel,
                'link_names' => true
            ];

            $slackClient = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);
        }

        if ($item->isRequestedBy($user)) {

            $item->cancelRequest();
            $log = $logaction->logaction('request_canceled');

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                Mail::send('emails.asset-canceled', $data, function ($m) use ($user, $settings) {
                    $m->to(explode(',', $settings->alert_email), $settings->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Item_Request_Canceled'));
                });
            }

            if ($settings->slack_endpoint) {
                try {
                        $slackClient->attach([
                            'color' => 'good',
                            'fields' => [
                                [
                                    'title' => 'CANCELED:',
                                    'value' => $slackMessage
                                ]

                            ]
                        ])->send('Item Request Canceled');

                } catch (Exception $e) {

                }
            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.canceled'));

        } else {
            $item->request();

            $log = $logaction->logaction('requested');


            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                Mail::send('emails.asset-requested', $data, function ($m) use ($user, $settings) {
                    $m->to(explode(',', $settings->alert_email), $settings->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Item_Requested'));
                });
            }

            if ($settings->slack_endpoint) {
                try {
                        $slackClient->attach([
                            'color' => 'good',
                            'fields' => [
                                [
                                    'title' => 'REQUESTED:',
                                    'value' => $slackMessage
                                ]

                            ]
                        ])->send('Item Requested');

                } catch (Exception $e) {

                }
            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }
    }
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    public function getRequestAsset($assetId = null)
    {

        $user = Auth::user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            // Redirect to the asset management page
            return redirect()->route('requestable-assets')->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')->with('error', trans('general.insufficient_permissions'));
<<<<<<< HEAD
        } else {

            $logaction = new Actionlog();
            $logaction->asset_id = $data['asset_id'] = $asset->id;
            $logaction->asset_type = $data['asset_type']  = 'hardware';
            $logaction->created_at = $data['requested_date'] = date("Y-m-d h:i:s");

            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->user_id = $data['user_id'] = Auth::user()->id;
=======
        }
        // If it's requested, cancel the request.
        if ($asset->isRequestedBy(Auth::user())) {
            $asset->cancelRequest();
            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        } else {

            $logaction = new Actionlog();
            $logaction->item_id = $data['asset_id'] = $asset->id;
            $logaction->item_type = Asset::class;
            $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");
            $data['asset_type'] = 'hardware';
            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->target_id = $data['user_id'] = Auth::user()->id;
            $logaction->target_type = User::class;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
            $log = $logaction->logaction('requested');

            $data['requested_by'] = $user->fullName();
            $data['asset_name'] = $asset->showAssetName();

            $settings = Setting::getSettings();

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                Mail::send('emails.asset-requested', $data, function ($m) use ($user, $settings) {
                    $m->to(explode(',', $settings->alert_email), $settings->site_name);
<<<<<<< HEAD
                    $m->subject('Asset Requested');
                });
            }

=======
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.asset_requested'));
                });
            }

            $asset->request();

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
<<<<<<< HEAD
                                    'value' => strtoupper($logaction->asset_type).' asset <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.Auth::user()->fullName().'>.'
=======
                                    'value' => class_basename(strtoupper($logaction->item_type)).' asset <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.Auth::user()->fullName().'>.'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
                                ]

                            ]
                        ])->send('Asset Requested');

                } catch (Exception $e) {

                }

            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }


    }

<<<<<<< HEAD
=======
    public function getRequestedAssets()
    {
        $checkoutrequests = CheckoutRequest::all();

        return View::make('account/requested-items', compact($checkoutrequests));
    }

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72


    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

<<<<<<< HEAD
        if (!$findlog = DB::table('asset_logs')->where('id', '=', $logID)->first()) {
=======
        if (!$findlog = Actionlog::where('id', $logID)->first()) {
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
            echo 'no record';
            //return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        }


        $user = Auth::user();

        if ($user->id != $findlog->checkedout_to) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

<<<<<<< HEAD
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
=======
        $item = $findlog->item;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
<<<<<<< HEAD
        if (is_null($findlog = DB::table('asset_logs')->where('id', '=', $logID)->first())) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        
=======
        if (is_null($findlog = Actionlog::where('id', $logID)->first())) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
<<<<<<< HEAD

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
=======
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
        $logaction->accepted_at = date("Y-m-d H:i:s");
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('action_logs')
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
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
