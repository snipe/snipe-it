<?php

namespace App\Actions\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Exceptions\CheckoutNotAllowed;
use App\Exceptions\CustomFieldPermissionException;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\SnipeModel;
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
     * @throws CheckoutNotAllowed
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
        $assigned_location = null,
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
    ): SnipeModel
    {

        $asset->status_id = $status_id ?? $asset->status_id;
        $asset->warranty_months = $warranty_months ?? $asset->warranty_months;
        $asset->purchase_cost = $purchase_cost ?? $asset->purchase_cost;
        if ($request->input('null_purchase_date') === '1') {
            $asset->purchase_date = null;
            if (!($asset->eol_explicit)) {
                $asset->asset_eol_date = null;
            }
        } else {
            $asset->purchase_date = $purchase_date ?? $asset->purchase_date?->format('Y-m-d');
        }
        if ($request->input('null_next_audit_date') == '1') {
            $asset->next_audit_date = null;
        } else {
            $asset->next_audit_date = $next_audit_date ?? $asset->next_audit_date;
        }

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
        if ($request->input('null_expected_checkin_date') == '1') {
            $asset->expected_checkin = null;
        } else {
            $asset->expected_checkin = $expected_checkin ?? $asset->expected_checkin;
        }
        $asset->requestable = $requestable;

        $asset->location_id = $location_id;

        $asset->rtd_location_id = $rtd_location_id ?? $asset->rtd_location_id;
        if ($request->has('model_id')) {
            $asset->model()->associate(AssetModel::find($request->validated('model_id')));
        }
        if ($request->has('company_id')) {
            $asset->company_id = Company::getIdForCurrentUser($request->validated('company_id'));
        }
        if ($request->has('rtd_location_id') && !$request->has('location_id')) {
            $asset->location_id = $request->validated('rtd_location_id');
        }
        if ($request->input('last_audit_date')) {
            $asset->last_audit_date = Carbon::parse($request->input('last_audit_date'))->startOfDay()->format('Y-m-d H:i:s');
        }
        $asset->byod = $byod;

        $status = Statuslabel::find($status_id);

        // This is a non-deployable status label - we should check the asset back in.
        if (($status && $status->getStatuslabelType() != 'deployable') && ($target = $asset->assignedTo)) {
            $originalValues = $asset->getRawOriginal();
            $asset->assigned_to = null;
            $asset->assigned_type = null;
            $asset->accepted = null;

            event(new CheckoutableCheckedIn($asset, $target, auth()->user(), 'Checkin on asset update', date('Y-m-d H:i:s'), $originalValues));
            // reset this to null so checkout logic doesn't happen below
            $target = null;
        }

        //this is causing an issue while setting location_id - this came from the gui but doesn't seem to work as expected in the api -
        //throwing on !expectsJson for now until we can work out how to handle this better
        if ($asset->assigned_to == '' && !$request->expectsJson()) {
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

        self::handleCustomFields($request, $asset);

        if ($isBulk) {
            self::bulkLocationUpdate($asset, $request);
        }

        $asset->save();
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
            self::handleCheckout($asset, $target, $request, $location);
        }

        if ($asset->image) {
            $asset->image = $asset->getImageUrl();
        }

        return $asset;
    }

    private static function bulkLocationUpdate($asset, $request): void
    {
        /**
         * We're changing the location ID - figure out which location we should apply
         * this change to:
         *
         * 0 - RTD location only
         * 1 - location ID and RTD location ID
         * 2 - location ID only
         *
         * Note: this is kinda dumb and we should just use human-readable values IMHO. - snipe
         */
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

    private static function handleCustomFields($request, $asset): void
    {
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
                        }
                    }
                    $asset->{$field->db_column} = $field_val;
                }
            }
        }
    }

    private static function handleCheckout($asset, $target, $request, $location): void
    {
        $asset->checkOut($target, auth()->user(), date('Y-m-d H:i:s'), '', 'Checked out on asset update', e($request->get('name')), $location);
    }
}