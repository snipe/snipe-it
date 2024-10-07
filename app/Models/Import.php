<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $casts = [
        'header_row' => 'array',
        'first_row' => 'array',
        'field_map' => 'json',
    ];

    protected function delimiter(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value == 'semicolon') {
                    return ';';
                }
                if ($value == 'pipe') {
                    return '|';
                }

                return ',';

            },

            get: function ($value) {
                if ($value == 'semicolon') {
                    return ';';
                }
                if ($value == 'pipe') {
                    return '|';
                }

                return ',';

            }

        );


    }
}
