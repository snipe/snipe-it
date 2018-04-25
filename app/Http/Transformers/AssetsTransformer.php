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
            'model_number' => (($asset->model) && ($asset->model->model_number)) ? e($asset->model->model_number) : null,
            'eol' => ($asset->purchase_date!='') ? Helper::getFormattedDateObject($asset->present()->eol_date(), 'date') : null ,
            'status_label' => ($asset->assetstatus) ? [
                'id' => (int) $asset->assetstatus->id,
                'name'=> e($asset->assetstatus->name),
                'status_type'=> e($asset->assetstatus->getStatuslabelType()),
                'status_meta' => e($asset->present()->statusMeta),
            ] : null,
            'category' => (($asset->model) && ($asset->model->category)) ? [
                'id' => (int) $asset->model->category->id,
                'name'=> e($asset->model->category->name)
            ]  : null,
            'manufacturer' => (($asset->model) && ($asset->model->manufacturer)) ? [
                'id' => (int) $asset->model->manufacturer->id,
                'name'=> e($asset->model->manufacturer->name)
            ] : null,
            'supplier' => ($asset->supplier) ? [
                'id' => (int) $asset->supplier->id,
                'name'=> e($asset->supplier->name)
            ]  : null,
            'notes' => ($asset->notes) ? e($asset->notes) : null,
            'order_number' => ($asset->order_number) ? e($asset->order_number) : null,
            'company' => ($asset->company) ? [
                'id' => (int) $asset->company->id,
                'name'=> e($asset->company->name)
            ] : null,
            'location' => ($asset->location) ? [
                'id' => (int) $asset->location->id,
                'name'=> e($asset->location->name)
            ]  : null,
            'rtd_location' => ($asset->defaultLoc) ? [
                'id' => (int) $asset->defaultLoc->id,
                'name'=> e($asset->defaultLoc->name)
            ]  : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'assigned_to' => $this->transformAssignedTo($asset),
            'warranty_months' =>  ($asset->warranty_months > 0) ? e($asset->warranty_months . ' ' . trans('admin/hardware/form.months')) : null,
            'warranty_expires' => ($asset->warranty_months > 0) ?  Helper::getFormattedDateObject($asset->warranty_expires, 'date') : null,
            'created_at' => Helper::getFormattedDateObject($asset->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($asset->updated_at, 'datetime'),
            'last_audit_date' => Helper::getFormattedDateObject($asset->last_audit_date, 'datetime'),
            'next_audit_date' => Helper::getFormattedDateObject($asset->next_audit_date, 'date'),
            'deleted_at' => Helper::getFormattedDateObject($asset->deleted_at, 'datetime'),
            'purchase_date' => Helper::getFormattedDateObject($asset->purchase_date, 'date'),
            'last_checkout' => Helper::getFormattedDateObject($asset->last_checkout, 'datetime'),
            'expected_checkin' => Helper::getFormattedDateObject($asset->expected_checkin, 'date'),
            'purchase_cost' => Helper::formatCurrencyOutput($asset->purchase_cost),
            'checkins_count' => (int) $asset->checkins_count,
            'checkouts_count' => (int) $asset->checkouts_count,
            'user_requests_count' => (int) $asset->user_requests_count,
            'user_can_checkout' => (bool) $asset->availableForCheckout(),
        ];


        if (($asset->model) && ($asset->model->fieldset) && ($asset->model->fieldset->fields->count() > 0)) {
            $fields_array = array();

            foreach ($asset->model->fieldset->fields as $field) {

                if ($field->isFieldDecryptable($asset->{$field->convertUnicodeDbSlug()})) {
                    $decrypted = \App\Helpers\Helper::gracefulDecrypt($field,$asset->{$field->convertUnicodeDbSlug()});
                    $value = (Gate::allows('superadmin')) ? $decrypted : strtoupper(trans('admin/custom_fields/general.encrypted'));

                    $fields_array[$field->name] = [
                            'field' => $field->convertUnicodeDbSlug(),
                            'value' => $value,
                            'field_format' => $field->format,
                        ];

                } else {
                    $fields_array[$field->name] = [
                        'field' => $field->convertUnicodeDbSlug(),
                        'value' => $asset->{$field->convertUnicodeDbSlug()},
                        'field_format' => $field->format,
                    ];


                }
                $array['custom_fields'] = $fields_array;
            }
        } else {
            $array['custom_fields'] = array();
        }

        $permissions_array['available_actions'] = [
            'checkout' => (bool) Gate::allows('checkout', Asset::class),
            'checkin' => (bool) Gate::allows('checkin', Asset::class),
            'clone' => Gate::allows('create', Asset::class) ? true : false,
            'restore' => false,
            'update' => (bool) Gate::allows('update', Asset::class),
            'delete' => (bool) Gate::allows('delete', Asset::class),
        ];

        if ($asset->deleted_at!='') {
            $permissions_array['available_actions'] = [
                'checkout' => true,
                'checkin' => false,
                'clone' => Gate::allows('create', Asset::class) ? true : false,
                'restore' => Gate::allows('create', Asset::class) ? true : false,
                'update' => false,
                'delete' => false,
            ];
        }


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
            return $asset->assigned ? [
                    'id' => (int) $asset->assigned->id,
                    'username' => e($asset->assigned->username),
                    'name' => e($asset->assigned->getFullNameAttribute()),
                    'first_name'=> e($asset->assigned->first_name),
                    'last_name'=> ($asset->assigned->last_name) ? e($asset->assigned->last_name) : null,
                    'employee_number' =>  ($asset->assigned->employee_num) ? e($asset->assigned->employee_num) : null,
                    'type' => 'user'
                ] : null;
        }
        return $asset->assigned ? [
            'id' => $asset->assigned->id,
            'name' => $asset->assigned->display_name,
            'type' => $asset->assignedType()
        ] : null;
    }


    public function transformRequestedAssets(Collection $assets, $total)
    {
        $array = array();
        foreach ($assets as $asset) {
            $array[] = self::transformRequestedAsset($asset);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRequestedAsset(Asset $asset) {
        $array = [
            'id' => (int) $asset->id,
            'name' => e($asset->name),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'model' => ($asset->model) ? e($asset->model->name) : null,
            'model_number' => (($asset->model) && ($asset->model->model_number)) ? e($asset->model->model_number) : null,
            'expected_checkin' => Helper::getFormattedDateObject($asset->expected_checkin, 'date'),
            'location' => ($asset->location) ? e($asset->location->name) : null,
            'status'=> ($asset->assetstatus) ? $asset->present()->statusMeta : null,
        ];

        $permissions_array['available_actions'] = [
            'cancel' => ($asset->isRequestedBy(\Auth::user())) ? true : false,
            'request' => ($asset->isRequestedBy(\Auth::user())) ? false : true,

        ];

         $array += $permissions_array;
        return $array;

    }
}
