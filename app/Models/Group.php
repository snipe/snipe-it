<?php
namespace App\Models;

use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
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

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'created_at'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = []; 

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
}
