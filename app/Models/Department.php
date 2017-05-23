<?php

namespace App;

use App\Http\Traits\UniqueUndeletedTrait;
use Illuminate\Database\Eloquent\Model;
use Log;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SnipeModel;
use App\Models\User;

class Department extends SnipeModel
{
    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;

    use ValidatingTrait, UniqueUndeletedTrait;

    protected $rules = [
        'name'            => 'max:255',
        'user_id'        => 'required',
        'location_id'        => 'numeric',
        'company_id'        => 'numeric',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'location_id',
        'company_id',
        'manager_id',
        'notes',
    ];


    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    /**
     * Even though we allow allow for checkout to things beyond users
     * this method is an easy way of seeing if we are checked out to a user.
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany('\App\Models\User', 'department_id');
    }

}
