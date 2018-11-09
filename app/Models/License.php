<?php
namespace App\Models;

use App\Models\Actionlog;
use App\Models\Company;
use App\Models\LicenseSeat;
use App\Models\Loggable;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Watson\Validating\ValidatingTrait;

class License extends Depreciable
{
    protected $presenter = 'App\Presenters\LicensePresenter';

    /**
     * Set static properties to determine which checkout/checkin handlers we should use
     */
    public static $checkoutClass = CheckoutLicenseNotification::class;
    public static $checkinClass = CheckinLicenseNotification::class;


    use SoftDeletes;
    use CompanyableTrait;
    use Loggable, Presentable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    // We set these as protected dates so that they will be easily accessible via Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'purchase_date',
        'expiration_date',
        'termination_date'
    ];


    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'licenses';
    protected $rules = array(
        'name'   => 'required|string|min:3|max:255',
        'seats'   => 'required|min:1|max:1000000|integer',
        'license_email'   => 'email|nullable|max:120',
        'license_name'   => 'string|nullable|max:100',
        'notes'   => 'string|nullable',
        'category_id' => 'required|exists:categories,id',
        'company_id' => 'integer|nullable',
    );

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'company_id',
        'depreciation_id',
        'expiration_date',
        'license_email',
        'license_name', //actually licensed_to
        'maintained',
        'manufacturer_id',
        'category_id',
        'name',
        'notes',
        'order_number',
        'purchase_cost',
        'purchase_date',
        'purchase_order',
        'reassignable',
        'seats',
        'serial',
        'supplier_id',
        'termination_date',
        'user_id',
    ];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
        'name', 
        'serial', 
        'notes', 
        'order_number', 
        'purchase_order', 
        'purchase_cost', 
        'purchase_date',
        'expiration_date',
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
      'manufacturer' => ['name'],
      'company'      => ['name'],
      'category'     => ['name'],
    ];    

    public static function boot()
    {
        parent::boot();
        // We need to listen for created for the initial setup so that we have a license ID.
        static::created(function ($license) {
            $newSeatCount = $license->getAttributes()['seats'];
            return static::adjustSeatCount($license, $oldSeatCount = 0, $newSeatCount);
        });
        // However, we listen for updating to be able to prevent the edit if we cannot delete enough seats.
        static::updating(function ($license) {
            $newSeatCount = $license->getAttributes()['seats'];
            $oldSeatCount = isset($license->getOriginal()['seats']) ? $license->getOriginal()['seats'] : 0;
            return static::adjustSeatCount($license, $oldSeatCount, $newSeatCount);
        });
    }

    public static function adjustSeatCount($license, $oldSeats, $newSeats)
    {
        // If the seats haven't changed, continue on happily.
        if ($oldSeats==$newSeats) {
            return true;
        }
        // On Create, we just make one for each of the seats.
        $change = abs($oldSeats - $newSeats);
        if ($oldSeats > $newSeats) {
            $license->load('licenseseats.user');

            // Need to delete seats... lets see if if we have enough.
            $seatsAvailableForDelete = $license->licenseseats->reject(function ($seat) {
                return (!! $seat->assigned_to) || (!! $seat->asset_id);
            });

            if ($change > $seatsAvailableForDelete->count()) {
                Session::flash('error', trans('admin/licenses/message.assoc_users'));
                return false;
            }
            for ($i=1; $i <= $change; $i++) {
                $seatsAvailableForDelete->pop()->delete();
            }
            // Log Deletion of seats.
            $logAction = new Actionlog;
            $logAction->item_type = License::class;
            $logAction->item_id = $license->id;
            $logAction->user_id = Auth::id() ?: 1; // We don't have an id while running the importer from CLI.
            $logAction->note = "deleted ${change} seats";
            $logAction->target_id =  null;
            $logAction->logaction('delete seats');
            return true;
        }
        // Else we're adding seats.
        DB::transaction(function () use ($license, $oldSeats, $newSeats) {
            for ($i = $oldSeats; $i < $newSeats; $i++) {
                $license->licenseSeatsRelation()->save(new LicenseSeat, ['user_id' => Auth::id()]);
            }
        });
        // On initail create, we shouldn't log the addition of seats.
        if ($license->id) {
            //Log the addition of license to the log.
            $logAction = new Actionlog();
            $logAction->item_type = License::class;
            $logAction->item_id = $license->id;
            $logAction->user_id = Auth::id() ?: 1; // Importer.
            $logAction->note = "added ${change} seats";
            $logAction->target_id =  null;
            $logAction->logaction('add seats');
        }
        return true;
    }

    public function setMaintainedAttribute($value)
    {
        $this->attributes['maintained'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
    public function setReassignableAttribute($value)
    {
        $this->attributes['reassignable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function setExpirationDateAttribute($value)
    {

        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['expiration_date'] = $value;
    }

    public function setTerminationDateAttribute($value)
    {
        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['termination_date'] = $value;
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function checkin_email()
    {
        return $this->category->checkin_email;
    }

    public function requireAcceptance()
    {
        return $this->category->require_acceptance;
    }

    public function getEula()
    {
        $Parsedown = new \Parsedown();

        if ($this->category->eula_text) {
            return $Parsedown->text(e($this->category->eula_text));
        } elseif ($this->category->use_default_eula == '1') {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        } else {
            return false;
        }
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
            ->whereNull('asset_id')
            ->whereNull('assigned_to')
            ->whereNull('deleted_at');
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

    /*
     * Get the next available free seat - used by
     * the API to populate next_seat
     */
    public function freeSeat()
    {
        return  $this->licenseseats()
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        $query->whereNull('assigned_to')
                            ->whereNull('asset_id');
                    })
                    ->orderBy('id', 'asc')
                    ->first();
    }

    /*
   * Get the next available free seat - used by
   * the API to populate next_seat
   */
    public function freeSeats()
    {
        return $this->hasMany('\App\Models\LicenseSeat')->whereNull('assigned_to')->whereNull('deleted_at')->whereNull('asset_id');
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
     * Query builder scope to order on supplier
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderSupplier($query, $order)
    {
        return $query->leftJoin('suppliers', 'licenses.supplier_id', '=', 'suppliers.id')->select('licenses.*')
            ->orderBy('suppliers.name', $order);
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
