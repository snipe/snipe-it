<?php

namespace App\Actions\CheckoutRequests;

use App\Exceptions\NoActiveCheckoutRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class CancelCheckoutRequestAction
{
    /**
     * @throws AuthorizationException
     * @throws NoActiveCheckoutRequest
     */
    public static function run(Asset $asset, User $user)
    {
        if (! Company::isCurrentUserHasAccess($asset)) {
            throw new AuthorizationException;
        }

        // Cancel + counter decrement share a transaction, and the
        // decrement is gated on the actual affected row count.
        // Previously this method unconditionally decremented by 1
        // regardless of whether the caller had an active request,
        // driving the shared requests_counter negative on no-op calls.
        // The pending-state filter inside cancelRequest() plus this
        // affected-count gate together keep the counter honest.
        $affected = DB::transaction(function () use ($asset) {
            $affected = $asset->cancelRequest();
            if ($affected > 0) {
                $asset->decrement('requests_counter', $affected);
            }

            return $affected;
        });

        if ($affected === 0) {
            throw new NoActiveCheckoutRequest;
        }

        $data['item'] = $asset;
        $data['target'] = $user;
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = new Actionlog;
        $logaction->item_id = $data['asset_id'] = $asset->id;
        $logaction->item_type = $data['item_type'] = Asset::class;
        $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');
        $logaction->target_id = $data['user_id'] = auth()->id();
        $logaction->target_type = User::class;
        $logaction->location_id = $user->location_id ?? null;
        $logaction->logaction('request canceled');

        try {
            $settings->notify(new RequestAssetCancelation($data));
        } catch (\Exception $e) {
            \Log::warning($e);
        }

        return true;
    }
}
