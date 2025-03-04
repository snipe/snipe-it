<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Models\User;
use App\Presenters\Presentable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

class Location extends SnipeModel
{
    use HasFactory;

    protected $presenter = \App\Presenters\LocationPresenter::class;
    use Presentable;
    use SoftDeletes;

    protected $table = 'locations';
    protected $rules = [
        'name'          => 'required|min:2|max:255|unique_undeleted',
        'address'       => 'max:191|nullable',
        'address2'      => 'max:191|nullable',
        'city'          => 'max:191|nullable',
        'state'         => 'min:2|max:191|nullable',
        'country'       => 'min:2|max:191|nullable',
        'zip'           => 'max:10|nullable',
        'manager_id'    => 'exists:users,id|nullable',
        'parent_id'     => 'nullable|exists:locations,id|non_circular:locations,id',
    ];

    protected $casts = [
        'parent_id'     => 'integer',
        'manager_id'    => 'integer',
    ];

    /**
     * Whether the model should inject its identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
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
        'phone',
        'fax',
        'ldap_ou',
        'currency',
        'manager_id',
        'image',
        'notes',
    ];
    protected $hidden = ['user_id'];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['name', 'address', 'city', 'state', 'zip', 'created_at', 'ldap_ou', 'phone', 'fax', 'notes'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
      'parent' => ['name'],
    ];


    /**
     * Determine whether or not this location can be deleted.
     *
     * This method requires the eager loading of the relationships in order to determine whether
     * it can be deleted. It's tempting to load those here, but that increases the query load considerably.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return bool
     */
    public function isDeletable()
    {

        return Gate::allows('delete', $this)
                && ($this->assets_count == 0)
                && ($this->assigned_assets_count == 0)
                && ($this->children_count == 0)
                && ($this->accessories_count == 0)
                && ($this->users_count == 0);
    }

    /**
     * Establishes the user -> location relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'location_id');
    }

    /**
     * Find assets with this location as their location_id
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->hasMany(\App\Models\Asset::class, 'location_id')
            ->whereHas('assetstatus', function ($query) {
                $query->where('status_labels.deployable', '=', 1)
                        ->orWhere('status_labels.pending', '=', 1)
                        ->orWhere('status_labels.archived', '=', 0);
            });
    }


    /**
     * Establishes the  asset -> rtd_location relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function rtd_assets()
    {
        /* This used to have an ...->orHas() clause that referred to
           assignedAssets, and that was probably incorrect, as well as
           definitely was setting fire to the query-planner. So don't do that.

           It is arguable that we should have a '...->whereNull('assigned_to')
           bit in there, but that isn't always correct either (in the case
           where a user has no location, for example).
        */
        return $this->hasMany(\App\Models\Asset::class, 'rtd_location_id');
    }

    /**
     * Establishes the consumable -> location relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function consumables()
    {
        return $this->hasMany(\App\Models\Consumable::class, 'location_id');
    }

    /**
     * Establishes the component -> location relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function components()
    {
        return $this->hasMany(\App\Models\Component::class, 'location_id');
    }

    /**
     * Establishes the component -> accessory relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accessories()
    {
        return $this->hasMany(\App\Models\Accessory::class, 'location_id');
    }

    /**
     * Find the parent of a location
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id')
            ->with('parent');
    }


    /**
     * Find the manager of a location
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function manager()
    {
        return $this->belongsTo(\App\Models\User::class, 'manager_id');
    }


    /**
     * Find children of a location
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children');
    }

    /**
     * Establishes the asset -> location assignment relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assignedAssets()
    {
        return $this->morphMany(\App\Models\Asset::class, 'assigned', 'assigned_type', 'assigned_to')->withTrashed();
    }

    /**
     * Establishes the accessory -> location assignment relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assignedAccessories()
    {
        return $this->morphMany(\App\Models\AccessoryCheckout::class, 'assigned', 'assigned_type', 'assigned_to');
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
    public static function indenter($locations_with_children, $parent_id = null, $prefix = '')
    {
        $results = [];

        if (! array_key_exists($parent_id, $locations_with_children)) {
            return [];
        }

        foreach ($locations_with_children[$parent_id] as $location) {
            $location->use_text = $prefix.' '.$location->name;
            $location->use_image = ($location->image) ? config('app.url').'/uploads/locations/'.$location->image : null;
            $results[] = $location;
            //now append the children. (if we have any)
            if (array_key_exists($location->id, $locations_with_children)) {
                $results = array_merge($results, self::indenter($locations_with_children, $location->id, $prefix.'--'));
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
}
