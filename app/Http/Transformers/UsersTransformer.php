<?php
namespace App\Http\Transformers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Integer;

class UsersTransformer
{

    public function transformUsers (Collection $users, $total)
    {
        $array = array();
        foreach ($users as $user) {
            $array[] = self::transformUser($user);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformUser (User $user)
    {
        $array = [
                'id' => e($user->id),
                'name' => e($user->first_name).' '.($user->last_name),
                'firstname' => e($user->first_name),
                'lastname' => e($user->last_name),
                'username' => e($user->username),
                'employee_num' => e($user->employee_num),
                'manager' => ($user->manager) ? $user->manager->name : false,
                'jobtitle' => e($user->jobtitle),
                'email' => e($user->email),
                'location' => (new LocationsTransformer)->transformLocation($user->userloc),
                'permissions' => $user->decodePermissions(),
                'activated' => ($user->activated =='1') ? true : false,
                'two_factor_activated' => ($user->activated =='1') ? true : false,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

        return $array;
    }

    public function transformUsersDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }



}
