<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Requests\LicenseCheckoutRequest;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
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
     * @param $licenceId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($licenceId)
    {
        // Check that the license is valid
        if ($license = License::where('id',$licenceId)->first()) {

            // If the license is valid, check that there is an available seat
            if ($license->getAvailSeatsCountAttribute() < 1) {
                return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
            }
        }

        $this->authorize('checkout', $license);
        return view('licenses/checkout', compact('license'));
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
        $license = License::find($licenseId);
        if (!$license) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $license);

        // This returns null if seatId is null
        if (!$licenseSeat = LicenseSeat::find($seatId);) {
            $licenseSeat = $license->freeSeat();
        }

        if (!$licenseSeat) {
            if ($seatId) {
                return redirect()->route('licenses.index')->with('error', 'This Seat is not available for checkout.');
            }
            return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
        }

        $target = null;

        // This item is checked out to a an asset
        if (request('checkout_to_type')=='asset') {
            if (is_null($target = Asset::find(request('asset_id')))) {
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
            }
            $licenseSeat->asset_id = $request->input('asset_id');

            // Override asset's assigned user if available
            if ($target->checkedOutToUser()) {
                $licenseSeat->assigned_to =  $target->assigned_to;
            }

        } elseif (request('checkout_to_type')=='user') {

            // Fetch the target and set the license user
            if (is_null($target = User::find(request('assigned_to')))) {
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.user_does_not_exist'));
            }
            $licenseSeat->assigned_to = request('assigned_to');
        }

        $licenseSeat->user_id = Auth::id();

        if ($licenseSeat->save()) {
            $licenseSeat->logCheckout($request->input('note'), $target);
            return redirect()->route("licenses.index")->with('success', trans('admin/licenses/message.checkout.success'));
        }
    }
}
