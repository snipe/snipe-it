<?php

namespace App\Models\Relationships;


/**
 * This trait wraps all accessory model relationships,
 *
 */
trait LocationRelationships {

    public function users()
    {
        return $this->hasMany('\App\Models\User', 'location_id');
    }

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'location_id')
            ->whereHas('assetstatus', function ($query) {
                $query->where('status_labels.deployable', '=', 1)
                    ->orWhere('status_labels.pending', '=', 1)
                    ->orWhere('status_labels.archived', '=', 0);
            });
    }

    public function rtd_assets()
    {
        /* This used to have an ...->orHas() clause that referred to
           assignedAssets, and that was probably incorrect, as well as
           definitely was setting fire to the query-planner. So don't do that.

           It is arguable that we should have a '...->whereNull('assigned_to')
           bit in there, but that isn't always correct either (in the case
           where a user has no location, for example).

           In all likelyhood, we need to denorm an "effective_location" column
           into Assets to make this slightly less miserable.
        */
        return $this->hasMany('\App\Models\Asset', 'rtd_location_id');
    }

    public function parent()
    {
        return $this->belongsTo('\App\Models\Location', 'parent_id','id');
    }

    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id');
    }

    public function childLocations()
    {
        return $this->hasMany('\App\Models\Location', 'parent_id');
    }

    // I don't think we need this anymore since we de-normed location_id in assets?
    public function assignedAssets()
    {
        return $this->morphMany('App\Models\Asset', 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

}
