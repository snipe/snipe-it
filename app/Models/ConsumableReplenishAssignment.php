<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableReplenishAssignment extends Model
{
    use CompanyableTrait;

    protected $table = 'consumables_replenishments';

    public function consumable()
    {
        return $this->belongsTo(\App\Models\Consumable::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
