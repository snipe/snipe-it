<?php

namespace App\Models\Relationships;


use App\Models\Accessory;

/**
 * This trait wraps all assetmodel model relationships,
 *
 */
trait AssetModelRelationships {

    public function adminuser()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'model_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function defaultValues()
    {
        return $this->belongsToMany('\App\Models\CustomField', 'models_custom_fields')->withPivot('default_value');
    }

    public function depreciation()
    {
        return $this->belongsTo('\App\Models\Depreciation', 'depreciation_id');
    }

    public function fieldset()
    {
        return $this->belongsTo('\App\Models\CustomFieldset', 'fieldset_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }


}
