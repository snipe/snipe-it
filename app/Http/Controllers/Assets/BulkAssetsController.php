<?php

namespace App\Http\Controllers\Assets;

use App\Actions\Assets\UpdateAssetAction;
use App\Exceptions\CustomFieldPermissionException;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\Setting;
use App\View\Label;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\CustomField;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Watson\Validating\ValidationException;

class BulkAssetsController extends Controller
{
    use CheckInOutRequest;

    /**
     * Display the bulk edit page.
     *
     * This method is super weird because it's kinda of like a controller within a controller.
     * It's main function is to determine what the bulk action in, and then return a view with
     * the information that view needs, be it bulk delete, bulk edit, restore, etc.
     *
     * This is something that made sense at the time, but sort of doesn't make sense now. A JS front-end to determine form
     * action would make a lot more sense here and make things a lot more clear.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @internal param int $assetId
     * @since [v2.0]
     */
    public function edit(Request $request) : View | RedirectResponse
    {
        $this->authorize('view', Asset::class);

        /**
         * No asset IDs were passed
         */
        if (! $request->filled('ids')) {
            return redirect()->back()->with('error', trans('admin/hardware/message.update.no_assets_selected'));
        }

        $asset_ids = $request->input('ids');
        if ($request->input('bulk_actions') === 'checkout') {
            $request->session()->flashInput(['selected_assets' => $asset_ids]);
            return redirect()->route('hardware.bulkcheckout.show');
        }

        // Figure out where we need to send the user after the update is complete, and store that in the session
        $bulk_back_url = request()->headers->get('referer');
        session(['bulk_back_url' => $bulk_back_url]);

        $allowed_columns = [
            'id',
            'name',
            'asset_tag',
            'serial',
            'model_number',
            'last_checkout',
            'notes',
            'expected_checkin',
            'order_number',
            'image',
            'assigned_to',
            'created_at',
            'updated_at',
            'purchase_date',
            'purchase_cost',
            'last_audit_date',
            'next_audit_date',
            'warranty_months',
            'checkout_counter',
            'checkin_counter',
            'requests_counter',
            'byod',
            'asset_eol_date',
        ];


        /**
         * Make sure the column is allowed, and if it's a custom field, make sure we strip the custom_fields. prefix
         */
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort_override = str_replace('custom_fields.', '', $request->input('sort'));

        // This handles all of the pivot sorting below (versus the assets.* fields in the allowed_columns array)
        $column_sort = in_array($sort_override, $allowed_columns) ? $sort_override : 'assets.id';

        $assets = Asset::with('assignedTo', 'location', 'model')
                ->whereIn('assets.id', $asset_ids)
                ->withTrashed();

        $assets = $assets->get();

        if ($assets->isEmpty()) {
            Log::debug('No assets were found for the provided IDs', ['ids' => $asset_ids]);
            return redirect()->back()->with('error', trans('admin/hardware/message.update.assets_do_not_exist_or_are_invalid'));
        }

        $models = $assets->unique('model_id');
        $modelNames = [];
        foreach($models as $model) {
            $modelNames[] = $model->model->name;
        }

        if ($request->filled('bulk_actions')) {


            switch ($request->input('bulk_actions')) {
                case 'labels':
                    $this->authorize('view', Asset::class);

                    return (new Label)
                        ->with('assets', $assets)
                        ->with('settings', Setting::getSettings())
                        ->with('bulkedit', true)
                        ->with('count', 0);

                case 'delete':
                    $this->authorize('delete', Asset::class);
                    $assets->each(function ($assets) {
                        $this->authorize('delete', $assets);
                    });

                    return view('hardware/bulk-delete')->with('assets', $assets);

                case 'restore':
                    $this->authorize('update', Asset::class);
                    $assets = Asset::withTrashed()->find($asset_ids);
                    $assets->each(function ($asset) {
                        $this->authorize('delete', $asset);
                    });
                    return view('hardware/bulk-restore')->with('assets', $assets);

                case 'edit':
                    $this->authorize('update', Asset::class);

                    return view('hardware/bulk')
                        ->with('assets', $asset_ids)
                        ->with('statuslabel_list', Helper::statusLabelList())
                        ->with('models', $models->pluck(['model']))
                        ->with('modelNames', $modelNames);
            }
        }

        switch ($sort_override) {
            case 'model':
                $assets->OrderModels($order);
                break;
            case 'model_number':
                $assets->OrderModelNumber($order);
                break;
            case 'category':
                $assets->OrderCategory($order);
                break;
            case 'manufacturer':
                $assets->OrderManufacturer($order);
                break;
            case 'company':
                $assets->OrderCompany($order);
                break;
            case 'location':
                $assets->OrderLocation($order);
            case 'rtd_location':
                $assets->OrderRtdLocation($order);
                break;
            case 'status_label':
                $assets->OrderStatus($order);
                break;
            case 'supplier':
                $assets->OrderSupplier($order);
                break;
            case 'assigned_to':
                $assets->OrderAssigned($order);
                break;
            default:
                $assets->orderBy($column_sort, $order);
                break;
        }

        return redirect()->back()->with('error', 'No action selected');
    }

    /**
     * Save bulk edits
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @internal param array $assets
     * @since [v2.0]
     */
    public function update(ImageUploadRequest $request): RedirectResponse
    {
        // this should be in request, but request weird, need to think it through a little
        $this->authorize('update', Asset::class);
        // Get the back url from the session and then destroy the session
        $bulk_back_url = route('hardware.index');
        $custom_field_problem = false;
        // is this necessary?
        if (!$request->filled('ids') || count($request->input('ids')) == 0) {
            return redirect($bulk_back_url)->with('error', trans('admin/hardware/message.update.no_assets_selected'));
        }
        if ($request->session()->has('bulk_back_url')) {
            $bulk_back_url = $request->session()->pull('bulk_back_url');
        }
        // find and update assets
        $assets = Asset::whereIn('id', $request->input('ids'))->get();
        $errors = [];
        foreach ($assets as $key => $asset) {
            try {
                $updatedAsset = UpdateAssetAction::run(
                    asset: $asset,
                    request: $request,
                    status_id: $request->input('status_id'),
                    warranty_months: $request->input('warranty_months'),
                    purchase_cost: $request->input('purchase_cost'),
                    purchase_date: $request->filled('null_purchase_date') ? null : $request->input('purchase_date'),
                    next_audit_date: $request->filled('null_next_audit_date') ? null : $request->input('next_audit_date'),
                    supplier_id: $request->input('supplier_id'),
                    expected_checkin: $request->filled('null_expected_checkin_date') ? null : $request->input('expected_checkin'),
                    requestable: $request->input('requestable'),
                    rtd_location_id: $request->input('rtd_location_id'),
                    name: $request->filled('null_name') ? null : $request->input('name'),
                    company_id: $request->input('company_id'),
                    model_id: $request->input('model_id'),
                    order_number: $request->input('order_number'),
                    isBulk: true,
                );
            } catch (ValidationException $e) {
                $errors = $e->validator->errors()->toArray();
            } catch (CustomFieldPermissionException $e) {
                $custom_field_problem = true;
            } catch (\Exception $e) {
                report($e);
                $errors[$key] = [trans('general.something_went_wrong')];
            }
        }
        if (!empty($errors)) {
            return redirect($bulk_back_url)->with('bulk_asset_errors', $errors);
        }
        if ($custom_field_problem) {
            return redirect($bulk_back_url)->with('error', trans('admin/hardware/message.update.encrypted_warning'));
        }
        return redirect($bulk_back_url)->with('success', trans('bulk.update.success'));
    }

    /**
     * Array to store update data per item
     * @var array
     */
    private $update_array;

    /**
     * Adds parameter to update array for an item if it exists in request
     * @param  string $field field name
     */
    protected function conditionallyAddItem($field) : BulkAssetsController
    {
        if (request()->filled($field)) {
            $this->update_array[$field] = request()->input($field);
        }

        return $this;
    }

    /**
     * Save bulk deleted.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @internal param array $assets
     * @since [v2.0]
     */
    public function destroy(Request $request) : RedirectResponse
    {
        $this->authorize('delete', Asset::class);

        $bulk_back_url = route('hardware.index');

        if ($request->session()->has('bulk_back_url')) {
            $bulk_back_url = $request->session()->pull('bulk_back_url');
        }
        $assetIds = $request->get('ids');

        if(empty($assetIds)) {
            return redirect($bulk_back_url)->with('error', trans('admin/hardware/message.delete.nothing_updated'));
        }

        $assignedAssets = Asset::whereIn('id', $assetIds)->whereNotNull('assigned_to')->get();
        if($assignedAssets->isNotEmpty()) {

            //if assets are checked out, return a list of asset tags that would need to be checked in first.
            $assetTags = $assignedAssets->pluck('asset_tag')->implode(', ');
            return redirect($bulk_back_url)->with('error', trans_choice('admin/hardware/message.delete.assigned_to_error', $assignedAssets->count(), ['asset_tag' => $assetTags] ));
        }

        foreach (Asset::wherein('id', $assetIds)->get() as $asset) {
                $asset->delete();
            }

        return redirect($bulk_back_url)->with('success', trans('admin/hardware/message.delete.success'));
            // no values given, nothing to update

    }

    /**
     * Show Bulk Checkout Page
     */
    public function showCheckout() : View
    {
        $this->authorize('checkout', Asset::class);
        return view('hardware/bulk-checkout');
    }

    /**
     * Process Multiple Checkout Request
     */
    public function storeCheckout(AssetCheckoutRequest $request) : RedirectResponse | ModelNotFoundException
    {

        $this->authorize('checkout', Asset::class);

        try {
            $admin = auth()->user();

            $target = $this->determineCheckoutTarget();

            if (! is_array($request->get('selected_assets'))) {
                return redirect()->route('hardware.bulkcheckout.show')->withInput()->with('error', trans('admin/hardware/message.checkout.no_assets_selected'));
            }

            $asset_ids = array_filter($request->get('selected_assets'));

            if (request('checkout_to_type') == 'asset') {
                foreach ($asset_ids as $asset_id) {
                    if ($target->id == $asset_id) {
                        return redirect()->back()->with('error', 'You cannot check an asset out to itself.');
                    }
                }
            }
            $checkout_at = date('Y-m-d H:i:s');
            if (($request->filled('checkout_at')) && ($request->get('checkout_at') != date('Y-m-d'))) {
                $checkout_at = e($request->get('checkout_at'));
            }

            $expected_checkin = '';

            if ($request->filled('expected_checkin')) {
                $expected_checkin = e($request->get('expected_checkin'));
            }

            $errors = [];
            DB::transaction(function () use ($target, $admin, $checkout_at, $expected_checkin, &$errors, $asset_ids, $request) { //NOTE: $errors is passsed by reference!
                foreach ($asset_ids as $asset_id) {
                    $asset = Asset::findOrFail($asset_id);
                    $this->authorize('checkout', $asset);

                    $checkout_success = $asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($request->get('note')), $asset->name, null);

                    //TODO - I think this logic is duplicated in the checkOut method?
                    if ($target->location_id != '') {
                        $asset->location_id = $target->location_id;
                        // TODO - I don't know why this is being saved without events
                        $asset::withoutEvents(function () use ($asset) {
                            $asset->save();
                        });
                    }

                    if (!$checkout_success) {
                        $errors = array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
            });

            if (! $errors) {
                // Redirect to the new asset page
                return redirect()->to('hardware')->with('success', trans_choice('admin/hardware/message.multi-checkout.success', $asset_ids));
            }
            // Redirect to the asset management page with error
            return redirect()->route('hardware.bulkcheckout.show')->withInput()->with('error', trans_choice('admin/hardware/message.multi-checkout.error', $asset_ids))->withErrors($errors);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('hardware.bulkcheckout.show')->with('error', $e->getErrors());
        }
        
    }
    public function restore(Request $request) : RedirectResponse
    {
        $this->authorize('update', Asset::class);
        $assetIds = $request->get('ids');

        if (empty($assetIds)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.restore.nothing_updated'));
        } else {
            foreach ($assetIds as $key => $assetId) {
                $asset = Asset::withTrashed()->find($assetId);
                $asset->restore();
            } 
            return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.restore.success'));
        }
    }
}
