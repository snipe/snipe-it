<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\CustomFieldset;
use Illuminate\Database\Eloquent\Collection;

class CustomFieldsetsTransformer
{
    public function transformCustomFieldsets(Collection $fieldsets, $total)
    {
        $array = [];
        foreach ($fieldsets as $fieldset) {
            $array[] = self::transformCustomFieldset($fieldset);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCustomFieldset(CustomFieldset $fieldset)
    {
        $fields = $fieldset->fields;
        $models = $fieldset->models; //FIXME - not models anymore!
        $modelsArray = [];

        /********************************
         * FIXME here too - this is actually broken. Normally, this looks like (taken from demo):
         *
         * "models": {
         * "total": 10,
         * "rows": [
         * {
         * "id": 1,
         * "name": "Macbook Pro 13&quot;"
         * },
         * {
         * "id": 2,
         * "name": "Macbook Air"
         * },
         * {
         * "id": 3,
         * "name": "Surface"
         * },
         * {
         * "id": 4,
         * "name": "XPS 13"
         * },
         * {
         * "id": 5,
         * "name": "Spectre"
         * },
         * {
         * "id": 6,
         * "name": "ZenBook UX310"
         * },
         * {
         * "id": 7,
         * "name": "Yoga 910"
         * },
         * {
         * "id": 8,
         * "name": "iMac Pro"
         * },
         * {
         * "id": 9,
         * "name": "Lenovo Intel Core i5"
         * },
         * {
         * "id": 10,
         * "name": "OptiPlex"
         * }
         * ]
         * },
         *
         *
         * So we either have to change the SHAPE of the CustomFields API (I mean, I guess we could do that?)
         *
         * Or we have to keep calling it 'models'?
         *
         * Or maybe we keep 'models' in as legacy, and return a new thing for custommizable() ?
         *
         *************************************/

//        foreach ($models as $model) {
//            $modelsArray[] = [
//              'id' => $model->id,
//              'name' => e($model->name),
//            ];
//        }

        $array = [
            'id' => (int) $fieldset->id,
            'name' => e($fieldset->name),
            'fields' => (new CustomFieldsTransformer)->transformCustomFields($fields, $fieldset->fields_count),
            'models' => (new DatatablesTransformer)->transformDatatables($modelsArray, count($fieldset->customizable())), //I don't even understand where this is getting created, but FIXME as it's not strictly just models anymore
            'created_at' => Helper::getFormattedDateObject($fieldset->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($fieldset->updated_at, 'datetime'),
        ];

        return $array;
    }
}
