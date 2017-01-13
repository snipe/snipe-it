<?php
namespace App\Http\Transformers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsersTransformer
{

    public function transformUsers( Collection $users)
    {
        $users_array = array();
        foreach ($users as $user) {
            $users_array[] = self::transformUser($user);
        }
        return $users_array;
    }

    public function transformUser(User $user)
    {
            $user_array[] = [
                'id' => e($user->id),
                'first_name' => e($user->first_name),
                'last_name' => e($user->last_name),
                'location' => (new LocationsTransformer)->transformLocation($user->userloc),
                'permissions' => $user->decodePermissions(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

        return $user_array;
    }



}
