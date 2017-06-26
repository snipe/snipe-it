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
        foreach ($fieldsets as $fieldset) {
            $array[] = self::transformCustomFieldset($fieldset);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCustomFieldset (CustomFieldset $fieldset)
    {
        $fields = $fieldset->fields;
        $models = $fieldset->models;
        $modelsArray = array();
        $totalModels = 0;
        foreach ($models as $model)
        {
            $modelArray = array();
            $modelArray["id"] = $model->id;
            $modelArray["name"] = $model->name;
            $modelsArray[$totalModels] = $modelArray;
            $totalModels = $totalModels + 1;
        }
        $totalFields = $fields->count();
        $array = [
            'id' => $fieldset->id,
            'name' => $fieldset->name,
            'fields' => (new CustomFieldsTransformer)->transformCustomFields($fields, $totalFields),
            'models' => (new DatatablesTransformer)->transformDatatables($modelsArray, $totalModels)
        ];
        return $array;
    }
}
