<?php

namespace App\Models\Relationships;


use App\Models\Accessory;

/**
 * This trait wraps all accessory model relationships,
 *
 */
trait AccessoryRelationships {

    /**
     * Get action logs for this accessory
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')->where('item_type', Accessory::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id')->where('category_type', '=', 'accessory');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function hasUsers()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->count();
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->withPivot('id')->withTrashed();
    }

}
