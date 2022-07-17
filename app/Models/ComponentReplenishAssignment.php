<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentReplenishAssignment extends Model
{
    use CompanyableTrait;

    protected $table = 'components_stock';

    public function component()
    {
        return $this->belongsTo(\App\Models\Component::class);
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