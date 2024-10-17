<?php

namespace App\Actions\CheckoutRequests;

use App\Actions\BaseAction;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use App\Notifications\RequestAssetNotification;

class CreateCheckoutRequestNew extends BaseAction
{
    //public string $status = '';

    static function run($assetId): string
    {
        dump($assetId);
        $user = auth()->user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            return $status = 'doesNotExist';
        }
        if (!Company::isCurrentUserHasAccess($asset)) {
            return $status = 'accessDenied';
        }

        $data['item'] = $asset;
        $data['target'] = auth()->user();
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
        dump('handle end');

        return $status = 'success';
    }


}