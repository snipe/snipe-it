<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all licenseseat model relationships,
 *
 */
trait LicenseSeatRelationships {

    public function asset()
    {
        return $this->belongsTo('\App\Models\Asset', 'asset_id')->withTrashed();
    }

    public function license()
    {
        return $this->belongsTo('\App\Models\License', 'license_id');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'assigned_to')->withTrashed();
    }

}
