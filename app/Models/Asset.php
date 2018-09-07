<?php
namespace App\Models;

use App\Exceptions\CheckoutNotAllowed;
use App\Http\Traits\UniqueSerialTrait;
use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use AssetPresenter;
use Auth;
use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use Watson\Validating\ValidatingTrait;
use DB;
use App\Notifications\CheckinAssetNotification;
use App\Notifications\CheckoutAssetNotification;

/**
 * Model for Assets.
 *
 * @version    v1.0
 */
class Asset extends Depreciable
{
    protected $presenter = 'App\Presenters\AssetPresenter';
    use Loggable, Requestable, Presentable, SoftDeletes, ValidatingTrait, UniqueUndeletedTrait, UniqueSerialTrait;

    const LOCATION = 'location';
    const ASSET = 'asset';
    const USER = 'user';

    const ACCEPTANCE_PENDING = 'pending';
    /**
     * Set static properties to determine which checkout/checkin handlers we should use
     */
    public static $checkoutClass = CheckoutAssetNotification::class;
    public static $checkinClass = CheckinAssetNotification::class;


    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'assets';

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;

    // We set these as protected dates so that they will be easily accessible via Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'purchase_date',
        'last_checkout',
        'expected_checkin',
        'last_audit_date',
        'next_audit_date'
    ];



    protected $rules = [
        'name'            => 'max:255|nullable',
        'model_id'        => 'required|integer|exists:models,id',
        'status_id'       => 'required|integer|exists:status_labels,id',
        'company_id'      => 'integer|nullable',
        'warranty_months' => 'numeric|nullable',
        'physical'        => 'numeric|max:1|nullable',
        'checkout_date'   => 'date|max:10|min:10|nullable',
        'checkin_date'    => 'date|max:10|min:10|nullable',
        'supplier_id'     => 'numeric|nullable',
        'asset_tag'       => 'required|min:1|max:255|unique_undeleted',
        'status'          => 'integer',
        'serial'          => 'unique_serial|nullable',
        'purchase_cost'   => 'numeric|nullable',
        'next_audit_date'  => 'date|nullable',
        'last_audit_date'  => 'date|nullable',
    ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'asset_tag',
        'assigned_to',
        'assigned_type',
        'company_id',
        'image',
        'location_id',
        'model_id',
        'name',
        'notes',
        'order_number',
        'purchase_cost',
        'purchase_date',
        'rtd_location_id',
        'serial',
        'status_id',
        'supplier_id',
        'warranty_months',
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
      'name', 
      'asset_tag', 
      'serial', 
      'order_number', 
      'purchase_cost', 
      'notes', 
      'created_at',
      'updated_at',      
      'purchase_date', 
      'expected_checkin', 
      'next_audit_date', 
      'last_audit_date'
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
        'assetstatus'        => ['name'],
        'supplier'           => ['name'],
        'company'            => ['name'],
        'defaultLoc'         => ['name'],
        'model'              => ['name', 'model_number'],
        'model.category'     => ['name'],
        'model.manufacturer' => ['name'],
    ];     

    public function getDisplayNameAttribute()
    {
        return $this->present()->name();
    }

    /**
     * Returns the warranty expiration date as Carbon object
     * @return \Carbon|null
     */
    public function getWarrantyExpiresAttribute()
    {
        if (isset($this->attributes['warranty_months']) && isset($this->attributes['purchase_date'])) {
            if (is_string($this->attributes['purchase_date']) || is_string($this->attributes['purchase_date'])) {
                $purchase_date = \Carbon\Carbon::parse($this->attributes['purchase_date']);
            } else {
                $purchase_date = \Carbon\Carbon::instance($this->attributes['purchase_date']);
            }
            $purchase_date->setTime(0, 0, 0);
            return $purchase_date->addMonths((int) $this->attributes['warranty_months']);
        }

        return null;
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }


    public function availableForCheckout()
    {
        if (
            (empty($this->assigned_to)) &&
            (empty($this->deleted_at)) &&
            (($this->assetstatus) && ($this->assetstatus->deployable == 1)))
        {
            return true;
        }
        return false;
    }

    /**
     * Checkout asset
     * @param User $user
     * @param User $admin
     * @param Carbon $checkout_at
     * @param Carbon $expected_checkin
     * @param string $note
     * @param null $name
     * @return bool
     */
    //FIXME: The admin parameter is never used. Can probably be removed.
    public function checkOut($target, $admin = null, $checkout_at = null, $expected_checkin = null, $note = null, $name = null, $location = null)
    {
        if (!$target) {
            return false;
        }

        if ($expected_checkin) {
            $this->expected_checkin = $expected_checkin;
        }

        $this->last_checkout = $checkout_at;

        $this->assignedTo()->associate($target);


        if ($name != null) {
            $this->name = $name;
        }

        if ($location != null) {
            $this->location_id = $location;
        } else {
            if($target->location) {
                $this->location_id = $target->location->id;
            }
            if($target instanceof Location) {
                $this->location_id = $target->id;
            }
        }
        
        /**
         * Does the user have to confirm that they accept the asset?
         *
         * If so, set the acceptance-status to "pending".
         * This value is used in the unaccepted assets reports, for example
         * 
         * @see https://github.com/snipe/snipe-it/issues/5772
         */
        if ($this->requireAcceptance() && $target instanceof User) {
          $this->accepted = self::ACCEPTANCE_PENDING;
        }

        if ($this->save()) {
            $this->logCheckout($note, $target);
            $this->increment('checkout_counter', 1);
            return true;
        }
        return false;
    }

    public function getDetailedNameAttribute()
    {
        if ($this->assignedto) {
            $user_name = $this->assignedto->present()->name();
        } else {
            $user_name = "Unassigned";
        }
        return $this->asset_tag . ' - ' . $this->name . ' (' . $user_name . ') ' . ($this->model) ? $this->model->name: '';
    }

    public function validationRules($id = '0')
    {
        return $this->rules;
    }


    /**
   * Set depreciation relationship
   */
    public function depreciation()
    {
        return $this->model->belongsTo('\App\Models\Depreciation', 'depreciation_id');
    }

    /**
     * Get components assigned to this asset
     */
    public function components()
    {
        return $this->belongsToMany('\App\Models\Component', 'components_assets', 'asset_id', 'component_id')->withPivot('id', 'assigned_qty')->withTrashed();
    }

  /**
   * Get depreciation attribute from associated asset model
   */
    public function get_depreciation()
    {
        if (($this->model) && ($this->model->depreciation)) {
            return $this->model->depreciation;
        }
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
     * Even though we allow allow for checkout to things beyond users
     * this method is an easy way of seeing if we are checked out to a user.
     * @return mixed
     */
    public function checkedOutToUser()
    {
      return $this->assignedType() === self::USER;
    }

    public function assignedTo()
    {
        return $this->morphTo('assigned', 'assigned_type', 'assigned_to');
    }

    public function assignedAssets()
    {
        return $this->morphMany('App\Models\Asset', 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

  /**
   * Get the asset's location based on the assigned user
   **/
    public function assetLoc($iterations = 1,$first_asset = null)
    {
        if (!empty($this->assignedType())) {
            if ($this->assignedType() == self::ASSET) {
                if(!$first_asset) {
                    $first_asset=$this;
                }
                if($iterations>10) {
                    throw new \Exception("Asset assignment Loop for Asset ID: ".$first_asset->id);
                }
                $assigned_to=Asset::find($this->assigned_to); //have to do this this way because otherwise it errors
                if ($assigned_to) {
                    return $assigned_to->assetLoc($iterations + 1, $first_asset);
                } // Recurse until we have a final location
            }
            if ($this->assignedType() == self::LOCATION) {
                if ($this->assignedTo) {
                    return $this->assignedTo;
                }

            }
            if ($this->assignedType() == self::USER) {
                if (($this->assignedTo) && $this->assignedTo->userLoc) {
                    return $this->assignedTo->userLoc;
                }
                //this makes no sense
                return $this->defaultLoc;

            }

        }
        return $this->defaultLoc;
    }

    public function assignedType()
    {
        return strtolower(class_basename($this->assigned_type));
    }
  /**
   * Get the asset's location based on default RTD location
   **/
    public function defaultLoc()
    {
        return $this->belongsTo('\App\Models\Location', 'rtd_location_id');
    }


    public function getImageUrl()
    {
        if ($this->image && !empty($this->image)) {
            return url('/').'/uploads/assets/'.$this->image;
        } elseif ($this->model && !empty($this->model->image)) {
            return url('/').'/uploads/models/'.$this->model->image;
        }
        return false;
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
     * Get checkouts
     */
    public function checkouts()
    {
        return $this->assetlog()->where('action_type', '=', 'checkout')
            ->orderBy('created_at', 'desc')
            ->withTrashed();
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
     * Get user requests
     */
    public function userRequests()
    {
        return $this->assetlog()
            ->where('action_type', '=', 'requested')
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
   * Get total assets not checked out
   */
    public static function availassetcount()
    {
        return Asset::RTD()
                  ->whereNull('deleted_at')
                  ->count();
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
   * Get asset status
   */
    public function assetstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }

    public function model()
    {
        return $this->belongsTo('\App\Models\AssetModel', 'model_id')->withTrashed();
    }

    public static function getExpiringWarrantee($days = 30)
    {
        return Asset::where('archived', '=', '0')
            ->whereNotNull('warranty_months')
            ->whereNotNull('purchase_date')
            ->whereNull('deleted_at')
            ->whereRaw(\DB::raw('DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) <= DATE(NOW() + INTERVAL '
                                 . $days
                                 . ' DAY) AND DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) > NOW()'))
            ->orderBy('purchase_date', 'ASC')
            ->get();
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

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }


    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }



  /**
   * Get auto-increment
   */
    public static function autoincrement_asset()
    {
        $settings = \App\Models\Setting::getSettings();


        if ($settings->auto_increment_assets == '1') {
            $temp_asset_tag = \DB::table('assets')
                ->where('physical', '=', '1')
                ->max('asset_tag');

            $asset_tag_digits = preg_replace('/\D/', '', $temp_asset_tag);
            $asset_tag = preg_replace('/^0*/', '', $asset_tag_digits);

            if ($settings->zerofill_count > 0) {
                return $settings->auto_increment_prefix.Asset::zerofill($settings->next_auto_tag_base, $settings->zerofill_count);
            }
            return $settings->auto_increment_prefix.$settings->next_auto_tag_base;
        } else {
            return false;
        }
    }

    /*
     * Get the next base number for the auto-incrementer. We'll add the zerofill and
     * prefixes on the fly as we generate the number
     *
     */
    public static function nextAutoIncrement($assets)
    {

        $max = 1;

        foreach ($assets as $asset) {
            $results = preg_match ( "/\d+$/" , $asset['asset_tag'], $matches);

            if ($results)
            {
                $number = $matches[0];

                if ($number > $max)
                {
                    $max = $number;
                }
            }
        }
        return $max + 1;

    }




    public static function zerofill($num, $zerofill = 3)
    {
        return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
    }


    public function checkin_email()
    {
        return $this->model->category->checkin_email;
    }

    public function requireAcceptance()
    {
        return $this->model->category->require_acceptance;
    }

    public function getEula()
    {
        $Parsedown = new \Parsedown();

        if ($this->model->category->eula_text) {
            return $Parsedown->text(e($this->model->category->eula_text));
        } elseif ($this->model->category->use_default_eula == '1') {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        } else {
            return false;
        }
    }

    /**
     * Run additional, advanced searches.
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  array  $terms The search terms
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function advancedTextSearch(Builder $query, array $terms) {

      
      /**
       * Assigned user
       */
      $query = $query->leftJoin('users as assets_users',function ($leftJoin) {
            $leftJoin->on("assets_users.id", "=", "assets.assigned_to")
                ->where("assets.assigned_type", "=", User::class);
      });

      foreach($terms as $term) {

        $query = $query
          ->orWhere('assets_users.first_name', 'LIKE', '%'.$term.'%')
          ->orWhere('assets_users.last_name', 'LIKE', '%'.$term.'%')
          ->orWhere('assets_users.username', 'LIKE', '%'.$term.'%')
          ->orWhereRaw('CONCAT('.DB::getTablePrefix().'assets_users.first_name," ",'.DB::getTablePrefix().'assets_users.last_name) LIKE ?', ["%$term%", "%$term%"]);      

      }

      /**
       * Assigned location
       */      
      $query = $query->leftJoin('locations as assets_locations',function ($leftJoin) {
        $leftJoin->on("assets_locations.id","=","assets.assigned_to")
          ->where("assets.assigned_type","=",Location::class);
      });

      foreach($terms as $term) {

        $query = $query->orWhere('assets_locations.name', 'LIKE', '%'.$term.'%');     

      }      

      /**
       * Assigned assets
       */      
      $query = $query->leftJoin('assets as assigned_assets',function ($leftJoin) {
        $leftJoin->on('assigned_assets.id', '=', 'assets.assigned_to')
          ->where('assets.assigned_type', '=', Asset::class);
      });

      foreach($terms as $term) {

        $query = $query->orWhere('assigned_assets.name', 'LIKE', '%'.$term.'%');
                  
      }

      return $query;
    }

  /**
   * -----------------------------------------------
   * BEGIN QUERY SCOPES
   * -----------------------------------------------
   **/

  /**
   * Query builder scope for hardware
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeHardware($query)
    {
        return $query->where('physical', '=', '1');
    }

  /**
   * Query builder scope for pending assets
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopePending($query)
    {
        return $query->whereHas('assetstatus', function ($query) {
            $query->where('deployable', '=', 0)
                ->where('pending', '=', 1)
                ->where('archived', '=', 0);
        });
    }


    /**
    * Query builder scope for searching location
    *
    * @param  \Illuminate\Database\Query\Builder $query Query builder instance
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */

    public function scopeAssetsByLocation($query, $location)
    {
        return $query->where(function ($query) use ($location) {
            $query->whereHas('assignedTo', function ($query) use ($location) {
                $query->where([
                    ['users.location_id', '=', $location->id],
                    ['assets.assigned_type', '=', User::class]
                ])->orWhere([
                    ['locations.id', '=', $location->id],
                    ['assets.assigned_type', '=', Location::class]
                ])->orWhere([
                    ['assets.rtd_location_id', '=', $location->id],
                    ['assets.assigned_type', '=', Asset::class]
                ]);
            })->orWhere(function ($query) use ($location) {
                $query->where('assets.rtd_location_id', '=', $location->id);
                $query->whereNull('assets.assigned_to');
            });
        });
    }


    /**
    * Query builder scope for RTD assets
    *
    * @param  \Illuminate\Database\Query\Builder $query Query builder instance
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */

    public function scopeRTD($query)
    {
        return $query->whereNULL('assets.assigned_to')
                   ->whereHas('assetstatus', function ($query) {
                       $query->where('deployable', '=', 1)
                             ->where('pending', '=', 0)
                             ->where('archived', '=', 0);
                   });
    }

  /**
   * Query builder scope for Undeployable assets
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeUndeployable($query)
    {
        return $query->whereHas('assetstatus', function ($query) {
            $query->where('deployable', '=', 0)
                ->where('pending', '=', 0)
                ->where('archived', '=', 0);
        });
    }

    /**
     * Query builder scope for non-Archived assets
     *
     * @param  \Illuminate\Database\Query\Builder $query Query builder instance
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */

    public function scopeNotArchived($query)
    {
        return $query->whereHas('assetstatus', function ($query) {
            $query->where('archived', '=', 0);
        });
    }

  /**
   * Query builder scope for Archived assets
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeArchived($query)
    {
        return $query->whereHas('assetstatus', function ($query) {
            $query->where('deployable', '=', 0)
                ->where('pending', '=', 0)
                ->where('archived', '=', 1);
        });
    }

  /**
   * Query builder scope for Deployed assets
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeDeployed($query)
    {
        return $query->where('assigned_to', '>', '0');
    }

  /**
   * Query builder scope for Requestable assets
   *
   * @param  \Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return \Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeRequestableAssets($query)
    {
        return Company::scopeCompanyables($query->where('requestable', '=', 1))
        ->whereHas('assetstatus', function ($query) {
            $query->where('deployable', '=', 1)
                 ->where('pending', '=', 0)
                 ->where('archived', '=', 0);
        });
    }


  /**
  * Query builder scope for Deleted assets
  *
  * @param  \Illuminate\Database\Query\Builder $query Query builder instance
  *
  * @return \Illuminate\Database\Query\Builder          Modified query builder
  */

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('assets.deleted_at');
    }

    /**
   * scopeInModelList
   * Get all assets in the provided listing of model ids
   *
   * @param       $query
   * @param array $modelIdListing
   *
   * @return mixed
   * @author  Vincent Sposato <vincent.sposato@gmail.com>
   * @version v1.0
   */
    public function scopeInModelList($query, array $modelIdListing)
    {
        return $query->whereIn('assets.model_id', $modelIdListing);
    }

  /**
  * Query builder scope to get not-yet-accepted assets
  *
  * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return \Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeNotYetAccepted($query)
    {
        return $query->where("accepted", "=", "pending");
    }

  /**
  * Query builder scope to get rejected assets
  *
  * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return \Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeRejected($query)
    {
        return $query->where("accepted", "=", "rejected");
    }


  /**
  * Query builder scope to get accepted assets
  *
  * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return \Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeAccepted($query)
    {
        return $query->where("accepted", "=", "accepted");
    }

    /**
     * Query builder scope to search on text for complex Bootstrap Tables API.
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $search      Search term
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeAssignedSearch($query, $search)
    {
        $search = explode(' OR ', $search);

        return $query->leftJoin('users as assets_users',function ($leftJoin) {
            $leftJoin->on("assets_users.id", "=", "assets.assigned_to")
                ->where("assets.assigned_type", "=", User::class);
        })->leftJoin('locations as assets_locations',function ($leftJoin) {
            $leftJoin->on("assets_locations.id","=","assets.assigned_to")
                ->where("assets.assigned_type","=",Location::class);
        })->leftJoin('assets as assigned_assets',function ($leftJoin) {
            $leftJoin->on('assigned_assets.id', '=', 'assets.assigned_to')
                ->where('assets.assigned_type', '=', Asset::class);
        })->where(function ($query) use ($search) {
            foreach ($search as $search) {
                $query->whereHas('model', function ($query) use ($search) {
                    $query->whereHas('category', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('categories.name', 'LIKE', '%'.$search.'%')
                                ->orWhere('models.name', 'LIKE', '%'.$search.'%')
                                ->orWhere('models.model_number', 'LIKE', '%'.$search.'%');
                        });
                    });
                })->orWhereHas('model', function ($query) use ($search) {
                    $query->whereHas('manufacturer', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('manufacturers.name', 'LIKE', '%'.$search.'%');
                        });
                    });
                })->orWhere(function ($query) use ($search) {
                    $query->where('assets_users.first_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('assets_users.last_name', 'LIKE', '%'.$search.'%')
                        ->orWhereRaw('CONCAT('.DB::getTablePrefix().'assets_users.first_name," ",'.DB::getTablePrefix().'assets_users.last_name) LIKE ?', ["%$search%", "%$search%"])
                        ->orWhere('assets_users.username', 'LIKE', '%'.$search.'%')
                        ->orWhere('assets_locations.name', 'LIKE', '%'.$search.'%')
                        ->orWhere('assigned_assets.name', 'LIKE', '%'.$search.'%');
                })->orWhere('assets.name', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.asset_tag', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.serial', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.order_number', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.notes', 'LIKE', '%'.$search.'%');
            }
            foreach (CustomField::all() as $field) {
                $query->orWhere('assets.'.$field->db_column_name(), 'LIKE', "%$search%");
            }
        })->withTrashed()->whereNull("assets.deleted_at"); //workaround for laravel bug
    }



    /**
     * Query builder scope to search on text filters for complex Bootstrap Tables API
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text   $filter   JSON array of search keys and terms
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeByFilter($query, $filter)
    {
        return $query->where(function ($query) use ($filter) {
            foreach ($filter as $key => $search_val) {

                $fieldname = str_replace('custom_fields.','', $key) ;

                if ($fieldname =='asset_tag') {
                    $query->where('assets.asset_tag', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='name') {
                    $query->where('assets.name', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='product_key') {
                    $query->where('assets.serial', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='purchase_date') {
                    $query->where('assets.purchase_date', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='purchase_cost') {
                    $query->where('assets.purchase_cost', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='notes') {
                    $query->where('assets.notes', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='order_number') {
                    $query->where('assets.order_number', 'LIKE', '%'.$search_val.'%');
                }

                if ($fieldname =='status_label') {
                    $query->whereHas('assetstatus', function ($query) use ($search_val) {
                        $query->where('status_labels.name', 'LIKE', '%' . $search_val . '%');
                    });
                }

                if ($fieldname =='location') {
                    $query->whereHas('location', function ($query) use ($search_val) {
                        $query->where('locations.name', 'LIKE', '%' . $search_val . '%');
                    });
                }

                if ($fieldname =='checkedout_to') {
                    $query->whereHas('assigneduser', function ($query) use ($search_val) {
                        $query->where(function ($query) use ($search_val) {
                            $query->where('users.first_name', 'LIKE', '%' . $search_val . '%')
                                ->orWhere('users.last_name', 'LIKE', '%' . $search_val . '%');
                        });
                    });
                }


                if ($fieldname =='manufacturer') {
                    $query->whereHas('model', function ($query) use ($search_val) {
                        $query->whereHas('manufacturer', function ($query) use ($search_val) {
                            $query->where(function ($query) use ($search_val) {
                                $query->where('manufacturers.name', 'LIKE', '%'.$search_val.'%');
                            });
                        });
                    });
                }

                if ($fieldname =='category') {
                    $query->whereHas('model', function ($query) use ($search_val) {
                        $query->whereHas('category', function ($query) use ($search_val) {
                            $query->where(function ($query) use ($search_val) {
                                $query->where('categories.name', 'LIKE', '%' . $search_val . '%')
                                    ->orWhere('models.name', 'LIKE', '%' . $search_val . '%')
                                    ->orWhere('models.model_number', 'LIKE', '%' . $search_val . '%');
                            });
                        });
                    });
                }

                if ($fieldname =='model') {
                    $query->where(function ($query) use ($search_val) {
                        $query->whereHas('model', function ($query) use ($search_val) {
                            $query->where('models.name', 'LIKE', '%' . $search_val . '%');
                        });
                    });
                }

                if ($fieldname =='model_number') {
                    $query->where(function ($query) use ($search_val) {
                        $query->whereHas('model', function ($query) use ($search_val) {
                            $query->where('models.model_number', 'LIKE', '%' . $search_val . '%');
                        });
                    });
                }


                if ($fieldname =='company') {
                    $query->where(function ($query) use ($search_val) {
                        $query->whereHas('company', function ($query) use ($search_val) {
                            $query->where('companies.name', 'LIKE', '%' . $search_val . '%');
                        });
                    });
                }

                if ($fieldname =='supplier') {
                    $query->where(function ($query) use ($search_val) {
                        $query->whereHas('supplier', function ($query) use ($search_val) {
                            $query->where('suppliers.name', 'LIKE', '%' . $search_val . '%');
                        });
                    });
                }
            }

            if (($fieldname!='category') && ($fieldname!='model_number') && ($fieldname!='location') && ($fieldname!='supplier')
                && ($fieldname!='status_label') && ($fieldname!='model') && ($fieldname!='company') && ($fieldname!='manufacturer')) {
                    $query->orWhere('assets.'.$fieldname, 'LIKE', '%' . $search_val . '%');
            }




        });

    }


    /**
    * Query builder scope to order on model
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModels($query, $order)
    {
        return $query->join('models as asset_models', 'assets.model_id', '=', 'asset_models.id')->orderBy('asset_models.name', $order);
    }

    /**
    * Query builder scope to order on model number
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModelNumber($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')->orderBy('models.model_number', $order);
    }


    /**
    * Query builder scope to order on assigned user
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderAssigned($query, $order)
    {
        return $query->leftJoin('users as users_sort', 'assets.assigned_to', '=', 'users_sort.id')->select('assets.*')->orderBy('users_sort.first_name', $order)->orderBy('users_sort.last_name', $order);
    }

    /**
    * Query builder scope to order on status
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderStatus($query, $order)
    {
        return $query->join('status_labels as status_sort', 'assets.status_id', '=', 'status_sort.id')->orderBy('status_sort.name', $order);
    }

    /**
    * Query builder scope to order on company
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as company_sort', 'assets.company_id', '=', 'company_sort.id')->orderBy('company_sort.name', $order);
    }


    /**
     * Query builder scope to return results of a category
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text $order Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeInCategory($query, $category_id)
    {
        return $query->join('models as category_models', 'assets.model_id', '=', 'category_models.id')
            ->join('categories', 'category_models.category_id', '=', 'categories.id')->where('category_models.category_id', '=', $category_id);
    }

    /**
     * Query builder scope to return results of a manufacturer
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text $order Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeByManufacturer($query, $manufacturer_id)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('manufacturers', 'models.manufacturer_id', '=', 'manufacturers.id')->where('models.manufacturer_id', '=', $manufacturer_id);
    }



    /**
    * Query builder scope to order on category
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order         Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCategory($query, $order)
    {
        return $query->join('models as order_model_category', 'assets.model_id', '=', 'order_model_category.id')
            ->join('categories as category_order', 'order_model_category.category_id', '=', 'category_order.id')
            ->orderBy('category_order.name', $order);
    }


    /**
     * Query builder scope to order on manufacturer
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManufacturer($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('manufacturers', 'models.manufacturer_id', '=', 'manufacturers.id')
            ->orderBy('manufacturers.name', $order);
    }

   /**
    * Query builder scope to order on location
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations as asset_locations', 'asset_locations.id', '=', 'assets.location_id')->orderBy('asset_locations.name', $order);
    }

    /**
     * Query builder scope to order on default
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderRtdLocation($query, $order)
    {
        return $query->leftJoin('locations as rtd_asset_locations', 'rtd_asset_locations.id', '=', 'assets.rtd_location_id')->orderBy('rtd_asset_locations.name', $order);
    }


    /**
     * Query builder scope to order on supplier name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderSupplier($query, $order)
    {
        return $query->leftJoin('suppliers as suppliers_assets', 'assets.supplier_id', '=', 'suppliers_assets.id')->orderBy('suppliers_assets.name', $order);
    }

    /**
     * Query builder scope to search on location ID
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $search      Search term
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeByLocationId($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->whereHas('location', function ($query) use ($search) {
                $query->where('locations.id', '=', $search);
            });
        });

    }


    /**
     * Query builder scope to search on location ID
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $search      Search term
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeByDepreciationId($query, $search)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('depreciations', 'models.depreciation_id', '=', 'depreciations.id')->where('models.depreciation_id', '=', $search);

    }


}
