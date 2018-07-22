<?php

namespace App\Models\Relationships;


use App\Models\Accessory;

/**
 * This trait wraps all custom fieldset model relationships,
 *
 */
trait CustomFieldsetRelationships {

    public function fields()
    {
        return $this->belongsToMany('\App\Models\CustomField')->withPivot(["required","order"])->orderBy("pivot_order");
    }

    public function models()
    {
        return $this->hasMany('\App\Models\AssetModel', "fieldset_id");
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User'); //WARNING - not all CustomFieldsets have a User!!
    }
}
