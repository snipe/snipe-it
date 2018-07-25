<?php

namespace App\Http\Controllers\Assets;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckinRequest;
use App\Models\Asset;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class AssetCheckinController extends Controller
{

    /**
     * Returns a view that presents a form to check an asset back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @param string $backto
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function create($assetId, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkin', $asset);
        return view('hardware/checkin', compact('asset'))->with('statusLabel_list', Helper::statusLabelList())->with('backto', $backto);
    }

    /**
     * Validate and process the form data to check an asset back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckinRequest $request
     * @param int $assetId
     * @param null $backto
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function store(AssetCheckinRequest $request, $assetId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkin', $asset);

        if ($asset->assignedType() == Asset::USER) {
            $user = $asset->assignedTo;
        }
        if (is_null($target = $asset->assignedTo)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
        }

        $asset->expected_checkin = null;
        $asset->last_checkout = null;
        $asset->assigned_to = null;
        $asset->assignedTo()->disassociate($asset);
        $asset->assigned_type = null;
        $asset->accepted = null;
        $asset->name = e($request->get('name'));

        if ($request->filled('status_id')) {
            $asset->status_id =  e($request->get('status_id'));
        }

        $asset->location_id = $asset->rtd_location_id;

        if ($request->filled('location_id')) {
            $asset->location_id =  e($request->get('location_id'));
        }

        // Was the asset updated?
        if ($asset->save()) {
            $asset->logCheckin($target, e(request('note')));


            if ($backto=='user') {
                return redirect()->route("users.show", $user->id)->with('success', trans('admin/hardware/message.checkin.success'));
            }
            return redirect()->route("hardware.index")->with('success', trans('admin/hardware/message.checkin.success'));
        }
        // Redirect to the asset management page with error
        return redirect()->route("hardware.index")->with('error', trans('admin/hardware/message.checkin.error'));
    }
}
