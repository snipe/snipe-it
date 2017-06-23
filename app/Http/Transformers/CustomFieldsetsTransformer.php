<?php
namespace App\Http\Transformers;

use App\Models\CustomFieldset;
use App\Models\CustomField;
use App\Models\AssetModel;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;
use Gate;

class CustomFieldsetsTransformer
{

    public function transformCustomFieldsets (Collection $fieldsets, $total)
    {
        $array = array();
        foreach ($fields as $field) {
            $array[] = self::transformCustomFieldset($field);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCustomFieldset (CustomFieldset $fieldset)
    {
        $fields = $fieldset->fields;
        $models = $fieldset->models;
        $totalFields = $fields->count();
        $totalModels = $models->count();
        $array = [
            'fields' => (new CustomFieldsTransformer)->transformCustomFields($fields, $totalFields),
            'models' => (new AssetModelsTransformer)->transformAssetModels($models, $totalModels)
        ];
        return $array;
    }
}
