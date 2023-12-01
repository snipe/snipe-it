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

    public function checkmarkValue($property): string
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

    public function selectValue($property)
    {
        return $this->options[$property] ?? null;
    }

    public function selectValues($property)
    {
        if (!isset($this->options[$property])) {
            return null;
        }

        if ($this->options[$property] === [null]) {
            return null;
        }

        return $this->options[$property];
    }

    public function textValue($property): string
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
