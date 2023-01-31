<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Components.
 *
 * @version    v1.0
 */
class Component extends SnipeModel
{
    use HasFactory;

    protected $presenter = \App\Presenters\ComponentPresenter::class;
    use CompanyableTrait;
    use Loggable, Presentable;
    use SoftDeletes;
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
    protected $table = 'components';

    /**
     * Category validation rules
     */
    public $rules = [
        'name'           => 'required|min:3|max:255',
        'qty'            => 'required|integer|min:1',
        'category_id'    => 'required|integer|exists:categories,id',
        'company_id'     => 'integer|nullable',
        'min_amt'        => 'integer|min:0|nullable',
        'purchase_date'  => 'date|nullable',
        'purchase_cost'  => 'numeric|nullable|gte:0',
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
        'purchase_cost',
        'purchase_date',
        'min_amt',
        'order_number',
        'qty',
        'serial',
        'notes',
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['name', 'order_number', 'serial', 'purchase_cost', 'purchase_date', 'notes'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'category'     => ['name'],
        'company'      => ['name'],
        'location'     => ['name'],
    ];


    /**
     * Establishes the components -> action logs -> uploads relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v6.1.13]
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
     * Establishes the component -> location relationship
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
     * Establishes the component -> assets relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->belongsToMany(\App\Models\Asset::class, 'components_assets')->withPivot('id', 'assigned_qty', 'created_at', 'user_id', 'note');
    }

    /**
     * Establishes the component -> admin user relationship
     *
     * @todo this is probably not needed - refactor
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Establishes the component -> company relationship
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
     * Establishes the component -> category relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * Establishes the component -> action logs relationship
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
     * Check how many items within a component are checked out
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0]
     * @return int
     */
    public function numCheckedOut()
    {
        $checkedout = 0;
        foreach ($this->assets as $checkout) {
            $checkedout += $checkout->pivot->assigned_qty;
        }

        return $checkedout;
    }

    /**
     * Check how many items within a component are remaining
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return int
     */
    public function numRemaining()
    {
        return $this->qty - $this->numCheckedOut();
    }

    /**
     * Query builder scope to order on company
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCategory($query, $order)
    {
        return $query->join('categories', 'components.category_id', '=', 'categories.id')->orderBy('categories.name', $order);
    }

    /**
     * Query builder scope to order on company
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations', 'components.location_id', '=', 'locations.id')->orderBy('locations.name', $order);
    }

    /**
     * Query builder scope to order on company
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies', 'components.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
    }
}
