<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all component model relationships,
 *
 */
trait ComponentRelationships {

    /**
     * Get action logs for this consumable
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')->where('item_type', Component::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    public function assets()
    {
        return $this->belongsToMany('\App\Models\Asset', 'components_assets')->withPivot('id', 'assigned_qty', 'created_at', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

}
