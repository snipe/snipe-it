<?php

namespace App\Models\Relationships;



/**
 * This trait wraps all category model relationships,
 *
 */
trait CategoryRelationships {

    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory');
    }

    public function assets()
    {
        return $this->hasManyThrough('\App\Models\Asset', '\App\Models\AssetModel', 'category_id', 'model_id');
    }

    public function components()
    {
        return $this->hasMany('\App\Models\Component');
    }

    public function consumables()
    {
        return $this->hasMany('\App\Models\Consumable');
    }

    public function has_models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'category_id')->count();
    }

    public function licenses()
    {
        return $this->hasMany('\App\Models\License');
    }

    public function models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'category_id');
    }
}
