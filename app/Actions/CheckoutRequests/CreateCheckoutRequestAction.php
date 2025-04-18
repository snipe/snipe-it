<?php

namespace App\Actions\CheckoutRequests;

use App\Enums\ActionType;
use App\Exceptions\AssetNotRequestable;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Log;

class CreateCheckoutRequestAction
{
    /**
     * @throws AssetNotRequestable
     * @throws AuthorizationException
     */
    public static function run(Asset $asset, User $user): string
    {
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

        $asset->setLogTarget(auth()->user());
        //$logaction->location_id = $user->location_id ?? null; //??? FIXME - we were setting this logaction's location_id before and now we're not?!
        $asset->logAndSaveIfNeeded(ActionType::Requested);

        $asset->request();
        $asset->increment('requests_counter', 1);
        try {
            $settings->notify(new RequestAssetNotification($data));
        } catch (\Exception $e) {
            Log::warning($e);
        }

        return true;
    }
}