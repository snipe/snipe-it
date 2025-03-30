<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\HasApiTokens;
use Watson\Validating\ValidatingTrait;

class User extends SnipeModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, HasLocalePreference
{
    use HasFactory;
    use CompanyableTrait;

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
        'scim_externalid',
        'avatar',
        'gravatar',
        'vip',
        'autoassign_licenses',
        'website',
    ];

    protected $casts = [
        'manager_id'   => 'integer',
        'location_id'  => 'integer',
        'company_id'   => 'integer',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
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
        'start_date'              => 'nullable|date_format:Y-m-d',
        'end_date'                => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        'autoassign_licenses'     => 'boolean',
        'address'                 => 'max:191|nullable',
        'city'                    => 'max:191|nullable',
        'state'                   => 'min:2|max:191|nullable',
        'country'                 => 'min:2|max:191|nullable',
        'zip'                     => 'max:10|nullable',
        'vip'                     => 'boolean',
        'remote'                  => 'boolean',
        'activated'               => 'boolean',
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
        'website',
        'locale',
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
     * Checks if the can edit their own profile
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v6.3.4]
     * @return bool
     */
    public function canEditProfile() : bool {

        $setting = Setting::getSettings();
        if ($setting->profile_edit == 1) {
            return true;
        }
        return false;
    }

    /**
     * Checks if the user is deletable
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v6.3.4]
     * @return bool
     */
    public function isDeletable()
    {
        return Gate::allows('delete', $this)
            && ($this->assets->count() === 0)
            && ($this->licenses->count() === 0)
            && ($this->consumables->count() === 0)
            && ($this->accessories->count() === 0)
            && ($this->managedLocations->count() === 0)
            && ($this->managesUsers->count() === 0)
            && ($this->deleted_at == '');
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
        $setting = Setting::getSettings();

        if ($setting->name_display_format=='last_first') {
            return ($this->last_name) ? $this->last_name.' '.$this->first_name : $this->first_name;
        }
        return $this->last_name ? $this->first_name.' '.$this->last_name : $this->first_name;
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
        return $this->morphMany(\App\Models\Asset::class, 'assigned', 'assigned_type', 'assigned_to')->withTrashed()->orderBy('id');
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
        return $this->belongsToMany(\App\Models\Accessory::class, 'accessories_checkout', 'assigned_to', 'accessory_id')
            ->where('assigned_type', '=', 'App\Models\User')
            ->withPivot('id', 'created_at', 'note')->withTrashed()->orderBy('accessory_id');
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
        return $this->belongsToMany(\App\Models\License::class, 'license_seats', 'assigned_to', 'license_id')->withPivot('id', 'created_at', 'updated_at');
    }

    /**
     * Establishes the user -> reportTemplates relationship
     *
     */
    public function reportTemplates(): HasMany
    {
        return $this->hasMany(ReportTemplate::class, 'created_by');
    }

    /**
     * Establishes a count of all items assigned
     *
     * @author J. Vinsmoke
     * @since [v6.1]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    Public function allAssignedCount() {
        $assetsCount = $this->assets()->count();
        $licensesCount = $this->licenses()->count();
        $accessoriesCount = $this->accessories()->count();
        $consumablesCount = $this->consumables()->count();
        
        $totalCount = $assetsCount + $licensesCount + $accessoriesCount + $consumablesCount;
    
        return (int) $totalCount;
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
     * Establishes the user -> managed users relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v6.4.1]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function managesUsers()
    {
        return $this->hasMany(\App\Models\User::class, 'manager_id');
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
     * Establishes the user -> acceptances relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v7.0.7]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function acceptances()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'target_id')
            ->where('target_type', self::class)
            ->where('action_type', '=', 'accepted')
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
     * Set a common string when the user has been imported/synced from:
     *
     * - LDAP without password syncing
     * - SCIM
     * - CSV import where no password was provided
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v6.2.0]
     * @return string
     */
    public function noPassword()
    {
        return "*** NO PASSWORD ***";
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
            } elseif ($format == 'lastname.firstinitial') {
                $username = str_slug($last_name).'.'.str_slug(substr($first_name, 0, 1));
            } elseif ($format == 'firstnamelastname') {
                $username = str_slug($first_name).str_slug($last_name);
            } elseif ($format == 'firstnamelastinitial') {
                $username = str_slug(($first_name.substr($last_name, 0, 1)));
            } elseif ($format == 'lastname.firstname') {
                $username = str_slug($last_name).'.'.str_slug($first_name);
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
        return $query->where('first_name', 'LIKE', '%' . $search . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search . '%')
            ->orWhereMultipleColumns([
                'users.first_name',
                'users.last_name',
            ], $search);
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
            $query->orWhereMultipleColumns([
                'users.first_name',
                'users.last_name',
            ], $term);
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
    public function getUserTotalCost(){
        $asset_cost= 0;
        $license_cost= 0;
        $accessory_cost= 0;
        foreach ($this->assets as $asset){
            $asset_cost += $asset->purchase_cost;
            $this->asset_cost = $asset_cost;
        }
        foreach ($this->licenses as $license){
            $license_cost += $license->purchase_cost;
            $this->license_cost = $license_cost;
        }
        foreach ($this->accessories as $accessory){
            $accessory_cost += $accessory->purchase_cost;
            $this->accessory_cost = $accessory_cost;
        }

        $this->total_user_cost = ($asset_cost + $accessory_cost + $license_cost);


        return $this;
    }
    public function scopeUserLocation($query, $location, $search){


        return $query->where('location_id','=', $location)
            ->where('users.first_name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.email', 'LIKE', '%' . $search . '%')
            ->orWhere('users.last_name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.permissions', 'LIKE', '%' . $search . '%')
            ->orWhere('users.country', 'LIKE', '%' . $search . '%')
            ->orWhere('users.phone', 'LIKE', '%' . $search . '%')
            ->orWhere('users.jobtitle', 'LIKE', '%' . $search . '%')
            ->orWhere('users.employee_num', 'LIKE', '%' . $search . '%')
            ->orWhere('users.username', 'LIKE', '%' . $search . '%')
            ->orwhereRaw('CONCAT(users.first_name," ",users.last_name) LIKE \''.$search.'%\'');




    }
}
