<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelationNotification;
use App\Notifications\RequestAssetNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Redirect;
use DB;

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
            return redirect()->route('users.index')->with('error', $error);
        }
        // Redirect to the user management page
        return redirect()->route('users.index')
            ->with('error', trans('admin/users/message.user_not_found', $user->id));

    }


    /**
     * Returns view of requestable items for a user.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRequestableIndex()
    {

        $assets = Asset::with('model', 'defaultLoc', 'location', 'assignedTo', 'requests')->Hardware()->RequestableAssets()->get();
        $models = AssetModel::with('category', 'requests', 'assets')->RequestableModels()->get();

        return view('account/requestable-assets', compact('assets', 'models'));
    }


    private function logAction($log, $logaction_msg)
    {
        $logaction = new Actionlog();
        $logaction->item_id = $log->item_id;
        $logaction->item_type = $log->item_type;
        // Asset
        if (!empty($log->item_id) && ($log->item_type == Asset::class)) {
            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                    ->where('id', $log->item_id)
                    ->update(array('assigned_to' => null));
            }
        }
        $logaction->target_id = $log->target_id;
        $logaction->target_type = User::class;
        $logaction->note = e(Input::get('note'));
        $logaction->updated_at = date("Y-m-d H:i:s");
        if (isset($sig_filename)) {
            $logaction->accept_signature = $sig_filename;
        }
        $logaction->logaction($logaction_msg);
        $result = DB::table('action_logs')
            ->where('id', $log->id)
            ->update(array('accepted_id' => $logaction->id));
        return [$result, $logaction->item];
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


        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $item->id;
        $logaction->item_type = $fullItemType;
        $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;

        $data['item_quantity'] = Input::has('request-quantity') ? e(Input::get('request-quantity')) : 1;
        $data['requested_by'] = $user->present()->fullName();
        $data['item'] = $item;
        $data['item_type'] = $itemType;
        $data['target'] = Auth::user();


        if ($fullItemType == Asset::class) {
            $data['item_url'] = route('hardware.show', $item->id);
        } else {
            $data['item_url'] = route("view/${itemType}", $item->id);

        }

        $settings = Setting::getSettings();

        if ($item_request = $item->isRequestedBy($user)) {
           $item->cancelRequest();
           $data['item_quantity'] = $item_request->qty;
           $logaction->logaction('request_canceled');

            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                $settings->notify(new RequestAssetCancelationNotification($data));
            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.canceled'));

        } else {
            $item->request();
            if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
                $logaction->logaction('requested');
                $settings->notify(new RequestAssetNotification($data));
            }



            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
        }
    }


    /**
     * Process a specific requested asset
     * @param null $assetId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRequestAsset($assetId = null)
    {

        $user = Auth::user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
        }
        if (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('general.insufficient_permissions'));
        }

        $data['item'] = $asset;
        $data['target'] =  Auth::user();
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $asset->id;
        $logaction->item_type = $data['item_type'] = Asset::class;
        $logaction->created_at = $data['requested_date'] = date("Y-m-d H:i:s");

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;


        // If it's already requested, cancel the request.
        if ($asset->isRequestedBy(Auth::user())) {
            $asset->cancelRequest();
            $asset->decrement('requests_counter', 1);
            
            $logaction->logaction('request canceled');
            $settings->notify(new RequestAssetCancelationNotification($data));
            return redirect()->route('requestable-assets')
                ->with('success')->with('success', trans('admin/hardware/message.requests.cancel-success'));
        }

        $logaction->logaction('requested');
        $asset->request();
        $asset->increment('requests_counter', 1);
        $settings->notify(new RequestAssetNotification($data));


        return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));


    }

    public function getRequestedAssets()
    {
        return view('account/requested');
    }

    public function getBulkAcceptAssets($logsAssets)
    {
        $assetsIds = json_decode(urldecode(base64_decode($logsAssets)));
        $findlogs = [];
        foreach ($assetsIds as $assetId) {
            $findlogs[] = Actionlog::where('id', $assetId)->first();
        }
        if (sizeof($findlogs) != sizeof($assetsIds)) {
            return redirect()->to('account/view-assets')->with('error', 'No matching records.');
        }
        $errors = null;
        $assetList = [];
        $eulaList = [];
        foreach ($findlogs as $log) {
            $this->redirectOnError($log);
            $assetList[] = $log->item->present()->name();
            $eulaList[] = $log->item->getEula();
        }
        $data = [
            "ids" => $logsAssets,
            "eulaList" => $eulaList,
            "assetNames" => $assetList
        ];
        return view('account/accept-asset', $data);
    }

    public function redirectOnError($log)
    {
        // Check if the asset exists
        if (is_null($log)) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        if (!empty($log->accepted_id)) {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }
        if (!Input::has('asset_acceptance')) {
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }
        if (is_null($log->item)) {
            return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        if (!Company::isCurrentUserHasAccess($log->item)) {
            return redirect()->route('requestable-assets')->with('error', trans('general.insufficient_permissions'));
        }
        $user = Auth::user();
        if (($log->item_type==Asset::class) && ($user->id != $log->item->assigned_to)) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }
    }


    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {

        $findlog = Actionlog::where('id', $logID)->first();
        if (!$findlog) {
            return redirect()->to('account/view-assets')->with('error', 'No matching record.');
        }
        $this->redirectOnError($findlog);
        $logObj = array($logID);
        $data = [
            "ids" => urlencode(base64_encode(json_encode($logObj))),
            "eulaList" => $findlog->item->getEula(),
            "assetNames" => $findlog->item->present()->name()
        ];

        return view('account/accept-asset', $data);
    }

    private function saveSignature($log, $signatureOutput)
    {
        $path = config('app.private_uploads').'/signatures';
        $sig_filename = "siglog-".$log->id.'-'.date('Y-m-d-his').".png";
        $data_uri = e($signatureOutput);
        $encoded_image = explode(",", $data_uri);
        $decoded_image = base64_decode($encoded_image[1]);
        file_put_contents($path."/".$sig_filename, $decoded_image);
    }

    private function getAcceptanceStatus()
    {
        if (Input::get('asset_acceptance') == 'accepted') {
            $logaction_msg  = 'accepted';
            $accepted="accepted";
            $return_msg = trans('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted="rejected";
            $return_msg = trans('admin/users/message.declined');
        }
        return [$logaction_msg, $accepted, $return_msg];
    }

    public function postAcceptAsset(Request $request)
    {
        $logs = json_decode(base64_decode(urldecode($request->get('logId'))));
        list($logaction_msg, $accepted, $return_msg) = $this->getAcceptanceStatus();
        foreach ($logs as $log) {
            $findlog = Actionlog::where('id', $log)->first();
            $this->redirectOnError($findlog);
            if ($request->filled('signature_output')) {
                $this->saveSignature($findlog, $request->get('signature_output'));
            }
            list($update_checkout, $affected_asset) = $this->logAction($findlog, $logaction_msg);
            if (!empty($findlog->item_id) && ($findlog->item_type==Asset::class)) {
                $affected_asset->accepted = $accepted;
                $affected_asset->save();
            }
        }
        if ($update_checkout) {
            return redirect()->to('account/view-assets')->with('success', $return_msg);
        } else {
            return redirect()->to('account/view-assets')->with('error', 'Something went wrong');
        }
    }
}
