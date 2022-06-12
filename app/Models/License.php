<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Watson\Validating\ValidatingTrait;

class License extends Depreciable
{
    use HasFactory;

    protected $presenter = \App\Presenters\LicensePresenter::class;

    use SoftDeletes;
    use CompanyableTrait;
    use Loggable, Presentable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    // We set these as protected dates so that they will be easily accessible via Carbon

    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'licenses';

    protected $casts = [
        'purchase_date' => 'datetime',
        'expiration_date' => 'datetime',
        'termination_date' => 'datetime',
        'seats'   => 'integer',
        'category_id'  => 'integer',
        'company_id'   => 'integer',
    ];

    protected $rules = [
        'name'   => 'required|string|min:3|max:255',
        'seats'   => 'required|min:1|integer',
        'license_email'   => 'email|nullable|max:120',
        'license_name'   => 'string|nullable|max:100',
        'notes'   => 'string|nullable',
        'category_id' => 'required|exists:categories,id',
        'company_id' => 'integer|nullable',
        'purchase_cost'=> 'numeric|nullable|gte:0',
    ];

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
      'depreciation' => ['name'],
    ];

    /**
     * Update seat counts when the license is updated
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     */
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

    /**
     * Balance seat counts
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function adjustSeatCount($license, $oldSeats, $newSeats)
    {
        // If the seats haven't changed, continue on happily.
        if ($oldSeats == $newSeats) {
            return true;
        }
        // On Create, we just make one for each of the seats.
        $change = abs($oldSeats - $newSeats);
        if ($oldSeats > $newSeats) {
            $license->load('licenseseats.user');

            // Need to delete seats... lets see if if we have enough.
            $seatsAvailableForDelete = $license->licenseseats->reject(function ($seat) {
                return ((bool) $seat->assigned_to) || ((bool) $seat->asset_id);
            });

            if ($change > $seatsAvailableForDelete->count()) {
                Session::flash('error', trans('admin/licenses/message.assoc_users'));

                return false;
            }
            for ($i = 1; $i <= $change; $i++) {
                $seatsAvailableForDelete->pop()->delete();
            }
            // Log Deletion of seats.
            $logAction = new Actionlog;
            $logAction->item_type = self::class;
            $logAction->item_id = $license->id;
            $logAction->user_id = Auth::id() ?: 1; // We don't have an id while running the importer from CLI.
            $logAction->note = "deleted ${change} seats";
            $logAction->target_id = null;
            $logAction->logaction('delete seats');

            return true;
        }
        // Else we're adding seats.
        //Create enough seats for the change.
        $licenseInsert = [];
        for ($i = $oldSeats; $i < $newSeats; $i++) {
            $licenseInsert[] = [
                'user_id' => Auth::id(),
                'license_id' => $license->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        //Chunk and use DB transactions to prevent timeouts.

        collect($licenseInsert)->chunk(1000)->each(function ($chunk) {
            DB::transaction(function () use ($chunk) {
                LicenseSeat::insert($chunk->toArray());
            });
        });

        // On initial create, we shouldn't log the addition of seats.
        if ($license->id) {
            //Log the addition of license to the log.
            $logAction = new Actionlog();
            $logAction->item_type = self::class;
            $logAction->item_id = $license->id;
            $logAction->user_id = Auth::id() ?: 1; // Importer.
            $logAction->note = "added ${change} seats";
            $logAction->target_id = null;
            $logAction->logaction('add seats');
        }

        return true;
    }

    /**
     * Sets the attribute for whether or not the license is maintained
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return mixed
     */
    public function setMaintainedAttribute($value)
    {
        $this->attributes['maintained'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Sets the reassignable attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return mixed
     */
    public function setReassignableAttribute($value)
    {
        $this->attributes['reassignable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Sets expiration date attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return mixed
     */
    public function setExpirationDateAttribute($value)
    {
        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['expiration_date'] = $value;
    }

    /**
     * Sets termination date attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return mixed
     */
    public function setTerminationDateAttribute($value)
    {
        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['termination_date'] = $value;
    }

    /**
     * Establishes the license -> company relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * Establishes the license -> category relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * Establishes the license -> manufacturer relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function manufacturer()
    {
        return $this->belongsTo(\App\Models\Manufacturer::class, 'manufacturer_id');
    }

    /**
     * Determine whether the user should be emailed on checkin/checkout
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return bool
     */
    public function checkin_email()
    {
        return $this->category->checkin_email;
    }

    /**
     * Determine whether the user should be required to accept the license
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return bool
     */
    public function requireAcceptance()
    {
        return $this->category->require_acceptance;
    }

    /**
     * Checks for a category-specific EULA, and if that doesn't exist,
     * checks for a settings level EULA
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return string | false
     */
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
     * Establishes the license -> assigned user relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assignedusers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'license_seats', 'assigned_to', 'license_id');
    }

    /**
     * Establishes the license -> action logs relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetlog()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'item_id')
            ->where('item_type', '=', self::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Establishes the license -> action logs -> uploads relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function uploads()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'item_id')
            ->where('item_type', '=', self::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }


    /**
     * Establishes the license -> admin user relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function adminuser()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Returns the total number of all license seats
     *
     * @todo this can probably be refactored at some point. We don't need counting methods.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return int
     */
    public static function assetcount()
    {
        return LicenseSeat::whereNull('deleted_at')
                   ->count();
    }


    /**
     * Return the number of seats for this asset
     *
     * @todo this can also probably be refactored at some point.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function totalSeatsByLicenseID()
    {
        return LicenseSeat::where('license_id', '=', $this->id)
                   ->whereNull('deleted_at')
                   ->count();
    }

    /**
     * Establishes the license -> seat relationship
     *
     * We do this to eager load the "count" of seats from the controller.
     * Otherwise calling "count()" on each model results in n+1 sadness.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function licenseSeatsRelation()
    {
        return $this->hasMany(LicenseSeat::class)->whereNull('deleted_at')->selectRaw('license_id, count(*) as count')->groupBy('license_id');
    }

    /**
     * Sets the license seat count attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return int
     */
    public function getLicenseSeatsCountAttribute()
    {
        if ($this->licenseSeatsRelation->first()) {
            return $this->licenseSeatsRelation->first()->count;
        }

        return 0;
    }

    /**
     * Returns the number of total available seats across all licenses
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return int
     */
    public static function availassetcount()
    {
        return LicenseSeat::whereNull('assigned_to')
                   ->whereNull('asset_id')
                   ->whereNull('deleted_at')
                   ->count();
    }

    /**
     * Returns the number of total available seats for this license
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function availCount()
    {
        return $this->licenseSeatsRelation()
            ->whereNull('asset_id')
            ->whereNull('assigned_to')
            ->whereNull('deleted_at');
    }

    /**
     * Sets the available seats attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return mixed
     */
    public function getAvailSeatsCountAttribute()
    {
        if ($this->availCount->first()) {
            return $this->availCount->first()->count;
        }

        return 0;
    }

    /**
     * Retuns the number of assigned seats for this asset
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assignedCount()
    {
        return $this->licenseSeatsRelation()->where(function ($query) {
            $query->whereNotNull('assigned_to')
            ->orWhereNotNull('asset_id');
        });
    }

    /**
     * Sets the assigned seats attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return int
     */
    public function getAssignedSeatsCountAttribute()
    {
        if ($this->assignedCount->first()) {
            return $this->assignedCount->first()->count;
        }

        return 0;
    }

    /**
     * Calculates the number of remaining seats
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return int
     */
    public function remaincount()
    {
        $total = $this->licenseSeatsCount;
        $taken = $this->assigned_seats_count;
        $diff = ($total - $taken);

        return $diff;
    }

    /**
     * Returns the total number of seats for this license
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return int
     */
    public function totalcount()
    {
        $avail = $this->availSeatsCount;
        $taken = $this->assignedcount();
        $diff = ($avail + $taken);

        return $diff;
    }

    /**
     * Establishes the license -> seats relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function licenseseats()
    {
        return $this->hasMany(\App\Models\LicenseSeat::class);
    }

    /**
     * Establishes the license -> supplier relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }


    /**
     * Gets the next available free seat - used by
     * the API to populate next_seat
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return mixed
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


    /**
     * Establishes the license -> free seats relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function freeSeats()
    {
        return $this->hasMany(\App\Models\LicenseSeat::class)->whereNull('assigned_to')->whereNull('deleted_at')->whereNull('asset_id');
    }

    /**
     * Returns expiring licenses
     *
     * @todo should refactor. I don't like get() in model methods
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function getExpiringLicenses($days = 60)
    {
        $days = (is_null($days)) ? 60 : $days;

        return self::whereNotNull('expiration_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`expiration_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('expiration_date', '>', date('Y-m-d'))
        ->orderBy('expiration_date', 'ASC')
        ->get();
    }

    /**
     * Query builder scope to order on manufacturer
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
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
     * @param  string                              $order         Order
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
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as companies', 'licenses.company_id', '=', 'companies.id')->select('licenses.*')
            ->orderBy('companies.name', $order);
    }
}
