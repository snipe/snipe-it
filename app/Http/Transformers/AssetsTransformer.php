<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Transformers\UsersTransformer;

class AssetsTransformer
{

    public function transformAssets (Collection $assets, $total)
    {
        $array = array();
        foreach ($assets as $asset) {
            $array[] = self::transformAsset($asset);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAsset (Asset $asset)
    {
        $array = [
            'id' => $asset->id,
            'name' => $asset->name,
            'asset_tag' => $asset->asset_tag,
            'serial' => $asset->serial,
            'model' => ($asset->model) ? ['id' => $asset->model->id,'name'=> $asset->model->name] : '',
            'model_number' => $asset->model_number,
            'status_label' => ($asset->assetstatus) ? $asset->assetstatus : null,
            'last_checkout' => $asset->last_checkout,
            'category' => ($asset->model->category) ? $asset->model->category : null,
            'manufacturer' => ($asset->model->manufacturer) ? $asset->model->manufacturer : null,
            'notes' => $asset->notes,
            'expected_checkin' => $asset->expected_checkin,
            'order_number' => $asset->order_number,
            'company' => ($asset->company) ? $asset->company : null,
            'location' => ($asset->assetLoc) ? $asset->assetLoc : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'assigned_to' => ($asset->assigneduser) ? (new UsersTransformer)->transformUser($asset->assigneduser) : null,
            'created_at' => $asset->created_at,
            'purchase_date' => $asset->purchase_date,
            'purchase_cost' => $asset->purchase_cost,

        ];

        if ($asset->model->fieldset) {

         foreach($asset->model->fieldset->fields as $field) {
             $fields_array = [$field->name => $asset->{$field->convertUnicodeDbSlug()}];
             $array += $fields_array;
             //array_push($array, $fields_array);
         }

        }

        return $array;
    }

    public function transformAssetsDatatable($assets) {
        return (new DatatablesTransformer)->transformDatatables($assets);
    }



}
