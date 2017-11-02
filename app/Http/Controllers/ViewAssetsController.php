<?php
namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Setting;
use App\Models\User;
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
use Illuminate\Http\Request;

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

        $user = User::with(
            'assets.model',
            'consumables',
            'accessories',
            'licenses',
            'userloc',
            'userlog'
        )->withTrashed()->find(Auth::user()->id);


        $userlog = $user->userlog->load('item', 'user', 'target');

        if (isset($user->id)) {
            return view('account/view-assets', compact('user', 'userlog'));
        } else {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return redirect()->route('users')->with('error', $error);
        }

    }


    public function getRequestableIndex()
    {

        $assets = Asset::with('model', 'defaultLoc', 'location', 'assignedTo', 'requests')->Hardware()->RequestableAssets()->get();
        $models = AssetModel::with('category', 'requests', 'assets')->RequestableModels()->get();

        return view('account/requestable-assets', compact('user', 'assets', 'models'));
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

        $data['requested_by'] = $user->present()->fullName();
        $data['item_name'] = $item->name;
        $data['item_type'] = $itemType;

        if ($fullItemType == Asset::class) {
            $data['item_url'] = route('hardware.show', $item->id);
            $slackMessage = ' Asset <'.url('/').'/hardware/'.$item->id.'/view'.'|'.$item->present()->name().'> requested by <'.url('/').'/users/'.$item->user_id.'/view'.'|'.$user->present()->fullName().'>.';
        } else {
            $data['item_url'] = route("view/${itemType}", $item->id);
            $slackMessage = $quantity. ' ' . class_basename(strtoupper($logaction->item_type)).' <'.$data['item_url'].'|'.$item->name.'> requested by <'.url('/').'/user/'.$item->id.'/view'.'|'.$user->present()->fullName().'>.';
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
            $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");
            $data['asset_type'] = 'hardware';
            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->target_id = $data['user_id'] = Auth::user()->id;
            $logaction->target_type = User::class;
            $log = $logaction->logaction('requested');

            $data['requested_by'] = $user->present()->fullName();
            $data['asset_name'] = $asset->present()->name();

            $settings = Setting::getSettings();

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                Mail::send('emails.asset-requested', $data, function ($m) use ($user, $settings) {
                    $m->to(explode(',', $settings->alert_email), $settings->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.asset_requested'));
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
                                    'value' => class_basename(strtoupper($logaction->item_type)).' asset <'.url('/').'/hardware/'.$asset->id.'/view'.'|'.$asset->present()->name().'> requested by <'.url('/').'/hardware/'.$asset->id.'/view'.'|'.Auth::user()->present()->fullName().'>.'
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

        return view('account/requested-items', compact($checkoutrequests));
    }



    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

        if (!$findlog = Actionlog::where('id', $logID)->first()) {
            echo 'no record';
            //return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if ($findlog->accepted_id!='') {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        $user = Auth::user();


        if ($user->id != $findlog->item->assigned_to) {
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
            return view('account/accept-asset', compact('item'))->with('findlog', $findlog)->with('item', $item);
        }
    }

    // Save the acceptance
    public function postAcceptAsset(Request $request, $logID = null)
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
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        $user = Auth::user();

        if ($user->id != $findlog->item->assigned_to) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if ($request->has('signature_output')) {
            $path = config('app.private_uploads').'/signatures';
            $sig_filename = "siglog-".$findlog->id.'-'.date('Y-m-d-his').".png";
            $data_uri = e($request->get('signature_output'));
            $encoded_image = explode(",", $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);
            file_put_contents($path."/".$sig_filename, $decoded_image);
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
        $logaction->target_type = User::class;
        $logaction->note = e(Input::get('note'));
        $logaction->updated_at = date("Y-m-d H:i:s");


        if (isset($sig_filename)) {
            $logaction->accept_signature = $sig_filename;
        }
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('action_logs')
        ->where('id', $findlog->id)
        ->update(array('accepted_id' => $logaction->id));

            $affected_asset = $logaction->item;
            $affected_asset->accepted = $accepted;
            $affected_asset->save();

        if ($update_checkout) {
            return redirect()->to('account/view-assets')->with('success', $return_msg);

        } else {
            return redirect()->to('account/view-assets')->with('error', 'Something went wrong ');
        }
    }
}
