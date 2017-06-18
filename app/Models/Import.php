<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $casts = [
        'header_row' => 'json',
        'first_row' => 'json'
    ];
}
