<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait ConsumableRelationships {

    public function admin()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    /**
     * Get action logs for this consumable
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')->where('item_type', Consumable::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function consumableAssignments()
    {
        return $this->hasMany('\App\Models\ConsumableAssignment');
    }

    public function hasUsers()
    {
        return $this->belongsToMany('\App\Models\User', 'consumables_users', 'consumable_id', 'assigned_to')->count();
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'consumables_users', 'consumable_id', 'assigned_to')->withPivot('user_id')->withTrashed()->withTimestamps();
    }
}
