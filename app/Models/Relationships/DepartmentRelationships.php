<?php

namespace App\Models\Relationships;

/**
 * This trait wraps all department model relationships,
 *
 */
trait DepartmentRelationships {

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    /**
     * Return the manager in charge of the dept
     * @return mixed
     */
    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id');
    }

    /**
     * Even though we allow allow for checkout to things beyond users
     * this method is an easy way of seeing if we are checked out to a user.
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany('\App\Models\User', 'department_id');
    }
}
