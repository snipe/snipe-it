<?php
namespace App\Models;

use App\Models\Company;
use DB;
use Watson\Validating\ValidatingTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

class License extends Depreciable
{
    use SoftDeletes;
    use CompanyableTrait;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'licenses';
    protected $rules = array(
        'name'   => 'required|string|min:3|max:255',
        'serial'   => 'required|min:5',
        'seats'   => 'required|min:1|max:10000|integer',
        'license_email'   => 'email|min:0|max:120',
        'license_name'   => 'string|min:0|max:100',
        'note'   => 'string',
        'notes'   => 'string|min:0',
        'company_id' => 'integer',
    );

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    /**
     * Get the assigned user
     */
    public function assignedusers()
    {
        return $this->belongsToMany('\App\Models\User', 'license_seats', 'assigned_to', 'license_id');
    }

    /**
    * Get asset logs for this asset
    */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'asset_id')
            ->where('asset_type', '=', 'software')
            ->orderBy('created_at', 'desc');
    }

    /**
    * Get uploads for this asset
    */
    public function uploads()
    {
        return $this->hasMany('\App\Models\Actionlog', 'asset_id')
            ->where('asset_type', '=', 'software')
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }


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
    * Get total licenses
    */
    public function totalSeatsByLicenseID()
    {
        return LicenseSeat::where('license_id', '=', $this->id)
                   ->whereNull('deleted_at')
                   ->count();
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

    /**
     * Get the number of available seats
     */
    public function availcount()
    {
        return LicenseSeat::whereNull('assigned_to')
                    ->whereNull('asset_id')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at')
                    ->count();
    }

    /**
     * Get the number of assigned seats
     *
     */
    public function assignedcount()
    {

        return \App\Models\LicenseSeat::where('license_id', '=', $this->id)
            ->where(function ($query) {

                $query->whereNotNull('assigned_to')
                ->orWhereNotNull('asset_id');
            })
        ->count();


    }

    public function remaincount()
    {
        $total = $this->totalSeatsByLicenseID();
        $taken =  $this->assignedcount();
        $diff =   ($total - $taken);
        return $diff;
    }

    /**
     * Get the total number of seats
     */
    public function totalcount()
    {
        $avail =  $this->availcount();
        $taken =  $this->assignedcount();
        $diff =   ($avail + $taken);
        return $diff;
    }

    /**
     * Get license seat data
     */
    public function licenseseats()
    {
        return $this->hasMany('\App\Models\LicenseSeat');
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    public function freeSeat()
    {
        $seat = LicenseSeat::where('license_id', '=', $this->id)
                    ->whereNull('deleted_at')
                    ->whereNull('assigned_to')
                    ->whereNull('asset_id')
                    ->first();
        return $seat->id;
    }

    public static function getExpiringLicenses($days = 60)
    {

        return License::whereNotNull('expiration_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`expiration_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('expiration_date', '>', date("Y-m-d"))
        ->orderBy('expiration_date', 'ASC')
        ->get();

    }

    /**
    * Query builder scope to search on text
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $search      Search term
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeTextSearch($query, $search)
    {

        return $query->where(function ($query) use ($search) {

            $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('serial', 'LIKE', '%'.$search.'%')
                ->orWhere('notes', 'LIKE', '%'.$search.'%')
                ->orWhere('order_number', 'LIKE', '%'.$search.'%')
                ->orWhere('purchase_order', 'LIKE', '%'.$search.'%')
                ->orWhere('purchase_date', 'LIKE', '%'.$search.'%')
                ->orWhere('purchase_cost', 'LIKE', '%'.$search.'%');
        });
    }
}
