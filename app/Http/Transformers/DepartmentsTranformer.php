<?php
namespace App\Http\Transformers;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class DepartmentsTransformer
{

    public function transformDepartments (Collection $locations, $total)
    {
        $array = array();
        foreach ($locations as $location) {
            $array[] = self::transformDepartment($location);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformDepartment (Department $location = null)
    {
        if ($location) {

            $assets_arr = [];
            foreach($location->assets() as $asset) {
                $assets_arr = ['id' => $asset->id];
            }

            $children_arr = [];
            foreach($location->childDepartments() as $child) {
                $children_arr = ['id' => $child->id];
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
                'parent_id' => e($location->parent_id),
                'children' => $children_arr,
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Department::class) ? true : false,
                'delete' => Gate::allows('delete', Department::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
