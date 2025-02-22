<?php

namespace App\Models;

use App\Models\Traits\Companyable;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class ConsumableAssignment extends Model
{
    use Companyable;
    use ValidatingTrait;

    protected $table = 'consumables_users';

    public $rules = [
        'assigned_to'        => 'required|exists:users,id',
    ];

    public function consumable()
    {
        return $this->belongsTo(\App\Models\Consumable::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function adminuser()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
