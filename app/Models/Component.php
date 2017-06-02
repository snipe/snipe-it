<?php
namespace App\Models;

use App\Models\ActionLog;
// use App\Models\Category;
use App\Models\Company;
use App\Models\ConsumableAssignment;
use App\Models\Location;
use App\Models\Loggable;
use App\Models\SnipeModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Components.
 *
 * @version    v1.0
 */
class Component extends SnipeModel
{
    use CompanyableTrait;
    use Loggable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'components';


    /**
    * Category validation rules
    */
    public $rules = array(
        'name'                 => 'required|min:3|max:255',
		'component_tag'        => 'required|min:1|max:255', // |unique_undeleted'
		'model_id'             => 'required|integer',
        'qty'                  => 'required|integer|min:1',
        //'category_id'          => 'required|integer',
        'company_id'           => 'integer',
        'purchase_date'        => 'date',
        'purchase_cost'        => 'numeric',
		'supplier_id'          => 'integer',
		//'status_id'            => 'integer',
    );

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','company_id','model_id','component_tag','qty'/*'status_id','category_id'*/];

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function assets()
    {
        return $this->belongsToMany('\App\Models\Asset', 'components_assets')->withPivot('assigned_qty', 'created_at', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    // public function category()
    // {
    //    return $this->belongsTo('\App\Models\Category', 'category_id');
    // }

    /**
    * Get action logs for this consumable
    */
    public function componentlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
					->where('item_type', Component::class)
					->orderBy('created_at', 'desc')->withTrashed();
    }


    public function numRemaining()
    {
        $checkedout = 0;

        foreach ($this->assets as $checkout) {
            $checkedout += $checkout->pivot->assigned_qty;
        }


        $total = $this->qty;
        $remaining = $total - $checkedout;
        return $remaining;
    }

    public function showComponentName()
    {

        if ($this->name == '') {
            if ($this->model) {
                return $this->model->name.' ('.$this->component_tag.')';
            }
            return $this->component_tag;
        } else {
            return $this->name;
        }
    }
	
    public function warrantee_expires()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->warranty_months . ' months'));
        return date_format($date, 'Y-m-d');
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
	
    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }
	
    public function months_until_eol()
    {

        $today = date("Y-m-d");
        $d1    = new DateTime($today);
        $d2    = new DateTime($this->eol_date());

        if ($this->eol_date() > $today) {
            $interval = $d2->diff($d1);
        } else {
            $interval = null;
        }

        return $interval;
    }

    public function eol_date()
    {

        if (( $this->purchase_date ) && ( $this->model )) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->eol . ' months'));
            return date_format($date, 'Y-m-d');
        }

    }
	
  /**
   * Get auto-increment
   */
    public static function autoincrement_component()
    {

        $settings = \App\Models\Setting::getSettings();

        if ($settings->auto_increment_components == '1') {
            $temp_component_tag = \DB::table('components')
                // ->where('physical', '=', '1')
                ->max('component_tag');

            $component_tag_digits = preg_replace('/\D/', '', $temp_component_tag);
            $component_tag = preg_replace('/^0*/', '', $component_tag_digits);

            if ($settings->zerofill_count > 0) {
                return $settings->auto_increment_components_prefix.Component::zerofill(($component_tag + 1),$settings->zerofill_count);
            }
            return $settings->auto_increment_components_prefix.($component_tag + 1);
        } else {
            return false;
        }
    }


    public static function zerofill ($num, $zerofill = 3)
    {
        return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
    }
	
	
	/**
	* Get component status
	*/
	/*
    public function componentstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }	
	*/
	
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
        return $query->whereIn('model_id', $modelIdListing);
    }	
	
	
    /**
    * Query builder scope to search on text
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $search      Search term
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
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
        $search = explode(' OR ', $search);

        return $query->where(function ($query) use ($search) {

            foreach ($search as $search) {
				$query->whereHas('model', function ($query) use ($search) {
					$query->whereHas('category', function ($query) use ($search) {
						$query->where(function ($query) use ($search) {
							$query->where('categories.name', 'LIKE', '%'.$search.'%')
							->orWhere('models.name', 'LIKE', '%'.$search.'%')
							->orWhere('models.model_number', 'LIKE', '%'.$search.'%');
						});
					});
				})
				->orWhereHas('model', function ($query) use ($search) {
					$query->whereHas('manufacturer', function ($query) use ($search) {
						$query->where(function ($query) use ($search) {
							$query->where('manufacturers.name', 'LIKE', '%'.$search.'%');
						});
					});	
				})
				->orWhere(function ($query) use ($search) {
                    $query->whereHas('company', function ($query) use ($search) {
                        $query->where('companies.name', 'LIKE', '%'.$search.'%');
                    });
                })
				->orWhere(function ($query) use ($search) {
					$query->whereHas('location', function ($query) use ($search) {
						$query->where('locations.name', 'LIKE', '%'.$search.'%');
					});
				})
				->orWhere('components.name', 'LIKE', '%'.$search.'%')
				->orWhere('components.component_tag', 'LIKE', '%'.$search.'%')
				->orWhere('components.serial', 'LIKE', '%'.$search.'%')
				->orWhere('components.order_number', 'LIKE', '%'.$search.'%')
				->orWhere('components.notes', 'LIKE', '%'.$search.'%');
            }
        });
    }

    /**
    * Query builder scope to order on model
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModels($query, $order)
    {
        return $query->join('models', 'components.model_id', '=', 'models.id')
					->orderBy('models.name', $order);
    }
    /**
    * Query builder scope to order on model number
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModelNumber($query, $order)
    {
        return $query->join('models', 'components.model_id', '=', 'models.id')
					->orderBy('models.model_number', $order);
    }	
	
    /**
    * Query builder scope to order on assigned user
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
/*
    public function scopeOrderAssigned($query, $order)
    {
        return $query->leftJoin('users', 'components.assigned_to', '=', 'users.id')
					->select('assets.*')->orderBy('users.first_name', $order)->orderBy('users.last_name', $order);
    }	
*/
	
    /**
    * Query builder scope to order on status
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
	/*
    public function scopeOrderStatus($query, $order)
    {
        return $query->join('status_labels', 'components.status_id', '=', 'status_labels.id')
					->orderBy('status_labels.name', $order);
    }
	*/
	
    /**
    * Query builder scope to order on company
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies', 'components.company_id', '=', 'companies.id')
					->orderBy('companies.name', $order);
    }
	
	/**
	* Query builder scope to order on category
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @param  text                              $order         Order
	*
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/
    public function scopeOrderCategory($query, $order)
    {
        return $query->join('models', 'components.model_id', '=', 'models.id')
            ->join('categories', 'models.category_id', '=', 'categories.id')
            ->orderBy('categories.name', $order);
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
        return $query->join('models', 'components.model_id', '=', 'models.id')
					->join('manufacturers', 'models.manufacturer_id', '=', 'manufacturers.id')
					->orderBy('manufacturers.name', $order);
    }

    /**
    * Query builder scope to order on company
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations', 'components.location_id', '=', 'locations.id')
					->orderBy('locations.name', $order);
    }



}
