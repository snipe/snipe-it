<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetCheckoutController extends Controller
{
    /**
    * Returns a view that presents a form to check an asset out to a
    * user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function create($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);

        if ($asset->availableForCheckout()) {
            return view('hardware/checkout', compact('asset'));
        }
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));

        // Get the dropdown of users and then pass it to the checkout view

    }

    /**
     * Validate and process the form data to check out an asset to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckoutRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     */
    public function store(AssetCheckoutRequest $request, $assetId)
    {
        // Check if the asset exists
        if (!$asset = Asset::find($assetId)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!$asset->availableForCheckout()) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
        }
        $this->authorize('checkout', $asset);
        $admin = Auth::user();


        // This item is checked out to a location
        if (request('checkout_to_type')=='location') {
            $target = Location::find(request('assigned_location'));
            $asset->location_id = ($target) ? $target->id : '';

        } elseif (request('checkout_to_type')=='asset') {

            if (request('assigned_asset') == $assetId) {
                return redirect()->back()->with('error', 'You cannot check an asset out to itself.');
            }

            $target = Asset::where('id','!=',$assetId)->find(request('assigned_asset'));
            $asset->location_id = $target->rtd_location_id;

            // Override with the asset's location_id if it has one
            if ($target->location_id!='') {
                $asset->location_id = ($target) ? $target->location_id : '';
            }

        } elseif (request('checkout_to_type')=='user') {
            // Fetch the target and set the asset's new location_id
            $target = User::find(request('assigned_user'));
            $asset->location_id = ($target) ? $target->location_id : '';
        }

        // No valid target was found - error out
        if (!$target) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        }


        if (($request->has('checkout_at')) && ($request->get('checkout_at')!= date("Y-m-d"))) {
            $checkout_at = $request->get('checkout_at');
        } else {
            $checkout_at = date("Y-m-d H:i:s");
        }

        if ($request->has('expected_checkin')) {
            $expected_checkin = $request->get('expected_checkin');
        } else {
            $expected_checkin = '';
        }


        if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($request->get('note')), $request->get('name'))) {
            return redirect()->route("hardware.index")->with('success', trans('admin/hardware/message.checkout.success'));
        }

        // Redirect to the asset management page with error
        return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
    }
}
