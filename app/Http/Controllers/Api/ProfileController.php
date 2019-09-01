<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CheckoutRequest;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of requested assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.3.0]
     *
     * @return Array
     */
    public function requestedAssets()
    {
        $checkoutRequests = CheckoutRequest::where('user_id', '=', Auth::user()->id)->get();

        $results = [];
        $results['total'] = $checkoutRequests->count();


        foreach ($checkoutRequests as $checkoutRequest) {

            // Make sure the asset and request still exist
            if ($checkoutRequest && $checkoutRequest->itemRequested()) {
                $results['rows'][] = [
                    'image' => $checkoutRequest->itemRequested()->present()->getImageUrl(),
                    'name' => $checkoutRequest->itemRequested()->present()->name(),
                    'type' => $checkoutRequest->itemType(),
                    'qty' => $checkoutRequest->quantity,
                    'location' => ($checkoutRequest->location()) ? $checkoutRequest->location()->name : null,
                    'expected_checkin' => Helper::getFormattedDateObject($checkoutRequest->itemRequested()->expected_checkin, 'datetime'),
                    'request_date' => Helper::getFormattedDateObject($checkoutRequest->created_at, 'datetime'),
                ];
            }

        }
        return $results;
    }


}
