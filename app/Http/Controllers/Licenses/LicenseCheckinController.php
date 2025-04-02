<?php

namespace App\Http\Controllers\Licenses;

use App\Events\CheckoutableCheckedIn;
use App\Helpers\Helper;
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
use Illuminate\Support\Facades\Log;

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
    public function create(LicenseSeat $licenseSeat, $backTo = null)
    {
        // Check if the asset exists
        $license = License::find($licenseSeat->license_id);
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

        // LicenseSeat is not assigned, it can't be checked in
        if (is_null($licenseSeat->assigned_to) && is_null($licenseSeat->asset_id)) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkin.error'));
        }

        $this->authorize('checkout', $license);

        if (!$license->reassignable) { // FIXME/TODO - should _this_ go into the checkin method? YES! No?
            // Not allowed to checkin
            Session::flash('error', trans('admin/licenses/message.checkin.not_reassignable') . '.');

            return redirect()->back()->withInput();
        }

        if($licenseSeat->assigned_to != null){
            $licenseSeat->setLogTarget(User::find($licenseSeat->assigned_to));
        } else {
            $licenseSeat->setLogTarget(Asset::find($licenseSeat->asset_id));
        }

        $licenseSeat->notes = $request->input('notes'); //huh. Weird.
        $licenseSeat->setLogNote($request->input('notes')); //yeah, weird.

        session()->put(['redirect_option' => $request->get('redirect_option')]);


        // Was the asset updated?
        if ($licenseSeat->checkInAndSave()) { //here is the thing - this becomes ->logAndSaveIfNeeded()
            return redirect()->to(Helper::getRedirectOption($request, $license->id, 'Licenses'))->with('success', trans('admin/licenses/message.checkin.success'));
        }

        // Redirect to the license page with error
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkin.error'));
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

    public function bulkCheckin(Request $request, $licenseId) {

        $license = License::findOrFail($licenseId);
        $this->authorize('checkin', $license);

        if (! $license->reassignable) {
            // Not allowed to checkin
            Session::flash('error', 'License not reassignable.');

            return redirect()->back()->withInput();
        }

        $licenseSeatsByUser = LicenseSeat::where('license_id', '=', $licenseId)
            ->whereNotNull('assigned_to')
            ->with('user')
            ->get();

        foreach ($licenseSeatsByUser as $user_seat) {
            $user_seat->assigned_to = null; //FIXME/TODO - is this already handled in the checkin method?

            $user_seat->setLogNote(trans('admin/licenses/general.bulk.checkin_all.log_msg'));
            if ($user_seat->checkInAndSave()) {
                Log::debug('Checking in '.$license->name.' from user '.$user_seat->username);
            }
        }

        $licenseSeatsByAsset = LicenseSeat::where('license_id', '=', $licenseId)
            ->whereNotNull('asset_id')
            ->with('asset')
            ->get();

        $count = 0;
        foreach ($licenseSeatsByAsset as $asset_seat) {
            $asset_seat->asset_id = null; //FIXME/TODO - don't we have this already?

            $asset_seat->setLogNote(trans('admin/licenses/general.bulk.checkin_all.log_msg'));
            if ($asset_seat->checkInAndSave()) {
                Log::debug('Checking in '.$license->name.' from asset '.$asset_seat->asset_tag);
                $count++;
            }
        }

        return redirect()->back()->with('success', trans_choice('admin/licenses/general.bulk.checkin_all.success', 2, ['count' => $count] ));

    }

}
