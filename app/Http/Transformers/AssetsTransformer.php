<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class AssetsTransformer
{
    public function transformAssets(Collection $assets, $total)
    {
        $array = [];
        foreach ($assets as $asset) {
            $array[] = self::transformAsset($asset);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAsset(Asset $asset)
    {
        // This uses the getSettings() method so we're pulling from the cache versus querying the settings on single asset
        $setting = Setting::getSettings();

        $array = [
            'id' => (int) $asset->id,
            'name' => e($asset->name),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'model' => ($asset->model) ? [
                'id' => (int) $asset->model->id,
                'name'=> e($asset->model->name),
            ] : null,
            'model_number' => (($asset->model) && ($asset->model->model_number)) ? e($asset->model->model_number) : null,
            'eol' => ($asset->purchase_date != '') ? Helper::getFormattedDateObject($asset->present()->eol_date(), 'date') : null,
            'status_label' => ($asset->assetstatus) ? [
                'id' => (int) $asset->assetstatus->id,
                'name'=> e($asset->assetstatus->name),
                'status_type'=> e($asset->assetstatus->getStatuslabelType()),
                'status_meta' => e($asset->present()->statusMeta),
            ] : null,
            'category' => (($asset->model) && ($asset->model->category)) ? [
                'id' => (int) $asset->model->category->id,
                'name'=> e($asset->model->category->name),
            ] : null,
            'manufacturer' => (($asset->model) && ($asset->model->manufacturer)) ? [
                'id' => (int) $asset->model->manufacturer->id,
                'name'=> e($asset->model->manufacturer->name),
            ] : null,
            'supplier' => ($asset->supplier) ? [
                'id' => (int) $asset->supplier->id,
                'name'=> e($asset->supplier->name),
            ] : null,
            'notes' => ($asset->notes) ? e($asset->notes) : null,
            'order_number' => ($asset->order_number) ? e($asset->order_number) : null,
            'company' => ($asset->company) ? [
                'id' => (int) $asset->company->id,
                'name'=> e($asset->company->name),
            ] : null,
            'location' => ($asset->location) ? [
                'id' => (int) $asset->location->id,
                'name'=> e($asset->location->name),
            ] : null,
            'rtd_location' => ($asset->defaultLoc) ? [
                'id' => (int) $asset->defaultLoc->id,
                'name'=> e($asset->defaultLoc->name),
            ] : null,
            'image' => ($asset->getImageUrl()) ? $asset->getImageUrl() : null,
            'qr' => ($setting->qr_code=='1') ? config('app.url').'/uploads/barcodes/qr-'.str_slug($asset->asset_tag).'-'.str_slug($asset->id).'.png' : null,
            'alt_barcode' => ($setting->alt_barcode_enabled=='1') ? config('app.url').'/uploads/barcodes/'.str_slug($setting->alt_barcode).'-'.str_slug($asset->asset_tag).'.png' : null,
            'assigned_to' => $this->transformAssignedTo($asset),
            'warranty_months' =>  ($asset->warranty_months > 0) ? e($asset->warranty_months.' '.trans('admin/hardware/form.months')) : null,
            'warranty_expires' => ($asset->warranty_months > 0) ? Helper::getFormattedDateObject($asset->warranty_expires, 'date') : null,
            'created_at' => Helper::getFormattedDateObject($asset->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($asset->updated_at, 'datetime'),
            'last_audit_date' => Helper::getFormattedDateObject($asset->last_audit_date, 'datetime'),
            'next_audit_date' => Helper::getFormattedDateObject($asset->next_audit_date, 'date'),
            'deleted_at' => Helper::getFormattedDateObject($asset->deleted_at, 'datetime'),
            'purchase_date' => Helper::getFormattedDateObject($asset->purchase_date, 'date'),
            'last_checkout' => Helper::getFormattedDateObject($asset->last_checkout, 'datetime'),
            'expected_checkin' => Helper::getFormattedDateObject($asset->expected_checkin, 'date'),
            'purchase_cost' => Helper::formatCurrencyOutput($asset->purchase_cost),
            'checkin_counter' => (int) $asset->checkin_counter,
            'checkout_counter' => (int) $asset->checkout_counter,
            'requests_counter' => (int) $asset->requests_counter,
            'user_can_checkout' => (bool) $asset->availableForCheckout(),
        ];


        if (($asset->model) && ($asset->model->fieldset) && ($asset->model->fieldset->fields->count() > 0)) {
            $fields_array = [];

            foreach ($asset->model->fieldset->fields as $field) {
                if ($field->isFieldDecryptable($asset->{$field->db_column})) {
                    $decrypted = Helper::gracefulDecrypt($field, $asset->{$field->db_column});
                    $value = (Gate::allows('superadmin')) ? $decrypted : strtoupper(trans('admin/custom_fields/general.encrypted'));

                    if ($field->format == 'DATE'){
                        if (Gate::allows('superadmin')){
                            $value = Helper::getFormattedDateObject($value, 'date', false);
                        } else {
                           $value = strtoupper(trans('admin/custom_fields/general.encrypted'));
                        }
                    }

                    $fields_array[$field->name] = [
                            'field' => e($field->db_column),
                            'value' => e($value),
                            'field_format' => $field->format,
                            'element' => $field->element,
                        ];

                } else {
                    $value = $asset->{$field->db_column};

                    if (($field->format == 'DATE') && (!is_null($value)) && ($value!='')){
                        $value = Helper::getFormattedDateObject($value, 'date', false);
                    }
                    
                    $fields_array[$field->name] = [
                        'field' => e($field->db_column),
                        'value' => e($value),
                        'field_format' => $field->format,
                        'element' => $field->element,
                    ];
                }

                $array['custom_fields'] = $fields_array;
            }
        } else {
            $array['custom_fields'] = [];
        }

        $permissions_array['available_actions'] = [
            'checkout'      => ($asset->deleted_at=='' && Gate::allows('checkout', Asset::class)) ? true : false,
            'checkin'       => ($asset->deleted_at=='' && Gate::allows('checkin', Asset::class)) ? true : false,
            'clone'         => Gate::allows('create', Asset::class) ? true : false,
            'restore'       => ($asset->deleted_at!='' && Gate::allows('create', Asset::class)) ? true : false,
            'update'        => ($asset->deleted_at=='' && Gate::allows('update', Asset::class)) ? true : false,
            'delete'        => ($asset->deleted_at=='' && $asset->assigned_to =='' && Gate::allows('delete', Asset::class)) ? true : false,
        ];      


        if (request('components')=='true') {
        
            if ($asset->components) {
                $array['components'] = [];
    
                foreach ($asset->components as $component) {
                    $array['components'][] = [
                        
                            'id' => $component->id,
                            'pivot_id' => $component->pivot->id,
                            'name' => e($component->name),
                            'qty' => $component->pivot->assigned_qty,
                            'price_cost' => $component->purchase_cost,
                            'purchase_total' => $component->purchase_cost * $component->pivot->assigned_qty,
                            'checkout_date' => Helper::getFormattedDateObject($component->pivot->created_at, 'datetime') ,
                        
                    ];
                }
            }

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
                    'type' => 'user',
                ] : null;
        }

        return $asset->assigned ? [
            'id' => $asset->assigned->id,
            'name' => e($asset->assigned->display_name),
            'type' => $asset->assignedType()
        ] : null;
    }


    public function transformRequestedAssets(Collection $assets, $total)
    {
        $array = [];
        foreach ($assets as $asset) {
            $array[] = self::transformRequestedAsset($asset);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRequestedAsset(Asset $asset)
    {
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
            'assigned_to_self' => ($asset->assigned_to == \Auth::user()->id),
        ];

        $permissions_array['available_actions'] = [
            'cancel' => ($asset->isRequestedBy(\Auth::user())) ? true : false,
            'request' => ($asset->isRequestedBy(\Auth::user())) ? false : true,
        ];

        $array += $permissions_array;
        return $array;


    }
}
