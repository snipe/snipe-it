<?php

namespace App\Actions\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Helpers\Helper;
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
        $status_id = null,
        $warranty_months = null,
        $purchase_cost = null,
        $purchase_date = null,
        $next_audit_date = null,
        $asset_eol_date = null,
        $supplier_id = null,
        $expected_checkin = null,
        $requestable = null,
        $rtd_location_id = null,
        $byod = null
    )
    {
        // Check if the asset exists
        //if (!$asset = Asset::find($assetId)) {
        //    // Redirect to the asset management page with error
        //    return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        //}
        //$this->authorize($asset);

        $asset->status_id = $status_id;
        $asset->warranty_months = $warranty_months;
        $asset->purchase_cost = $purchase_cost;
        $asset->purchase_date = $purchase_date;
        $asset->next_audit_date = $next_audit_date;
        if ($request->filled('purchase_date') && !$request->filled('asset_eol_date') && ($asset->model->eol > 0)) {
            $asset->purchase_date = $request->input('purchase_date', null);
            $asset->asset_eol_date = Carbon::parse($request->input('purchase_date'))->addMonths($asset->model->eol)->format('Y-m-d');
            $asset->eol_explicit = false;
        } elseif ($request->filled('asset_eol_date')) {
            $asset->asset_eol_date = $request->input('asset_eol_date', null);
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
        } elseif (!$request->filled('asset_eol_date') && (($asset->model->eol) == 0)) {
            $asset->asset_eol_date = null;
            $asset->eol_explicit = false;
        }
        $asset->supplier_id = $request->input('supplier_id', null);
        $asset->expected_checkin = $request->input('expected_checkin', null);
        $asset->requestable = $request->input('requestable', 0);
        $asset->rtd_location_id = $request->input('rtd_location_id', null);
        $asset->byod = $request->input('byod', 0);

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
            $asset->location_id = $request->input('rtd_location_id', null);
        }


        if ($request->filled('image_delete')) {
            try {
                unlink(public_path().'/uploads/assets/'.$asset->image);
                $asset->image = '';
            } catch (\Exception $e) {
                Log::info($e);
            }
        }

        // Update the asset data

        $serial = $request->input('serials');
        $asset->serial = $request->input('serials');

        if (is_array($request->input('serials'))) {
            $asset->serial = $serial[1];
        }

        $asset->name = $request->input('name');
        $asset->company_id = Company::getIdForCurrentUser($request->input('company_id'));
        $asset->model_id = $request->input('model_id');
        $asset->order_number = $request->input('order_number');

        $asset_tags = $request->input('asset_tags');
        $asset->asset_tag = $request->input('asset_tags');

        if (is_array($request->input('asset_tags'))) {
            $asset->asset_tag = $asset_tags[1];
        }

        $asset->notes = $request->input('notes');

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

        if ($asset->save()) {
            return redirect()->to(Helper::getRedirectOption($request, $assetId, 'Assets'))
                ->with('success', trans('admin/hardware/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($asset->getErrors());
    }
}