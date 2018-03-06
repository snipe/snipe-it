<?php
namespace App\Models;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Manufacturer extends SnipeModel
{
    protected $presenter = 'App\Presenters\ManufacturerPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'manufacturers';

    // Declare the rules for the form validation
    protected $rules = array(
        'name'   => 'required|min:2|max:255|unique:manufacturers,name,NULL,deleted_at',
        'url'   => 'url|nullable',
        'support_url'   => 'url|nullable',
        'support_email'   => 'email|nullable'
    );

    protected $hidden = ['user_id'];

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
    protected $fillable = [
        'name',
        'image',
        'support_email',
        'support_phone',
        'support_url',
        'url',
    ];



    public function has_models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'manufacturer_id')->count();
    }

    public function assets()
    {
        return $this->hasManyThrough('\App\Models\Asset', '\App\Models\AssetModel', 'manufacturer_id', 'model_id');
    }

    public function models()
    {
        return $this->hasMany('\App\Models\AssetModel', 'manufacturer_id');
    }

    public function licenses()
    {
        return $this->hasMany('\App\Models\License', 'manufacturer_id');
    }

    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory', 'manufacturer_id');
    }

    public function consumables()
    {
        return $this->hasMany('\App\Models\Consumable', 'manufacturer_id');
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

        return $query->where(function ($query) use ($search) {
        
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }
}
