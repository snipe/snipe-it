<?php

namespace App\Actions\CheckoutRequests;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use Illuminate\Auth\Access\AuthorizationException;

class CancelCheckoutRequestAction
{
    public static function run(Asset $asset, User $user)
    {
        if (!Company::isCurrentUserHasAccess($asset)) {
            throw new AuthorizationException();
        }

        $asset->cancelRequest();

        $asset->decrement('requests_counter', 1);

        $data['item'] = $asset;
        $data['target'] = $user;
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $asset->setLogTarget(auth()->user());
        $asset->setLogLocationOverride($user->location_id);
        $asset->logAndSaveIfNeeded(ActionType::RequestCanceled);

        try {
            $settings->notify(new RequestAssetCancelation($data));
        } catch (\Exception $e) {
            \Log::warning($e);
        }

        return true;
    }

}