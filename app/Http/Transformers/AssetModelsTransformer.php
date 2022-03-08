<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\AssetModel;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AssetModelsTransformer
{
    public function transformAssetModels(Collection $assetmodels, $total)
    {
        $array = [];
        foreach ($assetmodels as $assetmodel) {
            $array[] = self::transformAssetModel($assetmodel);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssetModel(AssetModel $assetmodel)
    {
        $array = [
            'id' => (int) $assetmodel->id,
            'name' => e($assetmodel->name),
            'manufacturer' => ($assetmodel->manufacturer) ? [
                'id' => (int) $assetmodel->manufacturer->id,
                'name'=> e($assetmodel->manufacturer->name),
            ] : null,
            'image' => ($assetmodel->image != '') ? Storage::disk('public')->url('models/'.e($assetmodel->image)) : null,
            'model_number' => e($assetmodel->model_number),
            'depreciation' => ($assetmodel->depreciation) ? [
                'id' => (int) $assetmodel->depreciation->id,
                'name'=> e($assetmodel->depreciation->name),
            ] : null,
            'assets_count' => (int) $assetmodel->assets_count,
            'category' => ($assetmodel->category) ? [
                'id' => (int) $assetmodel->category->id,
                'name'=> e($assetmodel->category->name),
            ] : null,
            'fieldset' => ($assetmodel->fieldset) ? [
                'id' => (int) $assetmodel->fieldset->id,
                'name'=> e($assetmodel->fieldset->name),
            ] : null,
            'eol' => ($assetmodel->eol > 0) ? $assetmodel->eol.' months' : 'None',
            'requestable' => ($assetmodel->requestable == '1') ? true : false,
            'notes' => e($assetmodel->notes),
            'created_at' => Helper::getFormattedDateObject($assetmodel->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($assetmodel->updated_at, 'datetime'),
            'deleted_at' => Helper::getFormattedDateObject($assetmodel->deleted_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'update' => (Gate::allows('update', AssetModel::class) && ($assetmodel->deleted_at == '')),
            'delete' => (Gate::allows('delete', AssetModel::class) && ($assetmodel->assets_count == 0)),
            'clone' => (Gate::allows('create', AssetModel::class) && ($assetmodel->deleted_at == '')),
            'restore' => (Gate::allows('create', AssetModel::class) && ($assetmodel->deleted_at != '')),
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetModelsDatatable($assetmodels)
    {
        return (new DatatablesTransformer)->transformDatatables($assetmodels);
    }
}
