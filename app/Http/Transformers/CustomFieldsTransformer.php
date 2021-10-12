<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\CustomField;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class CustomFieldsTransformer
{

    public function transformCustomFields (Collection $fields, $total)
    {
        $array = array();
        foreach ($fields as $field) {
            $array[] = self::transformCustomField($field);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    /**
     * Builds up an array of formatted custom fields
     * @param  Collection $fields
     * @param  int     $modelId
     * @param  int     $total
     * @return array
     */
    public function transformCustomFieldsWithDefaultValues (Collection $fields, $modelId, $total)
    {
        $array = [];

        foreach ($fields as $field) {
            $array[] = self::transformCustomFieldWithDefaultValue($field, $modelId);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCustomField (CustomField $field)
    {
        $array = [
            'id' => $field->id,
            'name' => e($field->name),
            'db_column_name' => e($field->db_column_name()),
            'format'   =>  e($field->format),
            'element'   =>  e($field->element),
            'help_text' => e($field->help_text),
            'field_values'   => ($field->field_values) ?  e($field->field_values) : null,
            'field_values_array'   => ($field->field_values) ?  explode("\r\n", e($field->field_values)) : null,
            'type'   =>  e($field->element),
            'show_in_email' => (int) $field->show_in_email,
            'field_encrypted' => (int) $field->field_encrypted,
            'created_at' => Helper::getFormattedDateObject($field->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($field->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', CustomField::class) ? true : false,
            'delete' => true,
        ];

        $array += $permissions_array;

        return $array;
    }

    /**
     * Returns the core data for a field, including the default value it has
     * when attributed to a certain model
     *
     * @param  CustomField $field
     * @param  int      $modelId
     * @return array
     */
    public function transformCustomFieldWithDefaultValue (CustomField $field, $modelId)
    {
        return [
            'id' => $field->id,
            'name' => e($field->name),
            'type'   =>  e($field->element),
            'help_text' => e($field->help_text),
            'db_column' => e($field->db_column),
            'format' => e($field->format),
            'show_in_email' => (int) $field->show_in_email,
            'field_encrypted' => (int) $field->field_encrypted,
            'field_values_array'   => ($field->field_values) ?  explode("\r\n", e($field->field_values)) : null,
            'default_value' => $field->defaultValue($modelId),
        ];
    }
}
