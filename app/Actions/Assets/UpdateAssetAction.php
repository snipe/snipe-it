<?php

namespace App\Actions\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Statuslabel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateAssetAction
{
    public static function run(
        Asset $asset,
        ImageUploadRequest $request,
        $status_id = null,
        $warranty_months = null,
        $purchase_cost = null,
        $purchase_date = null,
        $next_audit_date = null,
        $asset_eol_date = null,
        $supplier_id = null,
        $expected_checkin = null,
        $requestable = false,
        $rtd_location_id = null,
        $byod = false,
        $image_delete = false,
        $serial = null,
        $name = null,
        $company_id = null,
        $model_id = null,
        $order_number = null,
        $asset_tag = null,
        $notes = null,
    ): \App\Models\SnipeModel {

        dump($purchase_date);
        $asset->status_id = $status_id;
        $asset->warranty_months = $warranty_months;
        $asset->purchase_cost = $purchase_cost;
        $asset->purchase_date = $purchase_date;
        $asset->next_audit_date = $next_audit_date;
        if ($purchase_date && !$asset_eol_date && ($asset->model->eol > 0)) {
            $asset->purchase_date = $purchase_date;
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
        $asset->rtd_location_id = $rtd_location_id;
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

        $asset->name = $name;
        $asset->company_id = Company::getIdForCurrentUser($company_id);
        $asset->model_id = $model_id;
        $asset->order_number = $order_number;

        $asset->asset_tag = $asset_tag;

        $asset->notes = $notes;

        // andddddddd the handleImages issue reappears - i guess we'll be passing the request through here as well
        $asset = $request->handleImages($asset);

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        $model = AssetModel::find($request->get('model_id'));
        if (($model) && ($model->fieldset)) {
            foreach ($model->fieldset->fields as $field) {

                if ($field->field_encrypted == '1') {
                    if (Gate::allows('assets.view.encrypted_custom_fields')) {
                        if (is_array($request->input($field->db_column))) {
                            $asset->{$field->db_column} = Crypt::encrypt(implode(', ', $request->input($field->db_column)));
                        } else {
                            $asset->{$field->db_column} = Crypt::encrypt($request->input($field->db_column));
                        }
                    }
                } else {
                    if (is_array($request->input($field->db_column))) {
                        $asset->{$field->db_column} = implode(', ', $request->input($field->db_column));
                    } else {
                        $asset->{$field->db_column} = $request->input($field->db_column);
                    }
                }
            }
        }

        session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);

        $asset->save();

        return $asset;
    }
}