<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\SnipeModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Location extends SnipeModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'locations';
    protected $rules = array(
      'name'        => 'required|min:3|max:255|unique_undeleted',
      'city'        => 'min:3|max:255',
      'state'           => 'min:0|max:2',
      'country'     => 'min:2|max:2',
      'address'         => 'min:5|max:80',
      'address2'        => 'min:2|max:80',
      'zip'         => 'min:3|max:10',
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
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany('\App\Models\User', 'location_id');
    }

    public function assets()
    {
        return $this->hasManyThrough('\App\Models\Asset', '\App\Models\User', 'location_id', 'assigned_to', 'id');
    }

    public function assignedassets()
    {
        return $this->hasMany('\App\Models\Asset', 'rtd_location_id');
    }

    public function parent()
    {
        return $this->belongsTo('\App\Models\Location', 'parent_id');
    }

    public function childLocations()
    {
        return $this->hasMany('\App\Models\Location', 'parent_id');
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
    * Query builder scope to search on text
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $search      Search term
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeTextsearch($query, $search)
    {

        return $query->where('name', 'LIKE', "%$search%")
          ->orWhere('address', 'LIKE', "%$search%")
          ->orWhere('city', 'LIKE', "%$search%")
          ->orWhere('state', 'LIKE', "%$search%")
          ->orWhere('zip', 'LIKE', "%$search%")

          // This doesn't actually work - need to use a table alias maybe?
          ->orWhere(function ($query) use ($search) {
              $query->whereHas('parent', function ($query) use ($search) {
                  $query->where(function ($query) use ($search) {
                      $query->where('name', 'LIKE', '%'.$search.'%');
                  });
              })
            // Ugly, ugly code because Laravel sucks at self-joins
                ->orWhere(function ($query) use ($search) {
                    $query->whereRaw("parent_id IN (select id from locations where name LIKE '%".$search."%') ");
                });
          });

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
}
