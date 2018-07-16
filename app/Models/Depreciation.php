<?php
namespace App\Models;

use App\Models\Traits\Searchable;
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

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'months'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];


    public function has_models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'depreciation_id')->count();
    }

    public function has_licenses()
    {
        return $this->hasMany('\App\Models\License', 'depreciation_id')->count();
    }     
}
