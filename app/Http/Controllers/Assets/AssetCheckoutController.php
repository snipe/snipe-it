<?php

namespace App\Http\Controllers\Assets;

use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssetCheckoutController extends Controller
{
    use CheckInOutRequest;

    /**
     * Returns a view that presents a form to check an asset out to a
     * user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    public function create(Request $request, $assetId)
    {

        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);

        if ($asset->availableForCheckout()) {

            /**
             * Set a session variable here for the possible return url - this may or may not be used
             * in the store() method below, but we need to set it here, so we know what "back" means.
             * We set this here so that we don't end up with UX weirdness if our referrer isn't what we're
             * expecting (for example a checkout that happens from a place we didn't plan for yet.
             * - @snipe - 2022-12-22
             */
            $request->session()->forget('backto_item_type');
            $request->session()->forget('backto_item_id');
            \Log::debug('dropping session data for backto_item_type and backto_item_id');

            // Hard-coding this for now, since we're only workiing with assets, not other first-class items yet
            $request->session()->put('backto_item_type', '\App\Models\Asset');
            $request->session()->put('backto_item_id', $assetId);
            \Log::debug('setting new session data for asset '. $assetId . ' via backto_item_type and backto_item_id');

            return view('hardware/checkout', compact('asset'))
                ->with('statusLabel_list', Helper::deployableStatusLabelList());
        }


        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
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

        $asset = Asset::find($assetId);
        $this->authorize('checkout', $asset);



        try {
            // Check if the asset exists
            if (!$asset) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            } elseif (!$asset->availableForCheckout()) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
            }

            $this->authorize('checkout', $asset);

            $admin = Auth::user();
            $target = $this->determineCheckoutTarget($asset);
            $asset = $this->updateAssetLocation($asset, $target);
            $expected_checkin = '';
            $checkout_at = date('Y-m-d H:i:s');

            if (($request->filled('checkout_at')) && ($request->get('checkout_at') != date('Y-m-d'))) {
                $checkout_at = $request->get('checkout_at');
            }

            if ($request->filled('expected_checkin')) {
                $expected_checkin = $request->get('expected_checkin');
            }

            if ($request->filled('status_id')) {
                $asset->status_id = $request->get('status_id');
            }

            if ($request->filled('next_action')) {
                $back_to_route = $request->get('next_action');
            }

            if(!empty($asset->licenseseats->all())) {

                if (request('checkout_to_type') == 'user') {
                    foreach ($asset->licenseseats as $seat){
                        $seat->assigned_to = $target->id;
                        $seat->save();
                    }
                }

            }

            if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($request->get('note')), $request->get('name'))) {

                if ($request->get('accept_in_person')=='1') {
                    return view('hardware/checkout', compact('asset'))
                        ->with('statusLabel_list', Helper::deployableStatusLabelList());
                }

                return redirect()->route($back_to_route)->with('success', trans('admin/hardware/message.checkout.success'));
            }

            // Redirect to the asset page with error
            return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error').$asset->getErrors());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (CheckoutNotAllowed $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
