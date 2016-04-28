<?php
namespace App\Models;

use Watson\Validating\ValidatingTrait;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $rules = array(
      'name' => 'required|min:3|max:255',
    );

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;


    /**
    * Get user groups
    */
    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'users_groups');
    }


    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
    }


    /**
    * Walks through the permissions in the permissions config file and determines if
    * permissions are granted based on a $selected_arr array.
    *
    * The $permissions array is a multidimensional array broke down by section.
    * (Licenses, Assets, etc)
    *
    * The $selected_arr should be a flattened array that contains just the
    * corresponding permission name and a true or false boolean to determine
    * if that group has been granted that permission. 
    *
    * @todo Move this into a helper? Since the same logic is used for users.
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @param array $permissions
    * @param array $selected_arr
    * @since [v1.0]
    * @return Array
    */
    public static function selectedPermissionsArray($permissions, $selected_arr = array())
    {

        $permissions_arr = array();

        foreach ($permissions as $permission) {

            for ($x = 0; $x < count($permission); $x++) {
                $permission_name = $permission[$x]['permission'];

                if ($permission[$x]['display'] === true) {

                    if ($selected_arr) {
                        if (array_key_exists($permission_name,$selected_arr)) {
                            $permissions_arr[$permission_name] = ($selected_arr[$permission_name] === 1) ? '1': '0';
                        } else {
                            $permissions_arr[$permission_name] = 'bum';
                        }
                    } else {
                        $permissions_arr[$permission_name] = 'hodor';
                    }
                }


            }


        }

        return $permissions_arr;
    }

}
