<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Watson\Validating\ValidatingTrait;

class User extends SnipeModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, HasLocalePreference
{
    use HasFactory;

    protected $presenter = \App\Presenters\UserPresenter::class;
    use SoftDeletes, ValidatingTrait;
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens;
    use UniqueUndeletedTrait;
    use Notifiable;
    use Presentable;
    use Searchable;

    protected $hidden = ['password', 'remember_token', 'permissions', 'reset_password_code', 'persist_code'];
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
        'notes',
        'state',
        'username',
        'zip',
        'remote',
        'start_date',
        'end_date',
        'scim_externalid'
    ];

    protected $casts = [
        'activated'    => 'boolean',
        'manager_id'   => 'integer',
        'location_id'  => 'integer',
        'company_id'   => 'integer',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
        'end_date',
    ];


    /**
     * Model validation rules
     *
     * @var array
     */

    protected $rules = [
        'first_name'              => 'required|string|min:1|max:191',
        'username'                => 'required|string|min:1|unique_undeleted|max:191',
        'email'                   => 'email|nullable|max:191',
        'password'                => 'required|min:8',
        'locale'                  => 'max:10|nullable',
        'website'                 => 'url|nullable|max:191',
        'manager_id'              => 'nullable|exists:users,id|cant_manage_self',
        'location_id'             => 'exists:locations,id|nullable',
        'start_date'              => 'nullable|date',
        'end_date'                => 'nullable|date|after_or_equal:start_date',
    ];

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
        'employee_num',
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
        'company'    => ['name'],
        'manager'    => ['first_name', 'last_name', 'username'],
    ];

    /**
     * Internally check the user permission for the given section
     *
     * @return bool
     */
    protected function checkPermissionSection($section)
    {
        $user_groups = $this->groups;
        if (($this->permissions == '') && (count($user_groups) == 0)) {

            return false;
        }

        $user_permissions = json_decode($this->permissions, true);

        $is_user_section_permissions_set = ($user_permissions != '') && array_key_exists($section, $user_permissions);
        //If the user is explicitly granted, return true
        if ($is_user_section_permissions_set && ($user_permissions[$section] == '1')) {
            return true;
        }
        // If the user is explicitly denied, return false
        if ($is_user_section_permissions_set && ($user_permissions[$section] == '-1')) {
            return false;
        }

        // Loop through the groups to see if any of them grant this permission
        foreach ($user_groups as $user_group) {
            $group_permissions = (array) json_decode($user_group->permissions, true);
            if (((array_key_exists($section, $group_permissions)) && ($group_permissions[$section] == '1'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check user permissions
     *
     * Parses the user and group permission masks to see if the user
     * is authorized to do the thing
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return bool
     */
    public function hasAccess($section)
    {
        if ($this->isSuperUser()) {
            return true;
        }

        return $this->checkPermissionSection($section);
    }

    /**
     * Checks if the user is a SuperUser
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return bool
     */
    public function isSuperUser()
    {
        return $this->checkPermissionSection('superuser');
    }


    /**
     * Establishes the user -> company relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * Establishes the user -> department relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    /**
     * Checks activated status
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return bool
     */
    public function isActivated()
    {
        return $this->activated == 1;
    }

    /**
     * Returns the full name attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Returns the complete name attribute with username
     *
     * @todo refactor this so it's less repetitive and dumb
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return string
     */
    public function getCompleteNameAttribute()
    {
        return $this->last_name.', '.$this->first_name.' ('.$this->username.')';
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
     * Establishes the user -> assets relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->morphMany(\App\Models\Asset::class, 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

    /**
     * Establishes the user -> maintenances relationship
     *
     * This would only be used to return maintenances that this user
     * created.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetmaintenances()
    {
        return $this->hasMany(\App\Models\AssetMaintenance::class, 'user_id')->withTrashed();
    }

    /**
     * Establishes the user -> accessories relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accessories()
    {
        return $this->belongsToMany(\App\Models\Accessory::class, 'accessories_users', 'assigned_to', 'accessory_id')
            ->withPivot('id', 'created_at', 'note')->withTrashed();
    }

    /**
     * Establishes the user -> consumables relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function consumables()
    {
        return $this->belongsToMany(\App\Models\Consumable::class, 'consumables_users', 'assigned_to', 'consumable_id')->withPivot('id','created_at','note')->withTrashed();
    }

    /**
     * Establishes the user -> license seats relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function licenses()
    {
        return $this->belongsToMany(\App\Models\License::class, 'license_seats', 'assigned_to', 'license_id')->withPivot('id');
    }

    /**
     * Establishes the user -> actionlogs relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function userlog()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'target_id')->where('target_type', '=', self::class)->orderBy('created_at', 'DESC')->withTrashed();
    }

    /**
     * Establishes the user -> location relationship
     *
     * Get the asset's location based on the assigned user
     *
     * @todo - this should be removed once we're sure we've switched it to location()
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function userloc()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id')->withTrashed();
    }

    /**
     * Establishes the user -> location relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id')->withTrashed();
    }

    /**
     * Establishes the user -> manager relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function manager()
    {
        return $this->belongsTo(self::class, 'manager_id')->withTrashed();
    }

    /**
     * Establishes the user -> managed locations relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function managedLocations()
    {
        return $this->hasMany(\App\Models\Location::class, 'manager_id');
    }

    /**
     * Establishes the user -> groups relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function groups()
    {
        return $this->belongsToMany(\App\Models\Group::class, 'users_groups');
    }

    /**
     * Establishes the user -> assets relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetlog()
    {
        return $this->hasMany(\App\Models\Asset::class, 'id')->withTrashed();
    }

    /**
     * Establishes the user -> uploads relationship
     *
     * @todo I don't think we use this?
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function uploads()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'item_id')
            ->where('item_type', self::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Establishes the user -> requested assets relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function checkoutRequests()
    {
        return $this->belongsToMany(Asset::class, 'checkout_requests', 'user_id', 'requestable_id')->whereNull('canceled_at');
    }


    /**
     * Query builder scope to return NOT-deleted users
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     *
     * @param  string $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeGetNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Query builder scope to return users by email or username
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     *
     * @param  string $query
     * @param  string $user_username
     * @param  string $user_email
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeMatchEmailOrUsername($query, $user_username, $user_email)
    {
        return $query->where('email', '=', $user_email)
            ->orWhere('username', '=', $user_username)
            ->orWhere('username', '=', $user_email);
    }

    /**
     * Generate email from full name
     * 
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     *
     * @param  string $query
     * @return string
     */
    public static function generateEmailFromFullName($name)
    {
        $username = self::generateFormattedNameFromFullName($name, Setting::getSettings()->email_format);

        return $username['username'].'@'.Setting::getSettings()->email_domain;
    }

    public static function generateFormattedNameFromFullName($users_name, $format = 'filastname')
    {

        // If there was only one name given
        if (strpos($users_name, ' ') === false) {
            $first_name = $users_name;
            $last_name = '';
            $username = $users_name;
        } else {

            list($first_name, $last_name) = explode(' ', $users_name, 2);

            // Assume filastname by default
            $username = str_slug(substr($first_name, 0, 1).$last_name);

            if ($format=='firstname.lastname') {
                $username = str_slug($first_name) . '.' . str_slug($last_name);

            } elseif ($format == 'lastnamefirstinitial') {
                $username = str_slug($last_name.substr($first_name, 0, 1));
            } elseif ($format == 'firstintial.lastname') {
                $username = substr($first_name, 0, 1).'.'.str_slug($last_name);
            } elseif ($format == 'firstname_lastname') {
                $username = str_slug($first_name).'_'.str_slug($last_name);
            } elseif ($format == 'firstname') {
                $username = str_slug($first_name);
            } elseif ($format == 'firstinitial.lastname') {
                $username = str_slug(substr($first_name, 0, 1).'.'.str_slug($last_name));
            } elseif ($format == 'lastname_firstinitial') {
                $username = str_slug($last_name).'_'.str_slug(substr($first_name, 0, 1));
            } elseif ($format == 'firstnamelastname') {
                $username = str_slug($first_name).str_slug($last_name);
            } elseif ($format == 'firstnamelastinitial') {
                $username = str_slug(($first_name.substr($last_name, 0, 1)));
              }
        }

        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['username'] = strtolower($username);


        return $user;
    }

    /**
     * Check whether two-factor authorization is requiredfor this user
     *
     * 0 = 2FA disabled
     * 1 = 2FA optional
     * 2 = 2FA universally required
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return bool
     */
    public function two_factor_active()
    {

        // If the 2FA is optional and the user has opted in
        if ((Setting::getSettings()->two_factor_enabled == '1') && ($this->two_factor_optin == '1')) {
            return true;
        }
        // If the 2FA is required for everyone so is implicitly active
        elseif (Setting::getSettings()->two_factor_enabled == '2') {
            return true;
        }

        return false;
    }

    /**
     * Get the admin user who created this user
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v6.0.5]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by')->withTrashed();
    }

    /**
     * Check whether two-factor authorization is required and the user has activated it
     * and enrolled a device
     *
     * 0 = 2FA disabled
     * 1 = 2FA optional
     * 2 = 2FA universally required
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.6.14]
     *
     * @return bool
     */
    public function two_factor_active_and_enrolled()
    {

        // If the 2FA is optional and the user has opted in and is enrolled
        if ((Setting::getSettings()->two_factor_enabled == '1') && ($this->two_factor_optin == '1') && ($this->two_factor_enrolled == '1')) {
            return true;
        }
        // If the 2FA is required for everyone and the user has enrolled
        elseif ((Setting::getSettings()->two_factor_enabled == '2') && ($this->two_factor_enrolled)) {
            return true;
        }
        return false;

    }


    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
    }

    /**
     * Query builder scope to search user by name with spaces in it.
     * We don't use the advancedTextSearch() scope because that searches
     * all of the relations as well, which is more than what we need.
     *
     * @param  \Illuminate\Database\Query\Builder $query Query builder instance
     * @param  array  $terms The search terms
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSimpleNameSearch($query, $search)
    {
           $query = $query->where('first_name', 'LIKE', '%'.$search.'%')
               ->orWhere('last_name', 'LIKE', '%'.$search.'%')
               ->orWhereRaw('CONCAT('.DB::getTablePrefix().'users.first_name," ",'.DB::getTablePrefix().'users.last_name) LIKE ?', ["%$search%"]);

        return $query;
    }


    /**
     * Run additional, advanced searches.
     *
     * @param  \Illuminate\Database\Query\Builder $query Query builder instance
     * @param  array  $terms The search terms
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function advancedTextSearch(Builder $query, array $terms) {

        foreach($terms as $term) {
            $query = $query->orWhereRaw('CONCAT('.DB::getTablePrefix().'users.first_name," ",'.DB::getTablePrefix().'users.last_name) LIKE ?', ["%$term%"]);
        }

        return $query;
    }

    /**
     * Query builder scope to return users by group
     *
     * @param  \Illuminate\Database\Query\Builder $query Query builder instance
     * @param  int $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeByGroup($query, $id)
    {
        return $query->whereHas('groups', function ($query) use ($id) {
            $query->where('permission_groups.id', '=', $id);
        });
    }


    /**
     * Query builder scope to order on manager
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param string                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManager($query, $order)
    {
        // Left join here, or it will only return results with parents
        return $query->leftJoin('users as users_manager', 'users.manager_id', '=', 'users_manager.id')->orderBy('users_manager.first_name', $order)->orderBy('users_manager.last_name', $order);
    }

    /**
     * Query builder scope to order on company
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param string                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations as locations_users', 'users.location_id', '=', 'locations_users.id')->orderBy('locations_users.name', $order);
    }

    /**
     * Query builder scope to order on department
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderDepartment($query, $order)
    {
        return $query->leftJoin('departments as departments_users', 'users.department_id', '=', 'departments_users.id')->orderBy('departments_users.name', $order);
    }

    /**
     * Query builder scope to order on admin user
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param string                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByCreatedBy($query, $order)
    {
        // Left join here, or it will only return results with parents
        return $query->leftJoin('users as admin_user', 'users.created_by', '=', 'admin_user.id')
            ->orderBy('admin_user.first_name', $order)
            ->orderBy('admin_user.last_name', $order);
    }


    /**
     * Query builder scope to order on company
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as companies_user', 'users.company_id', '=', 'companies_user.id')->orderBy('companies_user.name', $order);
    }

    public function preferredLocale()
    {
        return $this->locale;
    }
}
