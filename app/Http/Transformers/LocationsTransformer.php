<?php
namespace App\Http\Transformers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class LocationsTransformer
{

    public function transformLocations(Collection $locations, $total)
    {
        $array = array();
        foreach ($locations as $location) {
            $array[] = self::transformLocation($location);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLocation(Location $location = null)
    {
        if ($location) {

            $children_arr = [];
            foreach($location->childLocations as $child) {
                $children_arr[] = [
                    'id' => (int) $child->id,
                    'name' => $child->name
                ];
            }

            $array = [
                'id' => (int) $location->id,
                'name' => e($location->name),
                'address' => e($location->address),
                'city' => e($location->city),
                'state' => e($location->state),
                'country' => e($location->country),
                'zip' => e($location->zip),
                'assets_checkedout' => $location->location_assets_count,
                'assets_default'    => $location->assigned_assets_count,

                'created_at' => Helper::getFormattedDateObject($location->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($location->updated_at, 'datetime'),
                'parent' => ($location->parent) ? [
                    'id' => (int) $location->parent->id,
                    'name'=> e($location->parent->name)
                ] : null,
                'manager' => ($location->manager) ? (new UsersTransformer)->transformUser($location->manager) : null,


                'children' => $children_arr,
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
