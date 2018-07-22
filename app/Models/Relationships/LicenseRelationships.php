<?php

namespace App\Models\Relationships;


use App\Models\License;
use App\Models\LicenseSeat;

/**
 * This trait wraps all accessory model relationships,
 *
 */
trait LicenseRelationships {

    /**
     * Get admin user for this asset
     */
    public function adminuser()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    /**
     * Get total licenses
     */
    public static function assetcount()
    {
        return LicenseSeat::whereNull('deleted_at')
            ->count();
    }

    /**
     * Get asset logs for this asset
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', License::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the number of assigned seats
     *
     */
    public function assignedCount()
    {
        return $this->licenseSeatsRelation()->where(function ($query) {
            $query->whereNotNull('assigned_to')
                ->orWhereNotNull('asset_id');
        });
    }

    /**
     * Get the assigned user
     */
    public function assignedusers()
    {
        return $this->belongsToMany('\App\Models\User', 'license_seats', 'assigned_to', 'license_id');
    }


    /**
     * Get the number of available seats
     */
    public function availCount()
    {
        return $this->licenseSeatsRelation()
            ->whereNull('asset_id')
            ->whereNull('assigned_to')
            ->whereNull('deleted_at');
    }

    /**
     * Get total licenses not checked out
     */
    public static function availassetcount()
    {
        return LicenseSeat::whereNull('assigned_to')
            ->whereNull('asset_id')
            ->whereNull('deleted_at')
            ->count();
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }
    /**
     * Get the next available free seat - used by
     * the API to populate next_seat
     */
    public function freeSeats()
    {
        return $this->hasMany('\App\Models\LicenseSeat')->whereNull('assigned_to')->whereNull('deleted_at')->whereNull('asset_id');
    }

    /**
     * Get license seat data
     */
    public function licenseseats()
    {
        return $this->hasMany('\App\Models\LicenseSeat');
    }

    // We do this to eager load the "count" of seats from the controller.  Otherwise calling "count()" on each model results in n+1
    public function licenseSeatsRelation()
    {
        return $this->hasMany(LicenseSeat::class)->whereNull('deleted_at')->selectRaw('license_id, count(*) as count')->groupBy('license_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    /**
     * Get total licenses
     */
    public function totalSeatsByLicenseID()
    {
        return LicenseSeat::where('license_id', '=', $this->id)
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Get uploads for this asset
     */
    public function uploads()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', License::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

}
