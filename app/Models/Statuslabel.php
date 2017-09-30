<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\SnipeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Statuslabel extends SnipeModel
{
    use SoftDeletes;
    use ValidatingTrait;
    use UniqueUndeletedTrait;

    protected $injectUniqueIdentifier = true;
    protected $dates = ['deleted_at'];
    protected $table = 'status_labels';
    protected $hidden = ['user_id','deleted_at'];


    protected $rules = array(
        'name'  => 'required|string|unique_undeleted',
        'notes'   => 'string|nullable',
        'deployable' => 'required',
        'pending' => 'required',
        'archived' => 'required',
    );

    protected $fillable = ['name', 'deployable', 'pending', 'archived'];

    /**
     * Show count of assets with status label
     *
     * @todo Remove this. It's dumb.
     * @return \Illuminate\Support\Collection
     */
    public function has_assets()
    {
        return $this->hasMany('\App\Models\Asset', 'status_id')->count();
    }

    /**
     * Get assets with associated status label
     *
     * @return \Illuminate\Support\Collection
     */
    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'status_id');
    }

    public function getStatuslabelType()
    {

        if (($this->pending == '1') && ($this->archived == '0')  && ($this->deployable == '0')) {
            return 'pending';
        } elseif (($this->pending == '0') && ($this->archived == '1')  && ($this->deployable == '0')) {
            return 'archived';
        } elseif (($this->pending == '0') && ($this->archived == '0')  && ($this->deployable == '0')) {
            return 'undeployable';
        } else {
            return 'deployable';
        }
    }


    public static function getStatuslabelTypesForDB($type)
    {
        if ($type == 'pending') {
            $statustype['pending'] = 1;
            $statustype['deployable'] = 0;
            $statustype['archived'] = 0;

        } elseif ($type == 'deployable') {
            $statustype['pending'] = 0;
            $statustype['deployable'] = 1;
            $statustype['archived'] = 0;

        } elseif ($type == 'archived') {
            $statustype['pending'] = 0;
            $statustype['deployable'] = 0;
            $statustype['archived'] = 1;
            
        } else {
            $statustype['pending'] = 0;
            $statustype['deployable'] = 0;
            $statustype['archived'] = 0;

        }

        return $statustype;
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
