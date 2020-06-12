<?php
namespace App\Http\Transformers;

use App\Models\Location;
use App\Enums\AssetTypes;
use App\Enums\States;
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


                'children' => $children_arr,
            ];

            // Add stock items if added
            foreach (AssetTypes::$typePluralNames as $key => $value) {
              if (isset($location->$value))
                $array[$value] = (int)$location->$value;
            }

            // Add total
            if (isset($location->total))
              $array['total'] = $location->total;

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Location::class) ? true : false,
                'delete' => (Gate::allows('delete', Location::class) && ($location->assigned_assets_count==0) && ($location->assets_count==0) && ($location->users_count==0) && ($location->deleted_at=='')) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }
    }

    public function transformItemLocations(Collection $locations, $total)
    {
        $array = array();
        foreach ($locations as $location) {
            $array[] = self::transformItemLocation($location);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformItemLocation(Location $location = null)
    {
        if ($location) {    
            $array = [
                'id' => (int) $location->id,
                'name' => e($location->name),
                'image' =>   ($location->image) ? app('locations_upload_url').e($location->image) : null,
                'manager' => ($location->manager) ? (new UsersTransformer)->transformUser($location->manager) : null,
                'item_type' => $location->item_type,
                'item_id' => $location->item_id,
            ];
    
            // Add stock states if added
            foreach (States::$all_states as $value) {
              if (isset($location->$value))
              $array[$value] = (int)$location->$value;
            }

            // Add total
            if (isset($location->total))
              $array['total'] = $location->total;

            $permissions_array['available_actions'] = [
                'checkout' => Gate::allows('checkout', Accessory::class) ? true : false,
                'checkin' =>  false,    
                'invadjusts' => true,
                'invreconciles' => true,
                'invtransfers' => true,    
            ];

            $permissions_array['user_can_checkout'] = false;

            $in_stock_name = States::IN_STOCK;
            if ($location->$in_stock_name > 0) {
                $permissions_array['user_can_checkout'] = true;
            }

            $array += $permissions_array;

            return $array;
        }
    }
}
