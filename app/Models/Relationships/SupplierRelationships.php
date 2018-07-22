<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait SupplierRelationships {

    // Eager load counts.
    // We do this to eager load the "count" of seats from the controller.  Otherwise calling "count()" on each model results in n+1
    public function assetsRelation()
    {
        return $this->hasMany(Asset::class)->whereNull('deleted_at')->selectRaw('supplier_id, count(*) as count')->groupBy('supplier_id');
    }

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'supplier_id');
    }

    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory', 'supplier_id');
    }

    public function asset_maintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'supplier_id');
    }

    public function licenses()
    {
        return $this->hasMany('\App\Models\License', 'supplier_id');
    }

}
