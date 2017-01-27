<?php
namespace App\Http\Transformers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

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
            $transformed = [
                'id' => e($location->id),
                'name' => e($location->name),
                'address' => e($location->address),
                'city' => e($location->city),
                'state' => e($location->state),
                'assets_checkedout' => $location->assets()->count(),
                'assets_default'    => $location->assignedassets()->count(),
                'country' => e($location->country),
            ];
            return $transformed;
        }


    }



}
