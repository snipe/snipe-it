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
        return (new DatatablesTransformer)->transformDatatables($users_array);
    }

    public function transformUser(User $user)
    {
            $user_array[] = [
                'id' => e($user->id),
                'name' => e($user->first_name).' '.($user->last_name),
                'firstname' => e($user->first_name),
                'lastname' => e($user->last_name),
                'username' => e($user->username),
                'jobtitle' => e($user->jobtitle),
                'email' => e($user->email),
                'location' => (new LocationsTransformer)->transformLocation($user->userloc),
                'permissions' => $user->decodePermissions(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

        return $user_array;
    }

    public function transformUsersDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }



}
