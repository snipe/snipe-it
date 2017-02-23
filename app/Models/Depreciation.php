<?php
namespace App\Models;

use App\Presenters\Presentable;
use Watson\Validating\ValidatingTrait;

class Depreciation extends SnipeModel
{
    protected $presenter = 'App\Presenters\DepreciationPresenter';
    use Presentable;
    // Declare the rules for the form validation
    protected $rules = array(
        'name' => 'required|min:3|max:255|unique:depreciations,name',
        'months' => 'required|max:3600|integer',
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
    protected $fillable = ['name','months'];



    public function has_models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'depreciation_id')->count();
    }

    public function has_licenses()
    {
        return $this->hasMany('\App\Models\License', 'depreciation_id')->count();
    }

      /**
      * Query builder scope to search on text
      *
      * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
      * @param  text                              $search      Search term
      *
      * @return \Illuminate\Database\Query\Builder          Modified query builder
      */
    public function scopeTextSearch($query, $search)
    {

        return $query->where(function ($query) use ($search) {

             $query->where('name', 'LIKE', '%'.$search.'%')
             ->orWhere('months', 'LIKE', '%'.$search.'%');
        });
    }
}
