<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;

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
            'model' => ($asset->model) ? $asset->model->name : '',
            'model_number' => $asset->model_number,
            'status_label' => ($asset->assetstatus) ? $asset->assetstatus : '',
            'last_checkout' => $asset->last_checkout,
            'category' => ($asset->model->category) ? $asset->model->category->name : '',
            'manufacturer' => $asset->manufacturer,
            'notes' => $asset->notes,
            'expected_checkin' => $asset->expected_checkin,
            'order_number' => $asset->order_number,
            'companyName' => $asset->companyName,
            'location' => ($asset->assetLoc) ? $asset->assetLoc->name : '',
            'image' => $asset->image,
            'assigned_to' => ($asset->assigneduser) ? $asset->assigneduser->present()->fullName() : '',
            'created_at' => $asset->created_at,
            'purchase_date' => $asset->purchase_date,
            'purchase_cost' => $asset->purchase_cost,
            'company' => ($asset->company) ? $asset->company->name: '',

        ];

        return $array;
    }

    public function transformAssetsDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }



}
