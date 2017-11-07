<?php
namespace App\Http\Transformers;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class DepartmentsTransformer
{

    public function transformDepartments (Collection $departments, $total)
    {
        $array = array();
        foreach ($departments as $department) {
            $array[] = self::transformDepartment($department);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformDepartment (Department $department = null)
    {
        if ($department) {

            $array = [
                'id' => (int) $department->id,
                'name' => e($department->name),
                'image' =>   ($department->image) ? app('departments_upload_url').e($department->image) : null,
                'company' => ($department->company) ? [
                    'id' => (int) $department->company->id,
                    'name'=> e($department->company->name)
                ] : null,
                'manager' => ($department->manager) ? [
                    'id' => (int) $department->manager->id,
                    'name' => e($department->manager->getFullNameAttribute()),
                    'first_name'=> e($department->manager->first_name),
                    'last_name'=> e($department->manager->last_name)
                ] : null,
                'location' => ($department->location) ? [
                    'id' => (int) $department->location->id,
                    'name' => e($department->location->name)
                ] : null,
                'users_count' => e($department->users_count),
                'created_at' => Helper::getFormattedDateObject($department->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($department->updated_at, 'datetime'),
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
