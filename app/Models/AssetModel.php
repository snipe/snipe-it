<?php
namespace App\Models;

use App\Models\Requestable;
use App\Models\SnipeModel;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Asset Models. Asset Models contain higher level
 * attributes that are common among the same type of asset.
 *
 * @version    v1.0
 */
class AssetModel extends SnipeModel
{
    use SoftDeletes;
    protected $presenter = 'App\Presenters\AssetModelPresenter';
    use Requestable, Presentable;
    protected $dates = ['deleted_at'];
    protected $table = 'models';
    protected $hidden = ['user_id','deleted_at'];

    // Declare the rules for the model validation
    protected $rules = array(
        'name'          => 'required|min:1|max:255',
        'model_number'      => 'max:255|nullable',
        'category_id'       => 'required|integer|exists:categories,id',
        'manufacturer_id'   => 'required|integer|exists:manufacturers,id',
        'eol'   => 'integer:min:0|max:240|nullable',
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

    public function setEolAttribute($value)
    {
        if ($value == '') {
            $value = 0;
        }

        $this->attributes['eol'] = $value;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','manufacturer_id','category_id','eol', 'user_id', 'fieldset_id', 'model_number', 'notes'];

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'model_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id');
    }

    public function depreciation()
    {
        return $this->belongsTo('\App\Models\Depreciation', 'depreciation_id');
    }

    public function adminuser()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function fieldset()
    {
        return $this->belongsTo('\App\Models\CustomFieldset', 'fieldset_id');
    }

    /**
    * -----------------------------------------------
    * BEGIN QUERY SCOPES
    * -----------------------------------------------
    **/

    /**
    * Query builder scope for Deleted assets
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
     * scopeInCategory
     * Get all models that are in the array of category ids
     *
     * @param       $query
     * @param array $categoryIdListing
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function scopeInCategory($query, array $categoryIdListing)
    {

        return $query->whereIn('category_id', $categoryIdListing);
    }

    /**
     * scopeRequestable
     * Get all models that are requestable by a user.
     *
     * @param       $query
     *
     * @return $query
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @version v3.5
     */
    public function scopeRequestableModels($query)
    {

        return $query->where('requestable', '1');
    }

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

        return $query->where('models.name', 'LIKE', "%$search%")
            ->orWhere('model_number', 'LIKE', "%$search%")
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('depreciation', function ($query) use ($search) {
                    $query->where('depreciations.name', 'LIKE', '%'.$search.'%');
                });
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('category', function ($query) use ($search) {
                    $query->where('categories.name', 'LIKE', '%'.$search.'%');
                });
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('manufacturer', function ($query) use ($search) {
                    $query->where('manufacturers.name', 'LIKE', '%'.$search.'%');
                });
            });

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
        return $query->leftJoin('manufacturers', 'models.manufacturer_id', '=', 'manufacturers.id')->orderBy('manufacturers.name', $order);
    }


}
