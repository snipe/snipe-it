<?php

namespace App\Actions\CheckoutRequests;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;

class CancelCheckoutRequest
{
    public static function run(Asset $asset, User $user)
    {
        $asset->cancelRequest();

        $asset->decrement('requests_counter', 1);

        $data['item'] = $asset;
        $data['target'] = $user;
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = Actionlog::create([
            'item_id'     => $data['asset_id'] = $asset->id,
            'item_type'   => $data['item_type'] = Asset::class,
            'created_at'  => $data['requested_date'] = date('Y-m-d H:i:s'),
            'target_id'   => $data['user_id'] = auth()->id(),
            'target_type' => User::class,
            'location_id' => $user->location_id ?? null,
        ]);
        $logaction->logaction('request canceled');

        try {
            $settings->notify(new RequestAssetCancelation($data));
        } catch (\Exception $e) {
            \Log::warning($e);
        }

        return true;
    }

}