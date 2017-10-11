<?php
namespace App\Models;

use App\Models\SnipeModel;
use Watson\Validating\ValidatingTrait;

class Group extends SnipeModel
{
    protected $table = 'groups';

    public $rules = array(
      'name' => 'required|min:3|max:255',
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
    * Get user groups
    */
    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'users_groups');
    }


    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
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
