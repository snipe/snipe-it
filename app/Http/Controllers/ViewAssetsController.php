<?php
namespace App\Http\Controllers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetNotification;
use App\Notifications\RequestAssetCancelationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Redirect;
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
        )->withTrashed()->find(Auth::id());


        $userlog = $user->userlog->load('item', 'user', 'target');

        if (isset($user->id)) {
            return view('account/view-assets', compact('user', 'userlog'));
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

        }
        $item->request();
        if (($settings->alert_email!='')  && ($settings->alerts_enabled=='1') && (!config('app.lock_passwords'))) {
            $logaction->logaction('requested');
            $settings->notify(new RequestAssetNotification($data));
        }


        return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
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


    // Get the acceptance screen
    public function getAcceptAsset($logID = null)
    {
        return redirect()->route('account.accept');
    }
}
