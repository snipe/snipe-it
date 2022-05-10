<?php

namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Accessories.
 *
 * @version    v1.0
 */
class Accessory extends SnipeModel
{
    use HasFactory;

    protected $presenter = \App\Presenters\AccessoryPresenter::class;
    use CompanyableTrait;
    use Loggable, Presentable;
    use SoftDeletes;

    protected $table = 'accessories';
    protected $casts = [
        'purchase_date' => 'datetime',
        'requestable' => 'boolean',    ];

    use Searchable;
    use Acceptable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'model_number', 'order_number', 'purchase_date', 'notes'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
        'category'     => ['name'],
        'company'      => ['name'],
        'manufacturer' => ['name'],
        'supplier'     => ['name'],
        'location'     => ['name'],
    ];

    /**
    * Accessory validation rules
    */
    public $rules = [
        'name'              => 'required|min:3|max:255',
        'qty'               => 'required|integer|min:1',
        'category_id'       => 'required|integer|exists:categories,id',
        'company_id'        => 'integer|nullable',
        'min_amt'           => 'integer|min:0|nullable',
        'purchase_cost'     => 'numeric|nullable|gte:0',
    ];


    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
     * @var bool
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'company_id',
        'location_id',
        'name',
        'order_number',
        'purchase_cost',
        'purchase_date',
        'model_number',
        'manufacturer_id',
        'supplier_id',
        'image',
        'qty',
        'min_amt',
        'requestable',
        'notes',
    ];



    /**
     * Establishes the accessory -> supplier relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }


    /**
     * Sets the requestable attribute on the accessory
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return void
     */
    public function setRequestableAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['requestable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Establishes the accessory -> company relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * Establishes the accessory -> location relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    /**
     * Establishes the accessory -> category relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id')->where('category_type', '=', 'accessory');
    }

    /**
     * Returns the action logs associated with the accessory
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetlog()
    {
        return $this->hasMany(\App\Models\Actionlog::class, 'item_id')->where('item_type', self::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    /**
     * Get the LAST checkout for this accessory.
     * 
     * This is kinda gross, but is necessary for how the accessory
     * pivot stuff works for now.
     *
     * It looks like we should be able to use ->first() here and
     * return an object instead of a collection, but we actually
     * cannot.
     *
     * In short, you cannot execute the query defined when you're eager loading.
     * and in order to avoid 1001 query problems when displaying the most
     * recent checkout note, we have to eager load this.
     *
     * This means we technically return a collection of one here, and then
     * in the controller, we convert that collection to an array, so we can
     * use it in the transformer to display only the notes of the LAST
     * checkout.
     *
     * It's super-mega-assy, but it's the best I could do for now.
     *
     * @author  A. Gianotto <snipe@snipe.net>
     * @since v5.0.0
     *
     * @see \App\Http\Controllers\Api\AccessoriesController\checkedout()
     */
    public function lastCheckout()
    {
        return $this->assetlog()->where('action_type', '=', 'checkout')->take(1);
    }


    /**
     * Sets the full image url
     *
     * @todo this should probably be moved out of the model and into a
     * presenter or service provider
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return string
     */
    public function getImageUrl()
    {
        if ($this->image) {
            return Storage::disk('public')->url(app('accessories_upload_path').$this->image);
        }
        return false;

    }

    /**
     * Establishes the accessory -> users relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'accessories_users', 'accessory_id', 'assigned_to')->withPivot('id', 'created_at', 'note')->withTrashed();
    }

    /**
     * Checks whether or not the accessory has users
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return int
     */
    public function hasUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'accessories_users', 'accessory_id', 'assigned_to')->count();
    }

    /**
     * Establishes the accessory -> manufacturer relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function manufacturer()
    {
        return $this->belongsTo(\App\Models\Manufacturer::class, 'manufacturer_id');
    }

    /**
     * Determins whether or not an email should be sent for checkin/checkout of this
     * accessory based on the category it belongs to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return bool
     */
    public function checkin_email()
    {
        return $this->category->checkin_email;
    }

    /**
     * Determines whether or not the accessory should require the user to
     * accept it via email.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
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
     * @since [v3.0]
     * @return string
     */
    public function getEula()
    {
        $Parsedown = new \Parsedown();

        if ($this->category->eula_text) {
            return $Parsedown->text(e($this->category->eula_text));
        } elseif ((Setting::getSettings()->default_eula_text) && ($this->category->use_default_eula == '1')) {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        }

            return null;
    }

    /**
     * Check how many items of an accessory remain
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return int
     */
    public function numRemaining()
    {
        $checkedout = $this->users->count();
        $total = $this->qty;
        $remaining = $total - $checkedout;

        return $remaining;
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
        return $query->leftJoin('companies', 'accessories.company_id', '=', 'companies.id')
        ->orderBy('companies.name', $order);
    }

    /**
    * Query builder scope to order on category
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCategory($query, $order)
    {
        return $query->leftJoin('categories', 'accessories.category_id', '=', 'categories.id')
        ->orderBy('categories.name', $order);
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
        return $query->leftJoin('locations', 'accessories.location_id', '=', 'locations.id')
        ->orderBy('locations.name', $order);
    }

    /**
    * Query builder scope to order on manufacturer
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderManufacturer($query, $order)
    {
        return $query->leftJoin('manufacturers', 'accessories.manufacturer_id', '=', 'manufacturers.id')->orderBy('manufacturers.name', $order);
    }

    /**
    * Query builder scope to order on supplier
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderSupplier($query, $order)
    {
        return $query->leftJoin('suppliers', 'accessories.supplier_id', '=', 'suppliers.id')->orderBy('suppliers.name', $order);
    }
}
