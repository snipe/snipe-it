<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LicenseSeatsTransformer;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LicenseSeatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $licenseId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $licenseId)
    {
        //
        if ($license = License::find($licenseId)) {
            $this->authorize('view', $license);

            $seats = LicenseSeat::with('license', 'user', 'asset', 'user.department')
                ->where('license_seats.license_id', $licenseId);

            $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

            if ($request->input('sort') == 'department') {
                $seats->OrderDepartments($order);
            } else {
                $seats->orderBy('id', $order);
            }

            $total = $seats->count();
            $offset = (($seats) && (request('offset') > $total)) ? 0 : request('offset', 0);
            $limit = request('limit', 50);

            $seats = $seats->skip($offset)->take($limit)->get();

            if ($seats) {
                return (new LicenseSeatsTransformer)->transformLicenseSeats($seats, $total);
            }
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/licenses/message.does_not_exist')), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $licenseId
     * @param  int  $seatId
     * @return \Illuminate\Http\Response
     */
    public function show($licenseId, $seatId)
    {
        //
        $this->authorize('view', License::class);
        // sanity checks:
        // 1. does the license seat exist?
        if (! $licenseSeat = LicenseSeat::find($seatId)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Seat not found'));
        }
        // 2. does the seat belong to the specified license?
        if (! $license = $licenseSeat->license()->first() || $license->id != intval($licenseId)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Seat does not belong to the specified license'));
        }

        return (new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $licenseId
     * @param  int  $seatId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $licenseId, $seatId)
    {
        $this->authorize('checkout', License::class);

        // sanity checks:
        // 1. does the license seat exist?
        if (! $licenseSeat = LicenseSeat::find($seatId)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Seat not found'));
        }
        // 2. does the seat belong to the specified license?
        if (! $license = $licenseSeat->license()->first() || $license->id != intval($licenseId)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Seat does not belong to the specified license'));
        }

        $oldUser = $licenseSeat->user()->first();
        $oldAsset = $licenseSeat->asset()->first();

        // attempt to update the license seat
        $licenseSeat->fill($request->all());
        $licenseSeat->user_id = Auth::user()->id;

        // check if this update is a checkin operation
        // 1. are relevant fields touched at all?
        $touched = $licenseSeat->isDirty('assigned_to') || $licenseSeat->isDirty('asset_id');
        // 2. are they cleared? if yes then this is a checkin operation
        $is_checkin = ($touched && $licenseSeat->assigned_to === null && $licenseSeat->asset_id === null);

        if (! $touched) {
            // nothing to update
            return response()->json(Helper::formatStandardApiResponse('success', $licenseSeat, trans('admin/licenses/message.update.success')));
        }

        // the logging functions expect only one "target". if both asset and user are present in the request,
        // we simply let assets take precedence over users...
        if ($licenseSeat->isDirty('assigned_to')) {
            $target = $is_checkin ? $oldUser : User::find($licenseSeat->assigned_to);
        }
        if ($licenseSeat->isDirty('asset_id')) {
            $target = $is_checkin ? $oldAsset : Asset::find($licenseSeat->asset_id);
        }

        if (is_null($target)){
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Target not found'));
        }

        if ($licenseSeat->save()) {

            if ($is_checkin) {
                $licenseSeat->logCheckin($target, $request->input('note'));

                return response()->json(Helper::formatStandardApiResponse('success', $licenseSeat, trans('admin/licenses/message.update.success')));
            }

            // in this case, relevant fields are touched but it's not a checkin operation. so it must be a checkout operation.
            $licenseSeat->logCheckout($request->input('note'), $target);

            return response()->json(Helper::formatStandardApiResponse('success', $licenseSeat, trans('admin/licenses/message.update.success')));
        }

        return Helper::formatStandardApiResponse('error', null, $licenseSeat->getErrors());
    }
}
