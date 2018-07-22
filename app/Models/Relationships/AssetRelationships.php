<?php

namespace App\Models\Relationships;



use App\Models\Asset;

/**
 * This trait wraps all asset model relationships,
 *
 */
trait AssetRelationships {


    /**
     * Get action logs for this asset
     */
    public function adminuser()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    /**
     * Get total assets
     */
    public static function assetcount()
    {
        return Company::scopeCompanyables(Asset::where('physical', '=', '1'))
            ->whereNull('deleted_at', 'and')
            ->count();
    }

    /**
     * Get action logs for this asset
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', Asset::class)
            ->orderBy('created_at', 'desc')
            ->withTrashed();
    }

    /**
     * assetmaintenances
     * Get improvements for this asset
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function assetmaintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'asset_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get asset status
     */
    public function assetstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }

    /**
     * Get total assets not checked out
     */
    public static function availassetcount()
    {
        return Asset::RTD()
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Get checkins
     */
    public function checkins()
    {
        return $this->assetlog()
            ->where('action_type', '=', 'checkin from')
            ->orderBy('created_at', 'desc')
            ->withTrashed();
    }

    /**
     * Get checkouts
     */
    public function checkouts()
    {
        return $this->assetlog()->where('action_type', '=', 'checkout')
            ->orderBy('created_at', 'desc')
            ->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    /**
     * Get components assigned to this asset
     */
    public function components()
    {
        return $this->belongsToMany('\App\Models\Component', 'components_assets', 'asset_id', 'component_id')->withPivot('id', 'assigned_qty')->withTrashed();
    }

    /**
     * Get the asset's location based on default RTD location
     **/
    public function defaultLoc()
    {
        return $this->belongsTo('\App\Models\Location', 'rtd_location_id');
    }

    /**
     * Set depreciation relationship
     */
    public function depreciation()
    {
        return $this->model->belongsTo('\App\Models\Depreciation', 'depreciation_id');
    }

    /**
     * Get requestable assets
     */
    public static function getRequestable()
    {
        return Asset::Requestable()
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Get the license seat information
     **/
    public function licenses()
    {
        return $this->belongsToMany('\App\Models\License', 'license_seats', 'asset_id', 'license_id');
    }

    public function licenseseats()
    {
        return $this->hasMany('\App\Models\LicenseSeat', 'asset_id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function model()
    {
        return $this->belongsTo('\App\Models\AssetModel', 'model_id')->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    /**
     * Get uploads for this asset
     */
    public function uploads()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', Asset::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get user requests
     */
    public function userRequests()
    {
        return $this->assetlog()
            ->where('action_type', '=', 'requested')
            ->orderBy('created_at', 'desc')
            ->withTrashed();
    }

}
