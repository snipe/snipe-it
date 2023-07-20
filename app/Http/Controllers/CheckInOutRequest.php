<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\SnipeModel;
use App\Models\User;

trait CheckInOutRequest
{
    /**
     * Find target for checkout
     * @return SnipeModel        Target asset is being checked out to.
     */
    protected function determineCheckoutTarget()
    {
        // This item is checked out to a location
        switch (request('checkout_to_type')) {
            case 'location':
                return Location::findOrFail(request('assigned_location'));
            case 'asset':
                return Asset::findOrFail(request('assigned_asset'));
            case 'user':
                return User::findOrFail(request('assigned_user'));
        }

        return null;
    }

    /**
     * Update the location of the asset passed in.
     * @param  Asset $asset Asset being updated
     * @param  SnipeModel $target Target with location
     * @return Asset        Asset being updated
     */
    protected function updateAssetLocation($asset, $target)
    {
        switch (request('checkout_to_type')) {
            case 'location':
                $asset->location_id = $target->id;
                Asset::where('assigned_type', 'App\Models\Asset')->where('assigned_to', $asset->id)
                    ->update(['location_id' => $asset->location_id]);
                break;
            case 'asset':
                $asset->location_id = $target->rtd_location_id;
                // Override with the asset's location_id if it has one
                if ($target->location_id != '') {
                    $asset->location_id = $target->location_id;
                }
                break;
            case 'user':
                    $asset->location_id = $target->location_id;
                    break;
        }

        return $asset;
    }
}
