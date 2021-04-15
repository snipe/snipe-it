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
            foreach($location->children as $child) {
                $children_arr[] = [
                    'id' => (int) $child->id,
                    'name' => $child->name
                ];
            }

            $array = [
                'id' => (int) $location->id,
                'name' => e($location->name),
                'image' =>   ($location->image) ? app('locations_upload_url').e($location->image) : null,
                'address' =>  ($location->address) ? e($location->address) : null,
                'address2' =>  ($location->address2) ? e($location->address2) : null,
                'city' =>  ($location->city) ? e($location->city) : null,
                'state' =>  ($location->state) ? e($location->state) : null,
                'country' => ($location->country) ? e($location->country) : null,
                'zip' => ($location->zip) ? e($location->zip) : null,
                'assigned_assets_count' => (int) $location->assigned_assets_count,
                'assets_count'    => (int) $location->assets_count,
                'users_count'    => (int) $location->users_count,
                'currency' =>  ($location->currency) ? e($location->currency) : null,
                'created_at' => Helper::getFormattedDateObject($location->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($location->updated_at, 'datetime'),
                'parent' => ($location->parent) ? [
                    'id' => (int) $location->parent->id,
                    'name'=> e($location->parent->name)
                ] : null,
                'manager' => ($location->manager) ? (new UsersTransformer)->transformUser($location->manager) : null,
                'bitrix_id' =>  ($location->bitrix_id) ? (int) $location->bitrix_id : null,
                'children' => $children_arr,
                'notes' =>  ($location->notes) ? e($location->notes) : null,
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Location::class) ? true : false,
                'delete' => (Gate::allows('delete', Location::class) && ($location->assigned_assets_count==0) && ($location->assets_count==0) && ($location->users_count==0) && ($location->deleted_at=='')) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }

    public function transformCollectionForMap(Collection $locations)
    {
        $array = array();
        foreach ($locations as $location) {
            $array[] = self::transformForMap($location);
        }
        $objects_array['type'] = "FeatureCollection";
        $objects_array['features'] = $array;
        return $objects_array;

    }

    public function transformForMap(Location $location = null)
    {
        if ($location) {
            $cords= [];
            if ($location->coordinates){
                $cords = explode(",", $location->coordinates);
            }
            $count = 0 ;
            if ($location->assets){
                $assets = $location->assets;
                foreach ($assets as $asset) {
                    $asset_tag = $asset->asset_tag;
                    $first_s = substr( $asset_tag, 0, 1 );
                    if ($first_s == "I" || $first_s =="X" || strlen($asset_tag)>7){
                        $count++;
                    }
                }
            }

            $array = [
                "id" => (int) $location->id,
                "type"=> "Feature",
                "geometry"=> [
                    "type"=> "Point",
                    "coordinates"=>$cords,
                ],
                "properties"=> [
                    "balloonContentHeader"=>e($location->name),
                    "balloonContentBody" =>  "Адрес: ".e($location->address)."<br>"."Активов: ".e($location->assets_count)."<br>"."Инвентаризированно: ".$count,
                    "balloonContentFooter"=>"",
                    "hintContent"=> e($location->name)
                ]
            ];
            return $array;
        }else{
            return [];
        }
    }

}
