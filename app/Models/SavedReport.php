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

    // @todo: add $rules

    //we will need a bit to catch and store the name of the report.
    //for now the blip above is creating the name, but can be confusing if multiple are made at once

    public function checkmarkValue(string $property): string
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

    public function radioValue(string $property, $value, $return)
    {
        // @todo: this method feels more like "radioShouldBeChecked" or something...
        // @todo: improve the variable names...

//            if (array_has($this->options, $property) && $this->options[$property] === $value) {
//                return $return;
//            }
        // this is currently throwing an error. $property is coming through as a string and it needs to be an array

        return null;
    }

    public function selectValue(string $property)
    {
        return $this->options[$property] ?? null;
    }

    public function selectValues(string $property)
    {
        if (!isset($this->options[$property])) {
            return null;
        }

        if ($this->options[$property] === [null]) {
            return null;
        }

        return $this->options[$property];
    }

    public function textValue(string $property): string
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
