<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Asset;
use App\Models\User;
use App\Models\Location;

class MigrateDenormedAssetLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Unassigned
        $rtd_assets = Asset::whereNull('assigned_to')->with('defaultLoc')->get();
        \Log::info('Unasigned assets: ');
        foreach ($rtd_assets as $rtd_asset) {
            \Log::info('Setting asset '.$rtd_asset->id.' to  location: '.$rtd_asset->rtd_location_id." Because asset's default location is: ".$rtd_asset->rtd_location_id);
            $rtd_asset->location_id=$rtd_asset->rtd_location_id;
            $rtd_asset->unsetEventDispatcher();
            $rtd_asset->save();
        }

        // Assigned to users - ::with('assignedTo') //can't eager-load polymorphic relations?
        $assigned_user_assets = Asset::where('assigned_type',User::class)->whereNotNull('assigned_to')->get();
        \Log::debug('User-assigned assets:');
        foreach ($assigned_user_assets as $assigned_user_asset) {
            if (($assigned_user_asset->assignedTo) && ($assigned_user_asset->assignedTo->userLoc)) {
                $new_location=$assigned_user_asset->assignedTo->userloc->id;
                \Log::info(' They are in '.$assigned_user_asset->assignedTo->userloc->name.' which is id: '.$new_location);
            } else {
                \Log::info('They have no location! ');
                $new_location=$assigned_user_asset->rtd_location_id;
            }
            $assigned_user_asset->location_id=$new_location;
            $assigned_user_asset->unsetEventDispatcher();
            $assigned_user_asset->save();

        }

        // Assigned to locations // with('assetloc')-> //can't eager-load polymorphic relationships
        $assigned_location_assets = Asset::where('assigned_type',Location::class)->whereNotNull('assigned_to')->get();
        \Log::info('Location-assigned assets: ');
        foreach ($assigned_location_assets as $assigned_location_asset) {
            $assigned_location_asset->location_id=$assigned_location_asset->assignedTo->id;
            \Log::info('(calculated to be: '.$assigned_location_asset->assetLoc());
            $assigned_location_asset->unsetEventDispatcher();
            $assigned_location_asset->save();
        }

        // Assigned to assets
        $assigned_asset_assets = Asset::where('assigned_type',Asset::class)->whereNotNull('assigned_to')->with('assetloc')->get();
        \Log::info('Asset-assigned assets: ');
        foreach ($assigned_asset_assets as $assigned_asset_asset) {
            \Log::info('This asset is: '.$assigned_asset_asset->assignedTo->asset_tag);
            if (($assigned_asset_asset->assignedTo) && ($assigned_asset_asset->assignedTo->location)) {
                \Log::info('They are in '.$assigned_asset_asset->assignedTo->location->name);
            }
            if ($assigned_asset_asset->assetloc) {
                \Log::info('User location is: '.$assigned_asset_asset->assetloc->name);
                \Log::info('Setting asset '.$assigned_asset_asset->id.' location to  '.$assigned_asset_asset->assetloc->id.' ('.$assigned_asset_asset->assetloc->name.')');
                $assigned_asset_asset->location_id=$assigned_asset_asset->assetloc->id;
            }



        }

        $unassigned_assets=Asset::whereNull("location_id")->get();
        foreach($unassigned_assets as $unassigned_asset) {
            \Log::info('Asset: '.$unassigned_asset->id.' still has no location');
        }

        $assets = Asset::get();

        foreach ($assets as $asset) {
            if (($asset)  && ($asset->assetLoc()) && ($asset->location_id != $asset->assetLoc()->id)) {
                \Log::info('MISMATCH MISMATCH '.$asset->id. "doesn't match its location");
            }
        }



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
