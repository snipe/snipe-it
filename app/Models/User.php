<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Watson\Validating\ValidatingTrait;
use App\Models\Company;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use SoftDeletes;
    use ValidatingTrait;
    use Authenticatable;
    use CanResetPassword;

    protected $dates = ['deleted_at'];
    protected $table = 'users';
    protected $injectUniqueIdentifier = true;
    protected $fillable = ['first_name', 'last_name', 'email','password','username'];


  /**
   * Model validation rules
   *
   * @var array
   */

    protected $rules = [
      'first_name'              => 'required|string|min:1',
      'last_name'               => 'required|string|min:1',
      'username'                => 'required|string|min:2|unique:users,username,NULL,deleted_at',
      'email'                   => 'email',
      'password'                => 'required|min:6',
    ];


  // This is very coarse and should be changed
    public function hasAccess($section)
    {
        if ($this->isSuperUser()) {
            return true;
        }

        if ($this->permissions=='') {
            return false;
        }
        $user_permissions = json_decode($this->permissions, true);
        $user_groups = $this->groups();

        if (((array_key_exists($section, $user_permissions)) && ($user_permissions[$section]=='1')) ||
        ((array_key_exists('admin', $user_permissions)) && ($user_permissions['admin']=='1'))) {
            return true;
        }

        foreach ($user_groups as $user_group) {
            $group_permissions = json_decode($user_group->permissions, true);
            if (((array_key_exists($section, $group_permissions)) && ($group_permissions[$section]=='1')) ||
            ((array_key_exists('admin', $group_permissions)) && ($group_permissions['admin']=='1'))) {
                return true;
            }
        }

        return false;
    }

    public function isSuperUser() {
        if (!$user_permissions = json_decode($this->permissions, true)) {
            return false;
        }

        $group_array = array();
        foreach ($this->groups() as $user_group) {
            $group_permissions = json_decode($user_group->permissions, true);
            $group_array[] = $group_permissions;
        }

        if ((array_key_exists('superuser', $user_permissions)) && ($user_permissions['superuser']=='1')) {
            return true;
        } else {
            if ((array_key_exists('superuser', $group_array)) && ($group_array['superuser']=='1')) {
                return true;
            }
            return false;
        }


    }


    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function isActivated()
    {
        if ($this->activated == 1) {
            return true;
        } else {
            return false;
        }
    }


  /**
   * Returns the user full name, it simply concatenates
   * the user first and last name.
   *
   * @return string
   */
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameAttribute()
    {
      return $this->first_name . " " . $this->last_name;
    }

  /**
   * Returns the user Gravatar image url.
   *
   * @return string
   */
    public function gravatar()
    {

        if ($this->avatar) {
            return config('app.url').'/uploads/avatars/'.$this->avatar;
        }

        if ($this->email) {
          // Generate the Gravatar hash
            $gravatar = md5(strtolower(trim($this->email)));
          // Return the Gravatar url
            return "//gravatar.com/avatar/".$gravatar;
        }

        return false;

    }

  /**
  * Get assets assigned to this user
  */
    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'assigned_to')->withTrashed();
    }

  /**
  * Get accessories assigned to this user
  */
    public function accessories()
    {
        return $this->belongsToMany('\App\Models\Accessory', 'accessories_users', 'assigned_to', 'accessory_id')->withPivot('id')->withTrashed();
    }

  /**
  * Get consumables assigned to this user
  */
    public function consumables()
    {
        return $this->belongsToMany('\App\Models\Consumable', 'consumables_users', 'assigned_to', 'consumable_id')->withPivot('id')->withTrashed();
    }

 /**
 * Get licenses assigned to this user
 */
    public function licenses()
    {
        return $this->belongsToMany('\App\Models\License', 'license_seats', 'assigned_to', 'license_id')->withPivot('id');
    }

  /**
  * Get action logs for this user
  */
    public function userlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'checkedout_to')->orderBy('created_at', 'DESC')->withTrashed();
    }

  /**
  * Get the asset's location based on the assigned user
  **/
    public function userloc()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id')->withTrashed();
    }

  /**
  * Get the user's manager based on the assigned user
  **/
    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id')->withTrashed();
    }

  /**
  * Get user groups
  */
    public function groups()
    {
        return $this->belongsToMany('\App\Models\Group', 'users_groups');
    }


    public function accountStatus()
    {
        if ($this->sentryThrottle) {
            if ($this->sentryThrottle->suspended==1) {
                return 'suspended';
            } elseif ($this->sentryThrottle->banned==1) {
                return 'banned';
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function assetlog()
    {
        return $this->hasMany('\App\Models\Asset', 'id')->withTrashed();
    }

  /**
  * Get uploads for this asset
  */
    public function uploads()
    {
        return $this->hasMany('\App\Models\Actionlog', 'asset_id')
          ->where('asset_type', '=', 'user')
          ->where('action_type', '=', 'uploaded')
          ->whereNotNull('filename')
          ->orderBy('created_at', 'desc');
    }

    public function sentryThrottle()
    {
        return $this->hasOne('\App\Models\Throttle');
    }

    public function scopeGetDeleted($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }

    public function scopeGetNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

  /**
  * Override the SentryUser getPersistCode method for
  * multiple logins at one time
  **/
    public function getPersistCode()
    {

        if (!config('session.multi_login') || (!$this->persist_code)) {
            $this->persist_code = $this->getRandomString();

            // Our code got hashed
            $persistCode = $this->persist_code;
            $this->save();
            return $persistCode;
        }
        return $this->persist_code;
    }

    public function scopeMatchEmailOrUsername($query, $user_username, $user_email)
    {
        return $query->where('email', '=', $user_email)
        ->orWhere('username', '=', $user_username)
        ->orWhere('username', '=', $user_email);
    }


    public static function generateFormattedNameFromFullName($format = 'filastname', $users_name)
    {
        $name = explode(" ", $users_name);
        $name = str_replace("'", '', $name);
        $first_name = $name[0];
        $email_last_name = '';
        $email_prefix = $first_name;

        // If there is no last name given
        if (!array_key_exists(1, $name)) {
            $last_name='';
            $email_last_name = $last_name;
            $user_username = $first_name;

        // There is a last name given
        } else {

            $last_name = str_replace($first_name, '', $users_name);

            if ($format=='filastname') {
                $email_last_name.=str_replace(' ', '', $last_name);
                $email_prefix = $first_name[0].$email_last_name;

            } elseif ($format=='firstname.lastname') {
                $email_last_name.=str_replace(' ', '', $last_name);
                $email_prefix = $first_name.'.'.$email_last_name;

            } elseif ($format=='firstname') {
                $email_last_name.=str_replace(' ', '', $last_name);
                $email_prefix = $first_name;

            }
        }

        $user_username = $email_prefix;
        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['username'] = strtolower($user_username);

        return $user;


    }


    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
    }

/**
* Query builder scope to search on text
*
* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
* @param  text                              $search      Search term
*
* @return Illuminate\Database\Query\Builder          Modified query builder
*/
    public function scopeTextsearch($query, $search)
    {

        return $query->where(function ($query) use ($search) {
            $query->where('users.first_name', 'LIKE', "%$search%")
            ->orWhere('users.last_name', 'LIKE', "%$search%")
            ->orWhere('users.email', 'LIKE', "%$search%")
            ->orWhere('users.username', 'LIKE', "%$search%")
            ->orWhere('users.notes', 'LIKE', "%$search%")
            ->orWhere('users.employee_num', 'LIKE', "%$search%")
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('userloc', function ($query) use ($search) {
                    $query->where('locations.name', 'LIKE', '%'.$search.'%');
                });
            })

        // Ugly, ugly code because Laravel sucks at self-joins
            ->orWhere(function ($query) use ($search) {
                $query->whereRaw("users.manager_id IN (select id from users where first_name LIKE '%".$search."%' OR last_name LIKE '%".$search."%') ");
            });
        });

    }


  /**
   * Query builder scope for Deleted users
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }


  /**
  * Query builder scope to order on manager
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order         Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeOrderManager($query, $order)
    {
      // Left join here, or it will only return results with parents
        return $query->leftJoin('users as manager', 'users.manager_id', '=', 'manager.id')->orderBy('manager.first_name', $order)->orderBy('manager.last_name', $order);
    }

  /**
  * Query builder scope to order on company
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order         Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations', 'users.location_id', '=', 'locations.id')->orderBy('locations.name', $order);
    }
}
