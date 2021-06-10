<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $casts = [
        'header_row' => 'array',
        'first_row' => 'array',
        'field_map' => 'json',
    ];
}
