<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait CustomFieldRelationships {

    public function defaultValues()
    {
        return $this->belongsToMany('\App\Models\AssetModel', 'models_custom_fields')->withPivot('default_value');
    }

    public function fieldset()
    {
        return $this->belongsToMany('\App\Models\CustomFieldset');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

}
