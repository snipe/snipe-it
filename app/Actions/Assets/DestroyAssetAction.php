<?php

namespace App\Actions\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;


class DestroyAssetAction
{
    public static function run(Asset $asset)
    {
        if ($asset->assignedTo) {

            $target = $asset->assignedTo;
            $checkin_at = date('Y-m-d H:i:s');
            $originalValues = $asset->getRawOriginal();
            event(new CheckoutableCheckedIn($asset, $target, auth()->user(), 'Checkin on delete', $checkin_at, $originalValues));
            DB::table('assets')
                ->where('id', $asset->id)
                ->update(['assigned_to' => null]);
        }


        if ($asset->image) {
            try {
                Storage::disk('public')->delete('assets'.'/'.$asset->image);
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        $asset->delete();
    }

}