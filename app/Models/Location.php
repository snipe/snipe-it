<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Models\User;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use DB;

class Location extends SnipeModel
{
    protected $presenter = 'App\Presenters\LocationPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'locations';
    protected $rules = array(
      'name'        => 'required|min:2|max:255|unique_undeleted',
      'city'        => 'min:2|max:255|nullable',
      'country'     => 'min:2|max:2|nullable',
      'address'         => 'max:80|nullable',
      'address2'        => 'max:80|nullable',
      'zip'         => 'min:3|max:10|nullable',
      'manager_id'  => 'exists:users,id|nullable'
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
    use UniqueUndeletedTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'address',
        'address2',
        'city',
        'state',
        'country',
        'zip',
        'ldap_ou',
        'currency',
        'manager_id',
        'image',
    ];
    protected $hidden = ['user_id'];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'address', 'city', 'state', 'zip', 'created_at'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
      'parent' => ['name']
    ];

    public function users()
    {
        return $this->hasMany('\App\Models\User', 'location_id');
    }

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'location_id')
            ->whereHas('assetstatus', function ($query) {
                    $query->where('status_labels.deployable', '=', 1)
                        ->orWhere('status_labels.pending', '=', 1)
                        ->orWhere('status_labels.archived', '=', 0);
            });
    }

    public function rtd_assets()
    {
        /* This used to have an ...->orHas() clause that referred to
           assignedAssets, and that was probably incorrect, as well as
           definitely was setting fire to the query-planner. So don't do that.

           It is arguable that we should have a '...->whereNull('assigned_to')
           bit in there, but that isn't always correct either (in the case 
           where a user has no location, for example).

           In all likelyhood, we need to denorm an "effective_location" column
           into Assets to make this slightly less miserable.
        */
        return $this->hasMany('\App\Models\Asset', 'rtd_location_id');
    }

    public function parent()
    {
        return $this->belongsTo('\App\Models\Location', 'parent_id','id')
            ->with('parent');
    }

    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id');
    }

    public function children() {
        return $this->hasMany('\App\Models\Location','parent_id')
            ->with('children');
    }

    // I don't think we need this anymore since we de-normed location_id in assets?
    public function assignedAssets()
    {
        return $this->morphMany('App\Models\Asset', 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

    public function setLdapOuAttribute($ldap_ou)
    {
        return $this->attributes['ldap_ou'] = empty($ldap_ou) ? null : $ldap_ou;
    }


    /**
     * Query builder scope to order on parent
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */

    public static function indenter($locations_with_children, $parent_id = null, $prefix = '') {
        $results = Array();

        
        if (!array_key_exists($parent_id, $locations_with_children)) {
            return [];
        }


        foreach ($locations_with_children[$parent_id] as $location) {
            $location->use_text = $prefix.' '.$location->name;
            $location->use_image = ($location->image) ? url('/').'/uploads/locations/'.$location->image : null;
            $results[] = $location;
            //now append the children. (if we have any)
            if (array_key_exists($location->id, $locations_with_children)) {
                $results = array_merge($results, Location::indenter($locations_with_children, $location->id,$prefix.'--'));
            }
        }
        return $results;
    }




    /**
    * Query builder scope to order on parent
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderParent($query, $order)
    {
      // Left join here, or it will only return results with parents
        return $query->leftJoin('locations as parent_loc', 'locations.parent_id', '=', 'parent_loc.id')->orderBy('parent_loc.name', $order);
    }

    /**
     * Query builder scope to order on manager name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManager($query, $order)
    {
        return $query->leftJoin('users as location_user', 'locations.manager_id', '=', 'location_user.id')->orderBy('location_user.first_name', $order)->orderBy('location_user.last_name', $order);
    }

    public function scopeAddDefaultLocation($query)
    {
      return $query->from(DB::raw("(
                        SELECT * from `locations` as full
                        UNION
                        (select '0' AS id, 'Default' AS name, NULL AS city, NULL AS state, NULL AS country, NULL AS created_at, NULL AS updated_at, NULL AS user_id, NULL AS address, NULL AS address2, NULL AS zip, NULL AS deleted_at, NULL AS parent_id, NULL AS currency, NULL AS ldap_ou, NULL AS manager_id, NULL AS image, 1 AS is_stockable)
                        ) as `locations`"));
    }

    public function scopeItemLocations($query, $item_type, $item_id) {
      $query->join('inventory_items_locations', function($join) use ($item_type, $item_id) {
        $join->where('inventory_items_locations.item_type', '=', $item_type);
        $join->where('inventory_items_locations.item_id', '=', $item_id);
        $join->on('inventory_items_locations.stock_location_id', '=', 'locations.id');
      });
      $query->addSelect('inventory_items_locations.item_type');
      $query->addSelect('inventory_items_locations.item_id');
    }

    public function scopeWithQuantityByState($query, $wheres = [], $tableName = null) 
    {
      $sub = (new InventoryCount)->recentQuantitiesByState(['stock_location_id'], $wheres);
      //dd($sub->get());

      $tableName = $this->getTable();
      //dd($tableName);
  
      $query->leftJoin(DB::raw("({$sub->toSql()}) AS ss"), function($join) use ($sub, $tableName) {
            $join->on("ss.stock_location_id", '=', "{$tableName}.id")
                 ->addBinding($sub->getBindings());  
                 // bindings for sub-query WHERE added
      });

      return $query;
    }

    public function scopeWithQuantityByItem($query, $wheres = null, $tableName = null) 
    {
      // determine group based on class?
      $sub = (new InventoryCount)->recentQuantitiesByItem(['stock_location_id'], $wheres);
      //dd($sub->get());

      $tableName = $this->getTable();
      //dd($tableName);
  
      $query->leftJoin(DB::raw("({$sub->toSql()}) AS ss"), function($join) use ($sub, $tableName) {
            $join->on("ss.stock_location_id", '=', "{$tableName}.id")
                 ->addBinding($sub->getBindings());  
                 // bindings for sub-query WHERE added
      });

      return $query;
    }


}
