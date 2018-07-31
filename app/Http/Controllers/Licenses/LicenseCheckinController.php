<?php

namespace App\Http\Controllers\Licenses;

use App\Models\Asset;
use App\Models\LicenseModel;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @param int $licenseId
     * @param string $backTo
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($licenseId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($license = License::find($licenseId)) || is_null($licenseModel = LicenseModel::find($license->license_id))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $licenseModel);
        return view('licenses/checkin', compact('license'))->with('backto', $backTo);
    }


    /**
     * Validates and stores the license checkin action.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicenseCheckinController::create() method that provides the form view
     * @since [v1.0]
     * @param int $licenseId
     * @param string $backTo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store($licenseId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $licenseModel = LicenseModel::find($license->license_id);
        $this->authorize('checkout', $licenseModel);

        if (!$licenseModel->reassignable) {
            // Not allowed to checkin
            Session::flash('error', 'LicenseModel not reassignable.');
            return redirect()->back()->withInput();
        }

        // Declare the rules for the form validation
        $rules = [
            'note'   => 'string',
            'notes'   => 'string',
        ];

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $return_to = User::find($license->assigned_to);

        // Update the asset data
        $license->assigned_to                   = null;
        $license->asset_id                      = null;

        // Was the asset updated?
        if ($license->save()) {
            $license->logCheckin($return_to, e(request('note')));
            if ($backTo=='user') {
                return redirect()->route("users.show", $return_to->id)->with('success', trans('admin/licenses/message.checkin.success'));
            }
            return redirect()->route("licenses.show", $license->license_id)->with('success', trans('admin/licenses/message.checkin.success'));
        }

        // Redirect to the licenseModel page with error
        return redirect()->route("licenses.index")->with('error', trans('admin/licenses/message.checkin.error'));
    }

}
