<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Requests\LicenseCheckoutRequest;
use App\Models\Asset;
use App\Models\LicenseModel;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LicenseCheckoutController extends Controller
{
    /**
     * Provides the form view for checking out a license to a user.
     * Here we pass the license seat ID instead of the license ID,
     * because licenses themselves are never checked out to anyone,
     * only the seats associated with them.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param $licenseId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($licenseId)
    {
        // Check that the licenseModel is valid
        if ($licenseModel = LicenseModel::find($licenseId)) {

            // If the licenseModel is valid, check that there is an available seat
            if ($licenseModel->avail_seats_count < 1) {
                return redirect()->route('licenses.index')->with('error', 'There are no available seats for this licenseModel');
            }
        }

        $this->authorize('checkout', $licenseModel);
        return view('licenses/checkout', compact('licenseModel'));
    }


    /**
     * Validates and stores the license checkout action.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param LicenseCheckoutRequest $request
     * @param $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function store(LicenseCheckoutRequest $request, $licenseId, $seatId = null)
    {
        if (!$licenseModel = LicenseModel::find($licenseId)) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $licenseModel);

        $license = $this->findLicenseToCheckout($licenseModel, $seatId);
        $license->user_id = Auth::id();

        $checkoutMethod = 'checkoutTo'.ucwords(request('checkout_to_type'));
        if ($this->$checkoutMethod($license)) {
            return redirect()->route("licenses.index")->with('success', trans('admin/licenses/message.checkout.success'));
        }

        return redirect()->route("licenses.index")->with('error', trans('Something went wrong handling this checkout.'));
    }

    protected function findLicenseToCheckout(LicenseModel $licenseModel, $seatId)
    {
        $license = License::find($seatId) ?? $licenseModel->freeSeat();

        if (!$license) {
            if ($seatId) {
                return redirect()->route('licenses.index')->with('error', 'This Seat is not available for checkout.');
            }
            return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
        }

        if(!$license->license->is($licenseModel)) {
            return redirect()->route('licenses.index')->with('error', 'The license seat provided does not match the license.');
        }

        return $license;
    }

    protected function checkoutToAsset(License $license)
    {
        if (is_null($target = Asset::find(request('asset_id')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
        }
        $license->asset_id = request('asset_id');

        // Override asset's assigned user if available
        if ($target->checkedOutToUser()) {
            $license->assigned_to =  $target->assigned_to;
        }
        if ($license->save()) {
            $license->logCheckout(request('note'), $target);
            return true;
        }
        return false;
    }

    protected function checkoutToUser(License $license)
    {
        // Fetch the target and set the license user
        if (is_null($target = User::find(request('assigned_to')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.user_does_not_exist'));
        }
        $license->assigned_to = request('assigned_to');

        if ($license->save()) {
            $license->logCheckout(request('note'), $target);
            return true;
        }
        return false;
    }
}
