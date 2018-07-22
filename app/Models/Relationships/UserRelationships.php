<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait UserRelationships {

    /**
     * Get accessories assigned to this user
     */
    public function accessories()
    {
        return $this->belongsToMany('\App\Models\Accessory', 'accessories_users', 'assigned_to', 'accessory_id')->withPivot('id')->withTrashed();
    }

    public function assetlog()
    {
        return $this->hasMany('\App\Models\Asset', 'id')->withTrashed();
    }

    /**
     * Get assets assigned to this user
     */
    public function assetmaintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'user_id')->withTrashed();
    }

    /**
     * Get assets assigned to this user
     */
    public function assets()
    {
        return $this->morphMany('App\Models\Asset', 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

    /**
     * Fetch Items User has requested
     */
    public function checkoutRequests()
    {
        return $this->belongsToMany(Asset::class, 'checkout_requests', 'user_id', 'requestable_id')->whereNull('canceled_at');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    /**
     * Get consumables assigned to this user
     */
    public function consumables()
    {
        return $this->belongsToMany('\App\Models\Consumable', 'consumables_users', 'assigned_to', 'consumable_id')->withPivot('id')->withTrashed();
    }

    public function department()
    {
        return $this->belongsTo('\App\Models\Department', 'department_id');
    }

    /**
     * Get user groups
     */
    public function groups()
    {
        return $this->belongsToMany('\App\Models\Group', 'users_groups');
    }

    /**
     * Get licenses assigned to this user
     */
    public function licenses()
    {
        return $this->belongsToMany('\App\Models\License', 'license_seats', 'assigned_to', 'license_id')->withPivot('id');
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

    public function throttle()
    {
        return $this->hasOne('\App\Models\Throttle');
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
     * Get action logs for this user
     */
    public function userlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'target_id')->orderBy('created_at', 'DESC')->withTrashed();
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

}
