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

            $this->authorize('checkout', $license);
            // If the license is valid, check that there is an available seat
            if ($license->avail_seats_count < 1) {
                return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
            }
            return view('licenses/checkout', compact('license'));
        }

        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));


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
                throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect()->route('licenses.index')->with('error', 'This Seat is not available for checkout.'));
            }
            
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect()->route('licenses.index')->with('error', 'There are no available seats for this license.'));
        }

        if (! $licenseSeat->license->is($license)) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect()->route('licenses.index')->with('error', 'The license seat provided does not match the license.'));
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

    /**
     * Bulk checkin all license seats
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicenseCheckinController::create() method that provides the form view
     * @since [v6.1.1]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function bulkCheckout($licenseId) {

        \Log::debug('Checking out '.$licenseId.' via bulk');
        $license = License::findOrFail($licenseId);
        $this->authorize('checkin', $license);
        $avail_count = $license->getAvailSeatsCountAttribute();

        $users = User::whereNull('deleted_at')->where('autoassign_licenses', '=', 1)->with('licenses')->get();
        \Log::debug($avail_count.' will be assigned');

        if ($users->count() > $avail_count) {
            \Log::debug('You do not have enough free seats to complete this task, so we will check out as many as we can. ');
        }

        // If the license is valid, check that there is an available seat
        if ($license->availCount()->count() < 1) {
            return redirect()->back()->with('error', trans('admin/licenses/general.bulk.checkout_all.error_no_seats'));
        }


        $assigned_count = 0;

        foreach ($users as $user) {

            // Check to make sure this user doesn't already have this license checked out to them
            if ($user->licenses->where('id', '=', $licenseId)->count()) {
                \Log::debug($user->username.' already has this license checked out to them. Skipping... ');
                continue;
            }

            $licenseSeat = $license->freeSeat();

            // Update the seat with checkout info
            $licenseSeat->assigned_to = $user->id;

            if ($licenseSeat->save()) {
                $avail_count--;
                $assigned_count++;
                $licenseSeat->logCheckout(trans('admin/licenses/general.bulk.checkout_all.log_msg'), $user);
                \Log::debug('License '.$license->name.' seat '.$licenseSeat->id.' checked out to '.$user->username);
            }

            if ($avail_count ==  0) {
                return redirect()->back()->with('warning', trans('admin/licenses/general.bulk.checkout_all.warn_not_enough_seats', ['count' => $assigned_count]));
            }
        }

        if ($assigned_count ==  0) {
            return redirect()->back()->with('warning', trans('admin/licenses/general.bulk.checkout_all.warn_no_avail_users', ['count' => $assigned_count]));
        }

        return redirect()->back()->with('success', trans_choice('admin/licenses/general.bulk.checkout_all.success', 2, ['count' => $assigned_count] ));


    }
}
