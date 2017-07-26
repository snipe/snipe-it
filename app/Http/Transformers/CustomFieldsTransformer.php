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
            'name' => e($field->name),
            'db_column_name' => e($field->db_column_name()),
            'format'   =>  e($field->format),
            'required'   =>  $field->pivot->required
        ];
        return $array;
    }


}
