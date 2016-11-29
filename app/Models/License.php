<?php
namespace App\Models;

use App\Models\Company;
use App\Models\Loggable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class License extends Depreciable
{
    use SoftDeletes;
    use CompanyableTrait;
    use Loggable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'licenses';
    protected $rules = array(
        'name'   => 'required|string|min:3|max:255',
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
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', License::class)
            ->orderBy('created_at', 'desc');
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

    // We do this to eager load the "count" of seats from the controller.  Otherwise calling "count()" on each model results in n+1
    public function licenseSeatsRelation()
    {
        return $this->hasMany(LicenseSeat::class)->whereNull('deleted_at')->selectRaw('license_id, count(*) as count')->groupBy('license_id');
    }

    public function getLicenseSeatsCountAttribute()
    {
        if ($this->licenseSeatsRelation->first()) {
            return $this->licenseSeatsRelation->first()->count;
        }

        return 0;
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
    public function availCount()
    {
        return $this->licenseSeatsRelation()
            ->whereNull('asset_id');
    }

    public function getAvailSeatsCountAttribute()
    {
        if ($this->availCount->first()) {
            return $this->availCount->first()->count;
        }

        return 0;
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

    public function getAssignedSeatsCountAttribute()
    {
        // dd($this->licenseSeatsRelation->first());
        if ($this->assignedCount->first()) {
            return $this->assignedCount->first()->count;
        }

        return 0;
    }

    public function remaincount()
    {
        $total = $this->licenseSeatsCount;
        $taken =  $this->assigned_seats_count;
        $diff =   ($total - $taken);
        return $diff;
    }

    /**
     * Get the total number of seats
     */
    public function totalcount()
    {
        $avail =  $this->availSeatsCount;
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

            $query->where('licenses.name', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.serial', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.notes', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.order_number', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.purchase_order', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.purchase_date', 'LIKE', '%'.$search.'%')
                ->orWhere('licenses.purchase_cost', 'LIKE', '%'.$search.'%')
             ->orWhereHas('manufacturer', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('manufacturers.name', 'LIKE', '%'.$search.'%');
                    });
                })
            ->orWhereHas('company', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('companies.name', 'LIKE', '%'.$search.'%');
                });
            });
        });
    }

    /**
     * Query builder scope to order on manufacturer
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManufacturer($query, $order)
    {
        return $query->leftJoin('manufacturers', 'licenses.manufacturer_id', '=', 'manufacturers.id')->select('licenses.*')
            ->orderBy('manufacturers.name', $order);
    }

    /**
     * Query builder scope to order on company
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as companies', 'licenses.company_id', '=', 'companies.id')->select('licenses.*')
            ->orderBy('companies.name', $order);
    }
}
