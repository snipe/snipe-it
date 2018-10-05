<?php
namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\UniqueUndeletedTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;

class User extends SnipeModel implements AuthenticatableContract, CanResetPasswordContract
{
    protected $presenter = 'App\Presenters\UserPresenter';
    use SoftDeletes, ValidatingTrait;
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens;
    use UniqueUndeletedTrait;
    use Notifiable;
    use Presentable;
    protected $dates = ['deleted_at'];
    protected $hidden = ['password','remember_token','permissions','reset_password_code','persist_code'];
    protected $table = 'users';
    protected $injectUniqueIdentifier = true;
    protected $fillable = [
        'activated',
        'address',
        'city',
        'company_id',
        'country',
        'department_id',
        'email',
        'employee_num',
        'first_name',
        'jobtitle',
        'last_name',
        'ldap_import',
        'locale',
        'location_id',
        'manager_id',
        'password',
        'phone',
        'state',
        'username',
        'zip',
    ];

    protected $casts = [
        'activated' => 'boolean',
    ];

    /**
     * Model validation rules
     *
     * @var array
     */

    protected $rules = [
        'first_name'              => 'required|string|min:1',
        'username'                => 'required|string|min:1|unique_undeleted',
        'email'                   => 'email|nullable',
        'password'                => 'required|min:6',
        'locale'                  => 'max:10|nullable',
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [
        'first_name',
        'last_name',
        'email',
        'username',
        'notes',
        'phone',
        'jobtitle',
        'employee_num'
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
        'userloc'    => ['name'],
        'department' => ['name'],
        'groups'     => ['name'],
        'manager'    => ['first_name', 'last_name', 'username']
    ];  

    public function hasAccess($section)
    {
        if ($this->isSuperUser()) {
            return true;
        }
        $user_groups = $this->groups;


        if (($this->permissions=='')  && (count($user_groups) == 0)) {
            return false;
        }

        $user_permissions = json_decode($this->permissions, true);

        //If the user is explicitly granted, return true
        if (($user_permissions!='') && ((array_key_exists($section, $user_permissions)) && ($user_permissions[$section]=='1'))) {
            return true;
        }
        // If the user is explicitly denied, return false
        if (($user_permissions=='') || array_key_exists($section, $user_permissions) && ($user_permissions[$section]=='-1')) {
            return false;
        }

        // Loop through the groups to see if any of them grant this permission
        foreach ($user_groups as $user_group) {
            $group_permissions = (array) json_decode($user_group->permissions, true);
            if (((array_key_exists($section, $group_permissions)) && ($group_permissions[$section]=='1'))) {
                return true;
            }
        }

        return false;
    }

    public function isSuperUser()
    {
        if (!$user_permissions = json_decode($this->permissions, true)) {
            return false;
        }

        foreach ($this->groups as $user_group) {
            $group_permissions = json_decode($user_group->permissions, true);
            $group_array = (array)$group_permissions;
            if ((array_key_exists('superuser', $group_array)) && ($group_permissions['superuser']=='1')) {
                return true;
            }
        }

        if ((array_key_exists('superuser', $user_permissions)) && ($user_permissions['superuser']=='1')) {
            return true;
        }

        return false;
    }


    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function department()
    {
        return $this->belongsTo('\App\Models\Department', 'department_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getCompleteNameAttribute()
    {
        return $this->last_name . ", " . $this->first_name . " (" . $this->username . ")";
    }

    /**
     * The url for slack notifications.
     * Used by Notifiable trait.
     * @return mixed
     */
    public function routeNotificationForSlack()
    {
        // At this point the endpoint is the same for everything.
        //  In the future this may want to be adapted for individual notifications.
        $this->endpoint = \App\Models\Setting::getSettings()->slack_endpoint;
        return $this->endpoint;
    }


    /**
     * Get assets assigned to this user
     */
    public function assets()
    {
        return $this->morphMany('App\Models\Asset', 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

    /**
     * Get assets assigned to this user
     */
    public function assetmaintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'user_id')->withTrashed();
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
        return $this->hasMany('\App\Models\Actionlog', 'target_id')->orderBy('created_at', 'DESC')->withTrashed();
    }

    /**
     * Get the asset's location based on the assigned user
     * @todo - this should be removed once we're sure we've switched it
     * to location()
     **/
    public function userloc()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id')->withTrashed();
    }

    /**
     * Get the asset's location based on the assigned user
     **/
    public function location()
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
     * Get any locations the user manages.
     **/
    public function managedLocations()
    {
        return $this->hasMany('\App\Models\Location', 'manager_id')->withTrashed();
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
        if ($this->throttle) {
            if ($this->throttle->suspended==1) {
                return 'suspended';
            } elseif ($this->throttle->banned==1) {
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
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', User::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Fetch Items User has requested
     */
    public function checkoutRequests()
    {
        return $this->belongsToMany(Asset::class, 'checkout_requests', 'user_id', 'requestable_id')->whereNull('canceled_at');
    }

    public function throttle()
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

    public function scopeMatchEmailOrUsername($query, $user_username, $user_email)
    {
        return $query->where('email', '=', $user_email)
            ->orWhere('username', '=', $user_username)
            ->orWhere('username', '=', $user_email);
    }

    public static function generateEmailFromFullName($name)
    {
        $username = User::generateFormattedNameFromFullName(Setting::getSettings()->email_format, $name);
        return $username['username'].'@'.Setting::getSettings()->email_domain;
    }

    public static function generateFormattedNameFromFullName($format = 'filastname', $users_name)
    {

        // If there was only one name given
        if (strpos($users_name, ' ') === false) {
            $first_name = $users_name;
            $last_name = '';
            $username  = $users_name;

        } else {

            list($first_name, $last_name) = explode(" ", $users_name, 2);

            // Assume filastname by default
            $username = str_slug(substr($first_name, 0, 1).$last_name);

            if ($format=='firstname.lastname') {
                $username = str_slug($first_name) . '.' . str_slug($last_name);

            } elseif ($format=='lastnamefirstinitial') {
                $username = str_slug($last_name.substr($first_name, 0, 1));

            } elseif ($format=='firstname_lastname') {
                $username = str_slug($first_name).'_'.str_slug($last_name);

            } elseif ($format=='firstname') {
                $username = str_slug($first_name);
            }
        }

        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['username'] = strtolower($username);
        return $user;


    }

    /**
     * Check whether two-factor authorization is required and the user has activated it
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return bool
     */
    public function two_factor_active () {

        if (Setting::getSettings()->two_factor_enabled !='0') {
            if (($this->two_factor_optin =='1') && ($this->two_factor_enrolled)) {
                return true;
            }
        }
        return false;

    }


    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
    }

    /**
     * Run additional, advanced searches.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  array  $term The search terms
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function advancedTextSearch(Builder $query, array $terms) {

        foreach($terms as $term) {
            $query = $query->orWhereRaw('CONCAT('.DB::getTablePrefix().'users.first_name," ",'.DB::getTablePrefix().'users.last_name) LIKE ?', ["%$term%", "%$term%"]);
        }

        return $query;
    }


    public function scopeByGroup($query, $id) {
        return $query->whereHas('groups', function ($query) use ($id) {
            $query->where('groups.id', '=', $id);
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
        return $query->leftJoin('users as users_manager', 'users.manager_id', '=', 'users_manager.id')->orderBy('users_manager.first_name', $order)->orderBy('users_manager.last_name', $order);
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
        return $query->leftJoin('locations as locations_users', 'users.location_id', '=', 'locations_users.id')->orderBy('locations_users.name', $order);
    }


    /**
     * Query builder scope to order on department
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderDepartment($query, $order)
    {
        return $query->leftJoin('departments as departments_users', 'users.department_id', '=', 'departments_users.id')->orderBy('departments_users.name', $order);
    }
}
