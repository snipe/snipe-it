<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnipeModel extends Model
{
    //
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }
}
