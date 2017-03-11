<?php
namespace App\Http\Transformers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class LocationsTransformer
{

    public function transformLocations (Collection $locations, $total)
    {
        $array = array();
        foreach ($locations as $location) {
            $array[] = self::transformLocation($location);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLocation (Location $location = null)
    {
        if ($location) {

            $assets_arr = [];
            foreach($location->assets() as $asset) {
                $assets_arr = ['id' => $asset->id];
            }

            $array = [
                'id' => e($location->id),
                'name' => e($location->name),
                'address' => e($location->address),
                'city' => e($location->city),
                'state' => e($location->state),
                'assets_checkedout' => $location->assets()->count(),
                'assets_default'    => $location->assignedassets()->count(),
                'country' => e($location->country),
                'assets' => $assets_arr,
                'created_at' => Helper::getFormattedDateObject($location->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($location->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Location::class) ? true : false,
                'delete' => Gate::allows('delete', Location::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
