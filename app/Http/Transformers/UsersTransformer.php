<?php
namespace App\Http\Transformers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Integer;
use Gate;
use App\Helpers\Helper;

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
                'id' => (int) $user->id,
                'name' => e($user->first_name).' '.($user->last_name),
                'firstname' => e($user->first_name),
                'lastname' => e($user->last_name),
                'username' => e($user->username),
                'employee_num' => e($user->employee_num),
                'manager' => ($user->manager) ? [
                    'id' => (int) $user->manager->id,
                    'name'=> e($user->manager->username)
                ]  : null,
                'groups' => $user->groups,
                'jobtitle' => ($user->jobtitle) ? e($user->jobtitle) : null,
                'email' => e($user->email),
                'department' => ($user->department) ? [
                    'id' => (int) $user->department->id,
                    'name'=> e($user->department->name)
                ]  : null,
                'location' => ($user->userloc) ? [
                    'id' => (int) $user->userloc->id,
                    'name'=> e($user->userloc->name)
                ]  : null,
                'permissions' => $user->decodePermissions(),
                'activated' => ($user->activated =='1') ? true : false,
                'two_factor_activated' => ($user->activated =='1') ? true : false,
                'assets_count' => (int) $user->assets_count,
                'licenses_count' => (int) $user->licenses_count,
                'accessories_count' => (int) $user->accessories_count,
                'consumables_count' => (int) $user->consumables_count,
                'company' => ($user->company) ? ['id' => (int) $user->company->id,'name'=> e($user->company->name)] : null,
                'created_at' => Helper::getFormattedDateObject($user->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($user->updated_at, 'datetime'),
                'last_login' => Helper::getFormattedDateObject($user->last_login, 'datetime'),
            ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', User::class) ? true : false,
            'delete' => Gate::allows('delete', User::class) ? true : false,
            'clone' => Gate::allows('create', User::class) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformUsersDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }





}
