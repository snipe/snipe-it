<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Transformers\UsersTransformer;
use Gate;


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
            'name' => e($asset->name),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'model' => ($asset->model) ? ['id' => $asset->model->id,'name'=> e($asset->model->name)] : '',
            'model_number' => e($asset->model_number),
            'status_label' => ($asset->assetstatus) ? ['id' => $asset->assetstatus->id,'name'=> e($asset->assetstatus->name)] : null,
            'last_checkout' => $asset->last_checkout,
            'category' => ($asset->model->category) ? ['id' => $asset->model->category->id,'name'=> e($asset->model->category->name)]  : null,
            'manufacturer' => ($asset->model->manufacturer) ? ['id' => $asset->model->manufacturer->id,'name'=> e($asset->model->manufacturer->name)] : null,
            'notes' => $asset->notes,
            'expected_checkin' => $asset->expected_checkin,
            'order_number' => $asset->order_number,
            'company' => ($asset->company) ? ['id' => $asset->company->id,'name'=> e($asset->company->name)] : null,
            'location' => ($asset->assetLoc) ? ['id' => $asset->assetLoc->id,'name'=> e($asset->assetLoc->name)]  : null,
            'rtd_location' => ($asset->defaultLoc) ? ['id' => $asset->defaultLoc->id,'name'=> e($asset->defaultLoc->name)]  : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'assigned_to' => ($asset->assigneduser) ? ['id' => $asset->assigneduser->id, 'name' => $asset->assigneduser->getFullNameAttribute(), 'first_name'=> e( $asset->assigneduser->first_name), 'last_name'=> e( $asset->assigneduser->last_name)]  : null,
            'warranty' =>  ($asset->warranty_months > 0) ? e($asset->warranty_months).' '.trans('admin/hardware/form.months') : null,
            'warranty_expires' => ($asset->warranty_months > 0) ?  $asset->present()->warrantee_expires() : null,
            'created_at' => $asset->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $asset->updated_at->format('Y-m-d H:i:s'),
            'purchase_date' => $asset->purchase_date,
            'purchase_cost' => $asset->purchase_cost,
            'can_checkout' => $asset->availableForCheckout(),

        ];


        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Asset::class) ? true : false,
            'checkin' => Gate::allows('checkin', Asset::class) ? true : false,
            'update' => Gate::allows('update', Asset::class) ? true : false,
            'delete' => Gate::allows('delete', Asset::class) ? true : false,
        ];

        $array += $permissions_array;



        if ($asset->model->fieldset) {

         foreach($asset->model->fieldset->fields as $field) {
             $fields_array = [$field->name => $asset->{$field->convertUnicodeDbSlug()}];
             $array += $fields_array;
         }

        }


        return $array;
    }

    public function transformAssetsDatatable($assets) {
        return (new DatatablesTransformer)->transformDatatables($assets);
    }



}
