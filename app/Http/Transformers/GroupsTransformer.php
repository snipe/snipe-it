<?php
namespace App\Http\Transformers;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

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
            'permissions' => ($group->permissions) ? json_decode($group->permissions, true) : null,
            'users_count' => $group->users_count,
            'created_at' => $group->created_at,
            'updated_at' => $group->updated_at,
        ];

        return $array;
    }



}
