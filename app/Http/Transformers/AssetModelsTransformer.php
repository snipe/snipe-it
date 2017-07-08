<?php
namespace App\Http\Transformers;

use App\Models\AssetModel;
use Illuminate\Database\Eloquent\Collection;
use Gate;

class AssetModelsTransformer
{

    public function transformAssetModels (Collection $assetmodels, $total)
    {
        $array = array();
        foreach ($assetmodels as $assetmodel) {
            $array[] = self::transformAssetModel($assetmodel);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssetModel (AssetModel $assetmodel)
    {

        $array = [
            'id' => $assetmodel->id,
            'name' => e($assetmodel->name),
            'manufacturer' => ($assetmodel->manufacturer_id) ? $assetmodel->manufacturer : null,
            'image' => ($assetmodel->image!='') ? url('/').'/uploads/models/'.e($assetmodel->image) : '',
            'model_number' => e($assetmodel->model_number),
            'depreciation' => ($assetmodel->depreciation) ? $assetmodel->depreciation : 'No',
            'assets_count' => $assetmodel->assets_count,
            'category' => ($assetmodel->category_id) ? $assetmodel->category : null,
            'fieldset' => ($assetmodel->fieldset) ? $assetmodel->fieldset : null,
            'eol' => ($assetmodel->eol > 0) ? $assetmodel->eol .' months': 'None',
            'notes' => e($assetmodel->notes)

        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', AssetModel::class) ? true : false,
            'delete' => Gate::allows('delete', AssetModel::class) ? true : false,
            'clone' => Gate::allows('create', AssetModel::class) ? true : false,
        ];

        $array += $permissions_array;
        return $array;
    }


    public function transformAssetModelsDatatable($assetmodels) {
        return (new DatatablesTransformer)->transformDatatables($assetmodels);
    }


}
