<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedReport extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'options',
    ];

    public function checkmarkValue($property)
    {
        // Assuming we're using the null object pattern,
        // return the default value if the object is not saved yet.
        if (is_null($this->id)) {
            return '1';
        }

        // Return the property's value if it exists
        // and return the default value if not.
        return $this->options[$property] ?? '0';
    }

    public function textValue($property)
    {
        // Assuming we're using the null object pattern,
        // return the default value if the object is not saved yet.
        if (is_null($this->id)) {
            return '';
        }

        // Return the property's value if it exists
        // and return the default value if not.
        return $this->options[$property] ?? '';
    }
}
