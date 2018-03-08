<?php
namespace App\Http\Transformers;

use App\Models\CustomField;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;
use Gate;

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

    public function transformCustomField (CustomField $field)
    {

        $array = [
            'id' => $field->id,
            'name' => e($field->name),
            'db_column_name' => e($field->db_column_name()),
            'format'   =>  e($field->format),
            'field_values'   => ($field->field_values) ?  e($field->field_values) : null,
            'required'   =>  $field->pivot ? $field->pivot->required : false,
            'created_at' => Helper::getFormattedDateObject($field->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($field->updated_at, 'datetime'),
        ];
        return $array;
    }


}
