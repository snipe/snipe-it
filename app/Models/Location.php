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
        return $this->belongsTo('\App\Models\Location', 'parent_id','id');
    }

    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id');
    }

    public function childLocations()
    {
        return $this->hasMany('\App\Models\Location', 'parent_id');
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

    public static function getLocationHierarchy($locations, $parent_id = null)
    {


        $op = array();

        foreach ($locations as $location) {

            if ($location['parent_id'] == $parent_id) {
                $op[$location['id']] =
                    array(
                        'name' => $location['name'],
                        'parent_id' => $location['parent_id']
                    );

                // Using recursion
                $children =  Location::getLocationHierarchy($locations, $location['id']);
                if ($children) {
                    $op[$location['id']]['children'] = $children;
                }

            }

        }
        return $op;
    }


    public static function flattenLocationsArray($location_options_array = null)
    {
        $location_options = array();
        foreach ($location_options_array as $id => $value) {

            // get the top level key value
            $location_options[$id] = $value['name'];

                // If there is a key named children, it has child locations and we have to walk it
            if (array_key_exists('children', $value)) {

                foreach ($value['children'] as $child_id => $child_location_array) {
                    $child_location_options = Location::flattenLocationsArray($value['children']);

                    foreach ($child_location_options as $child_id => $child_name) {
                        $location_options[$child_id] = '--'.$child_name;
                    }
                }

            }

        }

        return $location_options;
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
