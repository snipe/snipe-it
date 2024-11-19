<?php

namespace App\Actions\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Exceptions\CustomFieldPermissionException;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Watson\Validating\ValidationException;

class UpdateAssetAction
{
    /**
     * @throws ValidationException
     * @throws CustomFieldPermissionException
     */
    public static function run(
        Asset $asset,
        ImageUploadRequest $request, //very much would like this to go away
        $status_id = null,
        $warranty_months = null,
        $purchase_cost = null,
        $purchase_date = null,
        $last_audit_date = null,
        $next_audit_date = null,
        $asset_eol_date = null,
        $supplier_id = null,
        $expected_checkin = null,
        $requestable = false,
        $location_id = null,
        $rtd_location_id = null,
        $assigned_location = null, // derp, make these work
        $assigned_asset = null,
        $assigned_user = null,
        $byod = false,
        $image_delete = false,
        $serial = null,
        $name = null,
        $company_id = null,
        $model_id = null,
        $order_number = null,
        $asset_tag = null,
        $notes = null,
        $isBulk = false,
    ): \App\Models\SnipeModel {

        $asset->status_id = $status_id ?? $asset->status_id;
        $asset->warranty_months = $warranty_months ?? $asset->warranty_months;
        $asset->purchase_cost = $purchase_cost ?? $asset->purchase_cost;
        $asset->purchase_date = $purchase_date ?? $asset->purchase_date?->format('Y-m-d');
        $asset->next_audit_date = $next_audit_date ?? $asset->next_audit_date;
        $asset->last_audit_date = $last_audit_date ?? $asset->last_audit_date;
        if ($purchase_date && !$asset_eol_date && ($asset->model->eol > 0)) {
            $asset->purchase_date = $purchase_date ?? $asset->purchase_date?->format('Y-m-d');
            $asset->asset_eol_date = Carbon::parse($purchase_date)->addMonths($asset->model->eol)->format('Y-m-d');
            $asset->eol_explicit = false;
        } elseif ($asset_eol_date) {
            $asset->asset_eol_date = $asset_eol_date ?? null;
            $months = Carbon::parse($asset->asset_eol_date)->diffInMonths($asset->purchase_date);
            if ($asset->model->eol) {
                if ($months != $asset->model->eol > 0) {
                    $asset->eol_explicit = true;
                } else {
                    $asset->eol_explicit = false;
                }
            } else {
                $asset->eol_explicit = true;
            }
        } elseif (!$asset_eol_date && (($asset->model->eol) == 0)) {
            $asset->asset_eol_date = null;
            $asset->eol_explicit = false;
        }
        $asset->supplier_id = $supplier_id;
        $asset->expected_checkin = $expected_checkin;
        $asset->requestable = $requestable;

        $asset->location_id = $location_id;

            !$isBulk ?? $asset->rtd_location_id = $rtd_location_id;
        $asset->byod = $byod;

        $status = Statuslabel::find($status_id);

        // This is a non-deployable status label - we should check the asset back in.
        if (($status && $status->getStatuslabelType() != 'deployable') && ($target = $asset->assignedTo)) {

            $originalValues = $asset->getRawOriginal();
            $asset->assigned_to = null;
            $asset->assigned_type = null;
            $asset->accepted = null;

            event(new CheckoutableCheckedIn($asset, $target, auth()->user(), 'Checkin on asset update', date('Y-m-d H:i:s'), $originalValues));
        }

        if ($asset->assigned_to == '') {
            $asset->location_id = $rtd_location_id;
        }


        if ($image_delete) {
            try {
                unlink(public_path().'/uploads/assets/'.$asset->image);
                $asset->image = '';
            } catch (\Exception $e) {
                Log::info($e);
            }
        }

        $asset->serial = $serial;

        if ($request->filled('null_name')) {
            $asset->name = null;
        } else {
            $asset->name = $name ?? $asset->name;
        }
        $asset->company_id = Company::getIdForCurrentUser($company_id);
        $asset->model_id = $model_id ?? $asset->model_id;
        $asset->order_number = $order_number ?? $asset->order_number;

        $asset->asset_tag = $asset_tag ?? $asset->asset_tag;

        $asset->notes = $notes;

        $asset = $request->handleImages($asset);

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.

        //if (($model) && ($model->fieldset)) {
        //    dump($model->fieldset->fields);
        //    foreach ($model->fieldset->fields as $field) {
        //
        //
        //        if ($field->field_encrypted == '1') {
        //            if (Gate::allows('assets.view.encrypted_custom_fields')) {
        //                if (is_array($request->input($field->db_column))) {
        //                    $asset->{$field->db_column} = Crypt::encrypt(implode(', ', $request->input($field->db_column)));
        //                } else {
        //                    $asset->{$field->db_column} = Crypt::encrypt($request->input($field->db_column));
        //                }
        //                throw new CustomFieldPermissionException();
        //                continue;
        //            }
        //        } else {
        //            if (is_array($request->input($field->db_column))) {
        //                $asset->{$field->db_column} = implode(', ', $request->input($field->db_column));
        //            } else {
        //                $asset->{$field->db_column} = $request->input($field->db_column);
        //            }
        //        }
        //    }
        //}
        $model = $asset->model;
        if (($model) && (isset($model->fieldset))) {
            foreach ($model->fieldset->fields as $field) {
                $field_val = $request->input($field->db_column, null);

                if ($request->has($field->db_column)) {
                    if ($field->element == 'checkbox') {
                        if (is_array($field_val)) {
                            $field_val = implode(',', $field_val);
                        }
                    }
                    if ($field->field_encrypted == '1') {
                        if (Gate::allows('assets.view.encrypted_custom_fields')) {
                            $field_val = Crypt::encrypt($field_val);
                        } else {
                            throw new CustomFieldPermissionException();
                            continue;
                        }
                    }
                    $asset->{$field->db_column} = $field_val;
                }
            }
        }

        session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);

        if ($isBulk) {
            self::bulkUpdate($asset, $request);
        }

        if ($asset->save()) {
            // check out stuff
            $location = Location::find($asset->location_id);
            if (!is_null($assigned_user) && ($target = User::find($assigned_user))) {
                $location = $target->location_id;
            } elseif (!is_null($assigned_asset) && ($target = Asset::find($assigned_asset))) {
                $location = $target->location_id;
                Asset::where('assigned_type', \App\Models\Asset::class)->where('assigned_to', $asset->id)
                    ->update(['location_id' => $target->location_id]);
            } elseif (!is_null($assigned_location) && ($target = Location::find($assigned_location))) {
                $location = $target->id;
            }

            if (isset($target)) {
                $asset->checkOut($target, auth()->user(), date('Y-m-d H:i:s'), '', 'Checked out on asset update', e($request->get('name')), $location);
            }

            if ($asset->image) {
                $asset->image = $asset->getImageUrl();
            }
        }

        return $asset;
    }

    private static function bulkUpdate($asset, $request): void
    {
        if ($request->filled('rtd_location_id')) {

            if (($request->filled('update_real_loc')) && (($request->input('update_real_loc')) == '0')) {
                $asset->rtd_location_id = $request->input('rtd_location_id');
            }

            if (($request->filled('update_real_loc')) && (($request->input('update_real_loc')) == '1')) {
                $asset->location_id = $request->input('rtd_location_id');
                $asset->rtd_location_id = $request->input('rtd_location_id');
            }

            if (($request->filled('update_real_loc')) && (($request->input('update_real_loc')) == '2')) {
                $asset->location_id = $request->input('rtd_location_id');
            }

        }

    }
}