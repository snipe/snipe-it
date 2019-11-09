<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AssetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class BulkAssetModelsController extends Controller
{
  /**
     * Returns a view that allows the user to bulk edit model attrbutes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.7]
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        $models_raw_array = Input::get('ids');

        // Make sure some IDs have been selected
        if ((is_array($models_raw_array)) && (count($models_raw_array) > 0)) {

            $models = AssetModel::whereIn('id', $models_raw_array)
                ->withCount('assets as assets_count')
                ->orderBy('assets_count', 'ASC')
                ->get();

            // If deleting....
            if ($request->input('bulk_actions')=='delete') {
                $valid_count = 0;
                foreach ($models as $model) {
                    if ($model->assets_count == 0) {
                        $valid_count++;
                    }
                }
                return view('models/bulk-delete', compact('models'))->with('valid_count', $valid_count);

            // Otherwise display the bulk edit screen
            }

            $nochange = ['NC' => 'No Change'];
            return view('models/bulk-edit', compact('models'))
                ->with('fieldset_list', $nochange + Helper::customFieldsetList())
                ->with('depreciation_list', $nochange + Helper::depreciationList());
        }

        return redirect()->route('models.index')
            ->with('error', 'You must select at least one model to edit.');
    }

    /**
     * Returns a view that allows the user to bulk edit model attrbutes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.7]
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request)
    {

        $models_raw_array = Input::get('ids');
        $update_array = array();

        if (($request->filled('manufacturer_id') && ($request->input('manufacturer_id')!='NC'))) {
            $update_array['manufacturer_id'] = $request->input('manufacturer_id');
        }
        if (($request->filled('category_id') && ($request->input('category_id')!='NC'))) {
            $update_array['category_id'] = $request->input('category_id');
        }
        if ($request->input('fieldset_id')!='NC') {
            $update_array['fieldset_id'] = $request->input('fieldset_id');
        }
        if ($request->input('depreciation_id')!='NC') {
            $update_array['depreciation_id'] = $request->input('depreciation_id');
        }


        
        if (count($update_array) > 0) {
            AssetModel::whereIn('id', $models_raw_array)->update($update_array);
            return redirect()->route('models.index')
                ->with('success', trans('admin/models/message.bulkedit.success'));
        }

        return redirect()->route('models.index')
            ->with('warning', trans('admin/models/message.bulkedit.error'));

    }

    /**
     * Validate and delete the given Asset Models. An Asset Model
     * cannot be deleted if there are associated assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return Redirect
     */
    public function destroy()
    {
        $models_raw_array = Input::get('ids');

        if ((is_array($models_raw_array)) && (count($models_raw_array) > 0)) {

            $models = AssetModel::whereIn('id', $models_raw_array)->withCount('assets as assets_count')->get();

            $del_error_count = 0;
            $del_count = 0;

            foreach ($models as $model) {
                if ($model->assets_count > 0) {
                    $del_error_count++;
                } else {
                    $model->delete();
                    $del_count++;
                }
            }

            if ($del_error_count == 0) {
                return redirect()->route('models.index')
                    ->with('success', trans('admin/models/message.bulkdelete.success',['success_count'=> $del_count] ));
            }

            return redirect()->route('models.index')
                ->with('warning', trans('admin/models/message.bulkdelete.success_partial', ['fail_count'=>$del_error_count, 'success_count'=> $del_count]));
        }

        return redirect()->route('models.index')
            ->with('error', trans('admin/models/message.bulkdelete.error'));

    }
  
  
     /**
     * Show Bulk Checkin Page
     * @return View View to checkout multiple assets
     */
    public function showCheckin()
    {
        $this->authorize('checkin', Asset::class);
        // Filter out assets that are not checked out.

        return view('hardware/bulk-checkin');
    }

  
  
  
  
     /**
     * Process Multiple Checkin Request
     * @return View
     */
    public function storeCheckin(Request $request)
    {
        try {
            $admin = Auth::user();

            $target = $this->determineCheckinTarget();

            if (!is_array($request->get('selected_assets'))) {
                return redirect()->route('hardware/bulkcheckin')->withInput()->with('error', trans('admin/hardware/message.checkout.no_assets_selected'));
            }

            $asset_ids = array_filter($request->get('selected_assets'));

            $checkin_at = date("Y-m-d H:i:s");
            if (($request->filled('checkin_at')) && ($request->get('checkin_at')!= date("Y-m-d"))) {
                $checkin_at = e($request->get('checkin_at'));
            }

            
            $errors = [];
            DB::transaction(function () use ($target, $admin, $checkin_at, $errors, $asset_ids, $request) {

                foreach ($asset_ids as $asset_id) {
                    $asset = Asset::findOrFail($asset_id);
                    $this->authorize('checkin', $asset);
                    $error = $asset->checkIn($target, $admin, $checkin_at, e($request->get('note')), null);

                    
                        //$asset->location_id = $target->location_id;
                        //$asset->unsetEventDispatcher();
                        $asset->save();
                    

                    if ($error) {
                        array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
            });

            if (!$errors) {
              // Redirect to the new asset page
                return redirect()->to("hardware")->with('success', trans('admin/hardware/message.checkin.success'));
            }
            // Redirect to the asset management page with error
            return redirect()->to("hardware/bulk-checkin")->with('error', trans('admin/hardware/message.checkin.error'))->withErrors($errors);
        } catch (ModelNotFoundException $e) {
            return redirect()->to("hardware/bulk-checkin")->with('error', $e->getErrors());
        }
    }


}
