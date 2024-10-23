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

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'name',
        'options',
        'user_id',
    ];

    protected $rules = [
        // @todo: this should probably be unique for each user so people don't get errors trying to use a name someone else already used...
        // @todo: but enabling shared reports in the future would mean we would have name collisions then...
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

    /**
     * Establishes the report template -> creator relationship.
     *
     * @since [v6.2.4]
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the value of a checkbox field for the given field name.
     *
     * @param string $fieldName
     * @param string $fallbackValue The value to return if the report template is not saved yet.
     *
     * @since [v6.2.4]
     */
    public function checkmarkValue(string $fieldName, string $fallbackValue = '1'): string
    {
        // Assuming we're using the null object pattern, and an empty model
        // was passed to the view when showing the default report page,
        // return the fallback value so that checkboxes are checked by default.
        if (is_null($this->id)) {
            return $fallbackValue;
        }

        // Return the field's value if it exists and return 0
        // if not so that checkboxes are unchecked by default.
        return $this->options[$fieldName] ?? '0';
    }

    /**
     * Get the value of a radio field for the given field name.
     *
     * @param string $fieldName
     * @param string $value The value to check against.
     * @param bool $isDefault Whether the radio input being checked is the default.
     *
     * @since [v6.2.4]
     */
    public function radioValue(string $fieldName, string $value, bool $isDefault = false): bool
    {
        $fieldExists = array_has($this->options, $fieldName);

        // If the field doesn't exist but the radio input
        // being checked is the default then return true.
        if (!$fieldExists && $isDefault) {
            return true;
        }

        // If the field exists and matches what we're checking then return true.
        if ($fieldExists && $this->options[$fieldName] === $value) {
            return true;
        }

        // Otherwise return false.
        return false;
    }

    /**
     * Get the value of a select field for the given field name.
     *
     * @param string $fieldName
     * @param string|null $model The Eloquent model to check against.
     *
     * @return mixed|null
     *
     * @since [v6.2.4]
     */
    public function selectValue(string $fieldName, string $model = null)
    {
        // If the field does not exist then return null.
        if (!isset($this->options[$fieldName])) {
            return null;
        }

        $value = $this->options[$fieldName];

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

    /**
     * Get the values of a multi-select field for the given field name.
     *
     * @param string $fieldName
     * @param string|null $model The Eloquent model to check against.
     *
     * @return iterable
     *
     * @since [v6.2.4]
     */
    public function selectValues(string $fieldName, string $model = null): iterable
    {
        // If the field does not exist then return an empty array.
        if (!isset($this->options[$fieldName])) {
            return [];
        }

        // If a model is provided then we should ensure we only return
        // the ids of models that exist and are not deleted.
        if ($model) {
            return $model::findMany($this->options[$fieldName])->pluck('id');
        }

        // Wrap the value in an array if needed. This is to ensure
        // values previously stored as a single value,
        // most likely from a single select, are returned as an array.
        if (!is_array($this->options[$fieldName])) {
            return [$this->options[$fieldName]];
        }

        return $this->options[$fieldName];
    }

    /**
     * Get the value of a text field for the given field name.
     *
     * @param string $fieldName
     *
     * @return string
     *
     * @since [v6.2.4]
     */
    public function textValue(string $fieldName): string
    {
        // Assuming we're using the null object pattern,
        // return the default value if the object is not saved yet.
        if (is_null($this->id)) {
            return '';
        }

        // Return the field's value if it exists
        // and return the default value if not.
        return $this->options[$fieldName] ?? '';
    }
}
