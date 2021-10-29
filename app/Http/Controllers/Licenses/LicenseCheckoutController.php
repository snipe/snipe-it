<?php

namespace App\Http\Controllers\Licenses;

use App\Events\CheckoutableCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Requests\LicenseCheckoutRequest;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        // Check that the license is valid
        if ($license = License::find($licenseId)) {

            // If the license is valid, check that there is an available seat
            if ($license->avail_seats_count < 1) {
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
        if (! $license = License::find($licenseId)) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $license);

        $licenseSeat = $this->findLicenseSeatToCheckout($license, $seatId);
        $licenseSeat->user_id = Auth::id();

        $checkoutMethod = 'checkoutTo'.ucwords(request('checkout_to_type'));
        if ($this->$checkoutMethod($licenseSeat)) {
            return redirect()->route('licenses.index')->with('success', trans('admin/licenses/message.checkout.success'));
        }

        return redirect()->route('licenses.index')->with('error', trans('Something went wrong handling this checkout.'));
    }

    protected function findLicenseSeatToCheckout($license, $seatId)
    {
        $licenseSeat = LicenseSeat::find($seatId) ?? $license->freeSeat();

        if (! $licenseSeat) {
            if ($seatId) {
                return redirect()->route('licenses.index')->with('error', 'This Seat is not available for checkout.');
            }

            return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
        }

        if (! $licenseSeat->license->is($license)) {
            return redirect()->route('licenses.index')->with('error', 'The license seat provided does not match the license.');
        }

        return $licenseSeat;
    }

    protected function checkoutToAsset($licenseSeat)
    {
        if (is_null($target = Asset::find(request('asset_id')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
        }
        $licenseSeat->asset_id = request('asset_id');

        // Override asset's assigned user if available
        if ($target->checkedOutToUser()) {
            $licenseSeat->assigned_to = $target->assigned_to;
        }
        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedOut($licenseSeat, $target, Auth::user(), request('note')));

            return true;
        }

        return false;
    }

    protected function checkoutToUser($licenseSeat)
    {
        // Fetch the target and set the license user
        if (is_null($target = User::find(request('assigned_to')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.user_does_not_exist'));
        }
        $licenseSeat->assigned_to = request('assigned_to');

        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedOut($licenseSeat, $target, Auth::user(), request('note')));

            return true;
        }

        return false;
    }
}
