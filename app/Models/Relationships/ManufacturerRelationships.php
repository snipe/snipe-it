<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait ManufacturerRelationships {

    public function has_models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'manufacturer_id')->count();
    }

    public function assets()
    {
        return $this->hasManyThrough('\App\Models\Asset', '\App\Models\AssetModel', 'manufacturer_id', 'model_id');
    }

    public function models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'manufacturer_id');
    }

    public function licenses()
    {
        return $this->hasMany('\App\Models\License', 'manufacturer_id');
    }

    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory', 'manufacturer_id');
    }

    public function consumables()
    {
        return $this->hasMany('\App\Models\Consumable', 'manufacturer_id');
    }
}
