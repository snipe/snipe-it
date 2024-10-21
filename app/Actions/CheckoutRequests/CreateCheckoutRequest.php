<?php

namespace App\Actions\CheckoutRequests;

use App\Exceptions\AssetNotRequestable;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use App\Notifications\RequestAssetNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateCheckoutRequest
{
    /**
     * @throws AssetNotRequestable
     * @throws AuthorizationException
     */
    public static function run(Asset $asset, User $user): string
    {
        // Check if asset is requestable
        if (is_null(Asset::RequestableAssets()->find($asset->id))) {
            throw new AssetNotRequestable($asset);
        }
        if (!Company::isCurrentUserHasAccess($asset)) {
            throw new AuthorizationException();
        }

        $data['item'] = $asset;
        $data['target'] = $user;
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $asset->id;
        $logaction->item_type = $data['item_type'] = Asset::class;
        $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = auth()->id();
        $logaction->target_type = User::class;

        // If it's already requested, cancel the request.
        if ($asset->isRequestedBy(auth()->user())) {
            $asset->cancelRequest();
            $asset->decrement('requests_counter', 1);

            $logaction->logaction('request canceled');
            try {
                $settings->notify(new RequestAssetCancelation($data));
            } catch (\Exception $e) {
                \Log::warning($e);
            }
            return $status = 'cancelled';
        }

        $logaction->logaction('requested');
        $asset->request();
        $asset->increment('requests_counter', 1);
        try {
            $settings->notify(new RequestAssetNotification($data));
        } catch (\Exception $e) {
            \Log::warning($e);
        }

        return $asset;
    }


}