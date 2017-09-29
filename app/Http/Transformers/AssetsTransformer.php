<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Transformers\UsersTransformer;
use Gate;
use App\Helpers\Helper;

class AssetsTransformer
{
    public function transformAssets(Collection $assets, $total)
    {
        $array = array();
        foreach ($assets as $asset) {
            $array[] = self::transformAsset($asset);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformAsset(Asset $asset)
    {
        $array = [
            'id' => (int) $asset->id,
            'name' => e($asset->name),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'model' => ($asset->model) ? [
                'id' => (int) $asset->model->id,
                'name'=> e($asset->model->name)
            ] : null,
            'model_number' => ($asset->model) ? e($asset->model->model_number) : null,
            'status_label' => ($asset->assetstatus) ? [
                'id' => (int) $asset->assetstatus->id,
                'name'=> e($asset->present()->statusText),
                'status_meta' =>  e($asset->present()->statusMeta),
            ] : null,
            'category' => ($asset->model->category) ? [
                'id' => (int) $asset->model->category->id,
                'name'=> e($asset->model->category->name)
            ]  : null,
            'manufacturer' => ($asset->model->manufacturer) ? [
                'id' => (int) $asset->model->manufacturer->id,
                'name'=> e($asset->model->manufacturer->name)
            ] : null,
            'supplier' => ($asset->supplier) ? [
                'id' => (int) $asset->supplier->id,
                'name'=> e($asset->supplier->name)
            ]  : null,
            'notes' => e($asset->notes),
            'order_number' => e($asset->order_number),
            'company' => ($asset->company) ? [
                'id' => (int) $asset->company->id,
                'name'=> e($asset->company->name)
            ] : null,
            'location' => ($asset->assetLoc) ? [
                'id' => (int) $asset->assetLoc->id,
                'name'=> e($asset->assetLoc->name)
            ]  : null,
            'rtd_location' => ($asset->defaultLoc) ? [
                'id' => (int) $asset->defaultLoc->id,
                'name'=> e($asset->defaultLoc->name)
            ]  : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'assigned_to' => $this->transformAssignedTo($asset),
            'warranty' =>  ($asset->warranty_months > 0) ? e($asset->warranty_months . ' ' . trans('admin/hardware/form.months')) : null,
            'warranty_expires' => ($asset->warranty_months > 0) ?  Helper::getFormattedDateObject($asset->warranty_expires, 'date') : null,
            'created_at' => Helper::getFormattedDateObject($asset->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($asset->updated_at, 'datetime'),
            'purchase_date' => Helper::getFormattedDateObject($asset->purchase_date, 'date'),
            'last_checkout' => Helper::getFormattedDateObject($asset->last_checkout, 'datetime'),
            'expected_checkin' => Helper::getFormattedDateObject($asset->expected_checkin, 'date'),
            'purchase_cost' => Helper::formatCurrencyOutput($asset->purchase_cost),
            'user_can_checkout' => (bool) $asset->availableForCheckout(),
        ];


        if (($asset->model->fieldset) && (count($asset->model->fieldset->fields)> 0)) {
            $fields_array = array();

            foreach ($asset->model->fieldset->fields as $field) {

                if ($field->isFieldDecryptable($asset->{$field->convertUnicodeDbSlug()})) {
                    $decrypted = \App\Helpers\Helper::gracefulDecrypt($field,$asset->{$field->convertUnicodeDbSlug()});
                    $value = (Gate::allows('superadmin')) ? $decrypted : strtoupper(trans('admin/custom_fields/general.encrypted'));

 //                   $fields_array = [$field->convertUnicodeDbSlug() => $value];


                    $fields_array[$field->name] = [
                            'field' => $field->convertUnicodeDbSlug(),
                            'value' => $value
                        ];

                } else {
                    $fields_array[$field->name] = [
                        'field' => $field->convertUnicodeDbSlug(),
                        'value' => $asset->{$field->convertUnicodeDbSlug()}
                    ];
                    //$fields_array = [$field->convertUnicodeDbSlug() => $asset->{$field->convertUnicodeDbSlug()}];


                }
                //array += $fields_array;
                $array['custom_fields'] = $fields_array;
            }
        } else {
            $array['custom_fields'] = array();
        }

        $permissions_array['available_actions'] = [
            'checkout' => (bool) Gate::allows('checkout', Asset::class),
            'checkin' => (bool) Gate::allows('checkin', Asset::class),
            'clone' => Gate::allows('create', Asset::class) ? true : false,
            'update' => (bool) Gate::allows('update', Asset::class),
            'delete' => (bool) Gate::allows('delete', Asset::class),
        ];

        $array += $permissions_array;
        return $array;
    }

    public function transformAssetsDatatable($assets)
    {
        return (new DatatablesTransformer)->transformDatatables($assets);
    }

    public function transformAssignedTo($asset)
    {
        if ($asset->checkedOutToUser()) {
            return $asset->assignedTo ? [
                    'id' => (int) $asset->assignedTo->id,
                    'username' => e($asset->assignedTo->username),
                    'name' => e($asset->assignedTo->getFullNameAttribute()),
                    'first_name'=> e($asset->assignedTo->first_name),
                    'last_name'=> e($asset->assignedTo->last_name),
                    'employee_number' =>  e($asset->assignedTo->employee_num),
                    'type' => 'user'
                ] : null;
        }
        return $asset->assignedTo ? [
            'id' => $asset->assignedTo->id,
            'name' => $asset->assignedTo->display_name,
            'type' => $asset->assignedType()
        ] : null;
    }
}
