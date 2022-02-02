<?php

namespace App\Http\Controllers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use App\Notifications\RequestAssetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return view('account/view-assets', compact('user', 'userlog'))
                ->with('settings', Setting::getSettings());
        } else {
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', trans('admin/users/message.user_not_found', compact('id')));
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
        $assets = Asset::with('model', 'defaultLoc', 'location', 'assignedTo', 'requests')->Hardware()->RequestableAssets();
        $models = AssetModel::with('category', 'requests', 'assets')->RequestableModels()->get();

        return view('account/requestable-assets', compact('assets', 'models'));
    }

    public function getRequestItem(Request $request, $itemType, $itemId = null)
    {
        $item = null;
        $fullItemType = 'App\\Models\\'.studly_case($itemType);

        if ($itemType == 'asset_model') {
            $itemType = 'model';
        }
        $item = call_user_func([$fullItemType, 'find'], $itemId);

        $user = Auth::user();

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $item->id;
        $logaction->item_type = $fullItemType;
        $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;

        $data['item_quantity'] = $request->has('request-quantity') ? e($request->input('request-quantity')) : 1;
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

            if (($settings->alert_email != '') && ($settings->alerts_enabled == '1') && (! config('app.lock_passwords'))) {
                $settings->notify(new RequestAssetCancelation($data));
            }

            return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.canceled'));
        } else {
            $item->request();
            if (($settings->alert_email != '') && ($settings->alerts_enabled == '1') && (! config('app.lock_passwords'))) {
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
        if (! Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('general.insufficient_permissions'));
        }

        $data['item'] = $asset;
        $data['target'] = Auth::user();
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $asset->id;
        $logaction->item_type = $data['item_type'] = Asset::class;
        $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');

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
            $settings->notify(new RequestAssetCancelation($data));

            return redirect()->route('requestable-assets')
                ->with('success')->with('success', trans('admin/hardware/message.requests.cancel'));
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

    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {
        $findlog = Actionlog::where('id', $logID)->first();

        if (! $findlog) {
            return redirect()->to('account/view-assets')->with('error', 'No matching record.');
        }

        if ($findlog->accepted_id != '') {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        $user = Auth::user();

        // TODO - Fix this for non-assets
        if (($findlog->item_type == Asset::class) && ($user->id != $findlog->item->assigned_to)) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        $item = $findlog->item;

        // Check if the asset exists
        if (is_null($item)) {
            // Redirect to the asset management page
            return redirect()->to('account')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (! Company::isCurrentUserHasAccess($item)) {
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

        if ($findlog->accepted_id != '') {
            // Redirect to the asset management page
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }

        if ($request->missing('asset_acceptance')) {
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        $user = Auth::user();

        if (($findlog->item_type == Asset::class) && ($user->id != $findlog->item->assigned_to)) {
            return redirect()->to('account/view-assets')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if ($request->filled('signature_output')) {
            $path = config('app.private_uploads').'/signatures';
            $sig_filename = 'siglog-'.$findlog->id.'-'.date('Y-m-d-his').'.png';
            $data_uri = e($request->get('signature_output'));
            $encoded_image = explode(',', $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);

            Storage::putFileAs($path, $decoded_image, $sig_filename);
            //file_put_contents($path.'/'.$sig_filename, $decoded_image);
        }

        $logaction = new Actionlog();

        if ($request->input('asset_acceptance') == 'accepted') {
            $logaction_msg = 'accepted';
            $accepted = 'accepted';
            $return_msg = trans('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted = 'rejected';
            $return_msg = trans('admin/users/message.declined');
        }
        $logaction->item_id = $findlog->item_id;
        $logaction->item_type = $findlog->item_type;

        // Asset
        if (($findlog->item_id != '') && ($findlog->item_type == Asset::class)) {
            if ($request->input('asset_acceptance') != 'accepted') {
                DB::table('assets')
                ->where('id', $findlog->item_id)
                ->update(['assigned_to' => null]);
            }
        }

        $logaction->target_id = $findlog->target_id;
        $logaction->target_type = User::class;
        $logaction->note = e($request->input('note'));
        $logaction->updated_at = date('Y-m-d H:i:s');

        if (isset($sig_filename)) {
            $logaction->accept_signature = $sig_filename;
        }
        $log = $logaction->logaction($logaction_msg);

        $update_checkout = DB::table('action_logs')
        ->where('id', $findlog->id)
        ->update(['accepted_id' => $logaction->id]);

        if (($findlog->item_id != '') && ($findlog->item_type == Asset::class)) {
            $affected_asset = $logaction->item;
            $affected_asset->accepted = $accepted;
            $affected_asset->save();
        }

        if ($update_checkout) {
            return redirect()->to('account/view-assets')->with('success', $return_msg);
        } else {
            return redirect()->to('account/view-assets')->with('error', 'Something went wrong ');
        }
    }
}
