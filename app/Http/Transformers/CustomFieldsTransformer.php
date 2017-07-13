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
            'name' => $field->name,
            'db_column_name' => $field->db_column_name(),
            'format'   =>  $field->format,
            'required'   =>  $field->pivot->required
        ];
        return $array;
    }


}
