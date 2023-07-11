<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Location;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class LocationsTransformer
{
    public function transformLocations(Collection $locations, $total)
    {
        $array = [];
        foreach ($locations as $location) {
            $array[] = self::transformLocation($location);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLocation(Location $location = null)
    {
        if ($location) {
            $children_arr = [];
            if (! is_null($location->children)) {
                foreach ($location->children as $child) {
                    $children_arr[] = [
                        'id' => (int) $child->id,
                        'name' => $child->name,
                    ];
                }
            }

            $array = [
                'id' => (int) $location->id,
                'name' => e($location->name),
                'image' =>   ($location->image) ? Storage::disk('public')->url('locations/'.e($location->image)) : null,
                'address' =>  ($location->address) ? e($location->address) : null,
                'address2' =>  ($location->address2) ? e($location->address2) : null,
                'city' =>  ($location->city) ? e($location->city) : null,
                'state' =>  ($location->state) ? e($location->state) : null,
                'country' => ($location->country) ? e($location->country) : null,
                'zip' => ($location->zip) ? e($location->zip) : null,
                'phone' => ($location->phone!='') ? e($location->phone): null,
                'fax' => ($location->fax!='') ? e($location->fax): null,
                'assigned_assets_count' => (int) $location->assigned_assets_count,
                'assets_count'    => (int) $location->assets_count,
                'rtd_assets_count'    => (int) $location->rtd_assets_count,
                'users_count'    => (int) $location->users_count,
                'currency' =>  ($location->currency) ? e($location->currency) : null,
                'ldap_ou' =>  ($location->ldap_ou) ? e($location->ldap_ou) : null,
                'created_at' => Helper::getFormattedDateObject($location->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($location->updated_at, 'datetime'),
                'parent' => ($location->parent) ? [
                    'id' => (int) $location->parent->id,
                    'name'=> e($location->parent->name),
                ] : null,
                'manager' => ($location->manager) ? (new UsersTransformer)->transformUser($location->manager) : null,

                'children' => $children_arr,
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Location::class) ? true : false,
                'delete' => $location->isDeletable(),
                'clone' => (Gate::allows('create', Location::class) && ($location->deleted_at == '')),
            ];

            $array += $permissions_array;

            return $array;
        }
    }
}
