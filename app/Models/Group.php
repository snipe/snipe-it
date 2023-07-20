<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Watson\Validating\ValidatingTrait;

class Group extends SnipeModel
{
    use HasFactory;

    protected $table = 'permission_groups';

    public $rules = [
      'name' => 'required|min:2|max:255',
    ];

    protected $fillable = [
        'name',
        'permissions'
    ];

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
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
     * Establishes the groups -> users relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users_groups');
    }

    /**
     * Decode JSON permissions into array
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return array
     */
    public function decodePermissions()
    {
        return json_decode($this->permissions, true);
    }
}
