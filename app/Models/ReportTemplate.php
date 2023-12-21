<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class ReportTemplate extends Model
{
    use HasFactory;
    use ValidatingTrait;

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

    protected $rules = [
        'name' => 'required|unique:report_templates,name',
        'options' => 'array',
    ];

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

        if (array_has($this->options, $property) && $this->options[$property] === $value) {
            return $return;
        }
        // this is currently throwing an error. $property is coming through as a string and it needs to be an array

        return null;
    }

    public function selectValue(string $property, string $model = null)
    {
        if (!isset($this->options[$property])) {
            return null;
        }

        // If a model is provided then we should ensure we only return
        // the value if the model still exists.
        if ($model) {
            $foundModel = $model::find($this->options[$property]);

            return $foundModel ? $foundModel->id : null;
        }
        return $this->options[$property] ?? null;
    }

    public function selectValues(string $property, string $model = null)
    {
        if (!isset($this->options[$property])) {
            return null;
        }

        // @todo: I think this was added to support the null object pattern
        // @todo: Check if this is still needed and if so, add a test for it.
        if ($this->options[$property] === [null]) {
            return null;
        }

        // If a model is provided then we should ensure we only return
        // the ids of models that exist and are not deleted.
        if ($model) {
            return $model::findMany($this->options[$property])->pluck('id');
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
