<?php

namespace App\Http\Controllers\Assets;

use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;

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
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Asset $asset) : View | RedirectResponse
    {

        $this->authorize('checkout', $asset);

        if (!$asset->model) {
            return redirect()->route('hardware.show', $asset)
                ->with('error', trans('admin/hardware/general.model_invalid_fix'));
        }

        if ($asset->availableForCheckout()) {
            return view('hardware/checkout', compact('asset'))
                ->with('statusLabel_list', Helper::deployableStatusLabelList())
                ->with('table_name', 'Assets')
                ->with('item', $asset);
        }

        return redirect()->route('hardware.index')
            ->with('error', trans('admin/hardware/message.checkout.not_available'));
    }

    /**
     * Validate and process the form data to check out an asset to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckoutRequest $request
     * @since [v1.0]
     */
    public function store(AssetCheckoutRequest $request, $assetId) : RedirectResponse
    {
        try {
            // Check if the asset exists
            if (! $asset = Asset::find($assetId)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            } elseif (! $asset->availableForCheckout()) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
            }
            $this->authorize('checkout', $asset);

            if (!$asset->model) {
                return redirect()->route('hardware.show', $asset)->with('error', trans('admin/hardware/general.model_invalid_fix'));
            }
            
            $asset->setLogTarget($this->determineCheckoutTarget());

            // $asset = $this->updateAssetLocation($asset, $target); not needed? handled by checkout?

            // $checkout_at = date('Y-m-d H:i:s'); //TODO - make sure this gets set to a sensible default?
            if (($request->filled('checkout_at')) && ($request->get('checkout_at') != date('Y-m-d'))) {
                $asset->setLogDate(new Carbon($request->get('checkout_at')));
            }

            //$expected_checkin = '';
            if ($request->filled('expected_checkin')) {
                $asset->expected_checkin = $request->get('expected_checkin');
            }

            if ($request->filled('status_id')) {
                $asset->status_id = $request->get('status_id');
            }


            // This is a kinda weird feature. If we have a bunch of licenses checked out to an _asset_,
            // and then we check out the _asset_ to a user, those licenses transfer over to the user?
            // I don't understand why we would even do that, tbh.
            // FIXME or document or something?
            // and if we *were* going to do this, it should be in Asset, not here.
            if(!empty($asset->licenseseats->all())){
                if(request('checkout_to_type') == 'user') {
                    foreach ($asset->licenseseats as $seat){
                        $seat->assigned_to = $asset->getLogTarget()->id; //this could get really weird, really quick? FIXME
                        $seat->save(); //FIXME - not transactionalized.
                    }
                }
            }

            if ($request->has('name')) {
                $asset->name = $request->get('name');
            }

            if ($request->has('note')) {
                $asset->setLogNote($request->get('note'));
            }

            // Add any custom fields that should be included in the checkout
            $asset->customFieldsForCheckinCheckout('display_checkout');

            $settings = \App\Models\Setting::getSettings();

            // We have to check whether $target->company_id is null here since locations don't have a company yet
            if (($settings->full_multiple_companies_support) && ((!is_null($asset->getLogTarget()->company_id)) && (!is_null($asset->company_id)))) {
                if ($asset->getLogTarget()->company_id != $asset->company_id) {
                    return redirect()->route('hardware.checkout.create', $asset)->with('error', trans('general.error_user_company'));
                }
            }

            session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);

            if ($asset->checkOutAndSave()) { // $target, $admin, $checkout_at, $expected_checkin, $request->get('note'), $request->get('name')
                return redirect()->to(Helper::getRedirectOption($request, $asset->id, 'Assets'))
                    ->with('success', trans('admin/hardware/message.checkout.success'));
            }
            // Redirect to the asset management page with error
            return redirect()->route("hardware.checkout.create", $asset)->with('error', trans('admin/hardware/message.checkout.error').$asset->getErrors());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (CheckoutNotAllowed $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
