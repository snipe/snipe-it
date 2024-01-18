<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected static function booted()
    {
        // Scope to current user
        static::addGlobalScope('current_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

    public function radioValue(string $property, string $value, bool $isDefault = false): bool
    {
        $propertyExists = array_has($this->options, $property);

        // If the property doesn't exist but the radio input
        // being checked is the default then return true.
        if (!$propertyExists && $isDefault) {
            return true;
        }

        // If the property exists and matches what we're checking then return true.
        if ($propertyExists && $this->options[$property] === $value) {
            return true;
        }

        // Otherwise return false.
        return false;
    }

    public function selectValue(string $property, string $model = null)
    {
        // If the property does not exist then return null.
        if (!isset($this->options[$property])) {
            return null;
        }

        $value = $this->options[$property];

        // If the value was stored as an array, most likely
        // due to a previously being a multi-select,
        // then return the first value.
        if (is_array($value)) {
            $value = $value[0];
        }

        // If a model is provided then we should ensure we only return
        // the value if the model still exists.
        // Note: It is possible $value is an id that no longer exists and this will return null.
        if ($model) {
            $foundModel = $model::find($value);

            return $foundModel ? $foundModel->id : null;
        }

        return $value;
    }

    public function selectValues(string $property, string $model = null): iterable
    {
        // If the property does not exist then return an empty array.
        if (!isset($this->options[$property])) {
            return [];
        }

        // If a model is provided then we should ensure we only return
        // the ids of models that exist and are not deleted.
        if ($model) {
            return $model::findMany($this->options[$property])->pluck('id');
        }

        // Wrap the value in an array if needed. This is to ensure
        // values previously stored as a single value,
        // most likely from a single select, are returned as an array.
        if (!is_array($this->options[$property])) {
            return [$this->options[$property]];
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
