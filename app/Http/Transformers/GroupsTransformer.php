<?php
namespace App\Http\Transformers;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Gate;

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
            'id' => e($group->id),
            'name' => e($group->name),
            'permissions' => $group->permissions,
            'users_count' => $group->users_count,
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('superadmin') ? true : false,
            'delete' => Gate::allows('superadmin') ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }



}
