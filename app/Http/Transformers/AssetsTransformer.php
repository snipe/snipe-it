<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Transformers\UsersTransformer;
use Gate;
use App\Helpers\Helper;


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
            'model_number' => ($asset->model_number) ? e($asset->model_number) : null,
            'status_label' => ($asset->assetstatus) ? ['id' => $asset->assetstatus->id,'name'=> e($asset->assetstatus->name)] : null,
            'category' => ($asset->model->category) ? ['id' => $asset->model->category->id,'name'=> e($asset->model->category->name)]  : null,
            'manufacturer' => ($asset->model->manufacturer) ? ['id' => $asset->model->manufacturer->id,'name'=> e($asset->model->manufacturer->name)] : null,
            'notes' => $asset->notes,
            'order_number' => $asset->order_number,
            'company' => ($asset->company) ? ['id' => $asset->company->id,'name'=> e($asset->company->name)] : null,
            'location' => ($asset->assetLoc) ? ['id' => $asset->assetLoc->id,'name'=> e($asset->assetLoc->name)]  : null,
            'rtd_location' => ($asset->defaultLoc) ? ['id' => $asset->defaultLoc->id,'name'=> e($asset->defaultLoc->name)]  : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'assigned_to' => ($asset->assigneduser) ? ['id' => $asset->assigneduser->id, 'name' => $asset->assigneduser->getFullNameAttribute(), 'first_name'=> e( $asset->assigneduser->first_name), 'last_name'=> e( $asset->assigneduser->last_name)]  : null,
            'warranty' =>  ($asset->warranty_months > 0) ? e($asset->warranty_months).' '.trans('admin/hardware/form.months') : null,
            'warranty_expires' => ($asset->warranty_months > 0) ?  $asset->present()->warrantee_expires() : null,
            'created_at' => Helper::getFormattedDateObject($asset->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($asset->updated_at, 'datetime'),
            'purchase_date' => Helper::getFormattedDateObject($asset->purchase_date, 'date'),
            'last_checkout' => Helper::getFormattedDateObject($asset->last_checkout, 'datetime'),
            'expected_checkin' => Helper::getFormattedDateObject($asset->expected_checkin, 'date'),
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
