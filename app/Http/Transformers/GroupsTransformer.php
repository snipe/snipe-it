<?php
namespace App\Http\Transformers;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class GroupsTransformer
{

    public function transformGroups (Collection $groups)
    {
        $array = array();
        foreach ($groups as $group) {
            $array[] = self::transformGroup($group);
        }
        return (new DatatablesTransformer)->transformDatatables($array);
    }

    public function transformGroup (Group $group)
    {
        $array = [
            'id' => (int) $group->id,
            'name' => e($group->name),
            'permissions' => json_decode($group->permissions),
            'users_count' => (int) $group->users_count,
            'created_at' => Helper::getFormattedDateObject($group->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($group->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('superadmin') ? true : false,
            'delete' => Gate::allows('superadmin') ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }



}
