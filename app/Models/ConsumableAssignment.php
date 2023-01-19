<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableAssignment extends Model
{
    use CompanyableTrait;

    protected $table = 'consumables_users';

    public function consumable()
    {
        return $this->belongsTo(\App\Models\Consumable::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
