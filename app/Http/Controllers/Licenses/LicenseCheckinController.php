<?php

namespace App\Http\Controllers\Licenses;

use App\Events\CheckoutableCheckedIn;
use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LicenseCheckinController extends Controller
{

    /**
     * Makes the form view to check a license seat back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $seatId
     * @param string $backTo
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($seatId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($licenseSeat = LicenseSeat::find($seatId)) || is_null($license = License::find($licenseSeat->license_id))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $license);
        return view('licenses/checkin', compact('licenseSeat'))->with('backto', $backTo);
    }

    public function bulkcreate($licenseId, $asset = null, $user = null, $backTo = null)
    {
        $license = License::find($licenseId);
        $this->authorize('checkout', $license);
        return view('licenses/bulkcheckin', compact('license', 'asset', 'user'))->with('backto', $backTo);
    }

    /**
     * Validates and stores the license checkin action.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicenseCheckinController::create() method that provides the form view
     * @since [v1.0]
     * @param int $seatId
     * @param string $backTo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $seatId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($licenseSeat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $license = License::find($licenseSeat->license_id);

        // Declare the rules for the form validation
        $rules = [
            'note'   => 'string|nullable',
        ];

        $requestValid = $this->validateStoreRequest($request, $license, $rules);
        if ($requestValid !== true) {
            return $requestValid;
        }

        $return_to = User::find($licenseSeat->assigned_to);

        $licenseUnassign = $this->unassignLicenseSeat($licenseSeat, $return_to, $request->input('note'));
        if ($licenseUnassign === true) {
            if ($backTo=='user') {
                return redirect()->route("users.show", $return_to->id)->with('success', trans('admin/licenses/message.checkin.success'));
            }
            return redirect()->route("licenses.show", $licenseSeat->license_id)->with('success', trans('admin/licenses/message.checkin.success'));
        }
        return $licenseUnassign;
    }

    /**
     * Validates and stores the license bulk checkin action.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @author [Michael Pietsch] [<skywalker-11@mi-pietsch.de>]
     * @see LicenseCheckinController::bulkcreate() method that provides the form view
     * @since [v5.0]
     * @param int $licenseId
     * @param string $backTo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bulkstore(Request $request, $licenseId = null, $backTo = null)
    {
        $license = License::find($licenseId);

        // Declare the rules for the form validation
        $rules = [
            'checkout_to_type' => 'in:asset,user',
            'note'             => 'string|nullable',
            'qty'              => 'int',
            'asset_id'         => 'required_if:checkout_to_type,==,asset|nullable',
            'assigned_to'      => 'required_if:checkout_to_type,==,user|nullable',
        ];

        if (($request->checkout_to_type == 'asset' && empty($request->asset_id)) ||
            ($request->checkout_to_type == 'user'  && empty($request->assigned_to)) ||
            ($request->checkout_to_type != 'asset' && $request->checkout_to_type != 'user')) {

            return redirect()->back()->withInput()->with('error', 'Invalid formular');
        }

        $requestValid = $this->validateStoreRequest($request, $license, $rules);
        if ($requestValid !== true) {
            return $requestValid;
        }

        //get license seats matching requested license and user/asset
        $return_from = null;
        $licenseSeatsToCheckin = LicenseSeat::where('license_id', $license->id);
        if (!empty($request->assigned_to)) {
            $return_from = User::find($request->assigned_to);
            $licenseSeatsToCheckin = $licenseSeatsToCheckin->where('assigned_to', $request->assigned_to);
        } elseif (!empty($request->asset_id)) {
            $return_from = Asset::find($request->asset_id);
            $licenseSeatsToCheckin = $licenseSeatsToCheckin->where('asset_id', $request->asset_id);
        }

        //check if the number of license seats we found matches the requested number
        $licenseSeatsToCheckin = $licenseSeatsToCheckin->take($request->qty)->get();
        if ($licenseSeatsToCheckin->count() != $request->qty) {
            return redirect()->route('licenses.show', $license->id)->with('error', 'Not enough license seat assigned to be checked in: only ' . $licenseSeatsToCheckin->count() .'/' . $request->qty);
        }

        //unassign the license seats
        foreach($licenseSeatsToCheckin as $licenseSeat) {
            $licenseUnassign = $this->unassignLicenseSeat($licenseSeat, $return_from, $request->input('note'));
            if($licenseUnassign !== true) {
                return $licenseUnassign;
            }
        }

        if ($backTo=='user') {
            return redirect()->route("users.show", $return_to->id)->with('success', trans('admin/licenses/message.checkin.success'));
        }

        return redirect()->route("licenses.show", $licenseSeat->license_id)->with('success', trans('admin/licenses/message.checkin.success'));
    }

    protected function validateStoreRequest($request, $license, $rules) {
        if (is_null($license)) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }
        $this->authorize('checkout', $license);

        if (!$license->reassignable) {
            // Not allowed to checkin
            Session::flash('error', 'License not reassignable.');
            return redirect()->back()->withInput();
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make($request->all(), $rules);
        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return redirect()->back()->withInput()->withErrors($validator);
        }
        return true;
    }

    protected function unassignLicenseSeat($licenseSeat, $return_from, $note)
    {
        // Update the asset data
        $licenseSeat->assigned_to                   = null;
        $licenseSeat->asset_id                      = null;

        // Was the asset updated?
        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedIn($licenseSeat, $return_from, Auth::user(), $note));

            return true;
        }

        // Redirect to the license page with error
        return redirect()->route("licenses.index")->with('error', trans('admin/licenses/message.checkin.error'));
    }
}
