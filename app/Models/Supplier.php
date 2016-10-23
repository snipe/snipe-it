<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Http\Traits\UniqueUndeletedTrait;

class Supplier extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'suppliers';

    protected $rules = array(
        'name'              => 'required|min:3|max:255|unique_undeleted',
        'address'           => 'min:3|max:255',
        'address2'          => 'min:2|max:255',
        'city'              => 'min:3|max:255',
        'state'             => 'min:0|max:32',
        'country'           => 'min:0|max:2',
        'fax'               => 'min:7|max:20',
        'phone'             => 'min:7|max:20',
        'contact'           => 'min:0|max:255',
        'notes'             => 'min:0|max:255',
        'email'             => 'email|min:5|max:150',
        'zip'               => 'min:0|max:10',
        'url'               => 'min:3|max:250',
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


    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'supplier_id');
    }

    public function asset_maintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'supplier_id');
    }

    public function num_assets()
    {
        return $this->hasMany('\App\Models\Asset', 'supplier_id')->count();
    }

    public function licenses()
    {
        return $this->hasMany('\App\Models\License', 'supplier_id');
    }

    public function num_licenses()
    {
        return $this->hasMany('\App\Models\License', 'supplier_id')->count();
    }

    public function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
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
