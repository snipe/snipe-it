<?php

namespace App\Http\Controllers\Assets;

use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Traits\DocumentGeneratorTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AssetCheckoutController extends Controller
{
    use CheckInOutRequest;
    use DocumentGeneratorTrait;

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
        if (is_null($asset = Asset::with('company')->find(e($assetId)))) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $asset);

        if (!$asset->model) {
            return redirect()->route('hardware.show', $asset->id)->with('error', trans('admin/hardware/general.model_invalid_fix'));
        }

        if ($asset->availableForCheckout()) {
            return view('hardware/checkout', compact('asset'))
                ->with('statusLabel_list', Helper::deployableStatusLabelList())
                ->with('table_name', 'Assets');
        }


        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
    }

    /**
     * Validate and process the form data to check out an asset to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckoutRequest $request
     * @param int $assetId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v1.0]
     */
    public function store(AssetCheckoutRequest $request, $assetId)
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
                return redirect()->route('hardware.show', $asset->id)->with('error', trans('admin/hardware/general.model_invalid_fix'));
            }

            $admin = Auth::user();

            $target = $this->determineCheckoutTarget();

            $asset = $this->updateAssetLocation($asset, $target);

            $checkout_at = date('Y-m-d H:i:s');
            if (($request->filled('checkout_at')) && ($request->get('checkout_at') != date('Y-m-d'))) {
                $checkout_at = $request->get('checkout_at');
            }

            $expected_checkin = '';
            if ($request->filled('expected_checkin')) {
                $expected_checkin = $request->get('expected_checkin');
            }

            if ($request->filled('status_id')) {
                $asset->status_id = $request->get('status_id');
            }

            if(!empty($asset->licenseseats->all())){
                if(request('checkout_to_type') == 'user') {
                    foreach ($asset->licenseseats as $seat){
                        $seat->assigned_to = $target->id;
                        $seat->save();
                    }
                }
            }
            
            if(request('checkout_to_type') == 'location') {
                $asset_ids = [$asset->id];
                $file_name = $this->generate_checkout_checkin($asset_ids,$target,$checkout_at,'Attribution');
                Session::flash('downloadfile', $file_name);
            }

            

            # add responsable name and mat in note
            $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->get('note').' )';

            if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($note), $request->get('name'))) {
                
                return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.checkout.success'));
            }
            // Redirect to the asset management page with error
            return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error').$asset->getErrors());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
        } catch (CheckoutNotAllowed $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
