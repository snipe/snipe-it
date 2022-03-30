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
        $this->authorize('checkout', $license);

        if (! $license->reassignable) {
            // Not allowed to checkin
            Session::flash('error', 'License not reassignable.');

            return redirect()->back()->withInput();
        }

        // Declare the rules for the form validation
        $rules = [
            'note'   => 'string|nullable',
        ];

        // Create a new validator instance from our validation rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if($licenseSeat->assigned_to != null){
            $return_to = User::find($licenseSeat->assigned_to);
        } else {
            $return_to = Asset::find($licenseSeat->asset_id);
        }

        // Update the asset data
        $licenseSeat->assigned_to = null;
        $licenseSeat->asset_id = null;

        // Was the asset updated?
        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedIn($licenseSeat, $return_to, Auth::user(), $request->input('note')));

            if ($backTo == 'user') {
                return redirect()->route('users.show', $return_to->id)->with('success', trans('admin/licenses/message.checkin.success'));
            }

            return redirect()->route('licenses.show', $licenseSeat->license_id)->with('success', trans('admin/licenses/message.checkin.success'));
        }

        // Redirect to the license page with error
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkin.error'));
    }
}
