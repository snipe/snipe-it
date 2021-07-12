<?php

namespace App\Http\Controllers\Consumables;

use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BulkConsumablesController extends Controller
{
    use CheckInOutRequest;

    /**
     * Display the bulk edit page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @return View
     * @internal param int $assetId
     * @since [v2.0]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request)
    {
        $this->authorize('update', Consumable::class);

        if (!$request->filled('ids')) {
            return redirect()->back()->with('error', 'No assets selected');
        }

        $consumable_ids = array_keys($request->input('ids'));

        if ($request->filled('bulk_actions')) {
            switch($request->input('bulk_actions')) {
                case 'labels':
                    return view('consumables/labels')
                        ->with('consumables', Consumable::find($consumable_ids))
                        ->with('settings', Setting::getSettings())
                        ->with('bulkedit', true)
                        ->with('count', 0);
                case 'delete':
                    $consumables = Consumable::find($consumable_ids);
                    $consumables->each(function ($consumable) {
                        $this->authorize('delete', $consumable);
                    });
                    return view('consumables/bulk-delete')->with('consumables', $consumables);
                case 'edit':
                    return view('consumables/bulk')
                        ->with('consumables', request('ids'));
            }
        }
        return redirect()->back()->with('error', 'No action selected');
    }

    /**
     * Save bulk edits
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @return Redirect
     * @internal param array $assets
     * @since [v2.0]
     */
    public function update(Request $request)
    {
        $this->authorize('update', Consumable::class);
        \Log::debug($request->input('ids'));

        if(!$request->filled('ids') || count($request->input('ids')) <= 0) {
            return redirect()->route("consumables.index")->with('warning', trans('No consumables selected, so nothing was updated.')); //TODO: trans
        }

        $consumables = array_keys($request->input('ids'));

        if (($request->filled('purchase_date'))
            || ($request->filled('purchase_cost'))
            || ($request->filled('category_id'))
            || ($request->filled('order_number'))
            || ($request->filled('location_id'))
            || ($request->filled('qty'))
            || ($request->filled('company_id'))
            || ($request->filled('manufacturer_id'))
            || ($request->filled('min_amt'))
            || ($request->filled('model_number'))
        ) {
            foreach ($consumables as $consumableId) {
                $this->update_array = [];

                $this->conditionallyAddItem('purchase_date')
                    ->conditionallyAddItem('purchase_cost')
                    ->conditionallyAddItem('order_number')
                    ->conditionallyAddItem('requestable')
                    ->conditionallyAddItem('status_id')
                    ->conditionallyAddItem('supplier_id')
                    ->conditionallyAddItem('category_id')
                    ->conditionallyAddItem('manufacturer_id')
                    ->conditionallyAddItem('qty')
                    ->conditionallyAddItem('min_amt')
                    ->conditionallyAddItem('warranty_months');

                if ($request->filled('purchase_cost')) {
                    $this->update_array['purchase_cost'] =  Helper::ParseFloat($request->input('purchase_cost'));
                }

                if ($request->filled('company_id')) {
                    $this->update_array['company_id'] =  $request->input('company_id');
                    if ($request->input('company_id')=="clear") {
                        $this->update_array['company_id'] = null;
                    }
                }
                
                if ($request->filled('qty')) {
                    $this->update_array['qty'] = $request->input('qty');
                }
                
                if ($request->filled('min_amt')) {
                    $this->update_array['min_amt'] = $request->input('min_amt');
                }
                
                if ($request->filled('category_id')) {
                    $this->update_array['category_id'] = $request->input('category_id');
                }

                if ($request->filled('location_id')) {
                    $this->update_array['location_id'] = $request->input('location_id');
                }
                
                if ($request->filled('manufacturer_id')) {
                    $this->update_array['manufacturer_id'] = $request->input('manufacturer_id');
                }
                
                \Log::debug(implode(", ", $this->update_array));
                \Log::debug(implode(", ", array_keys($this->update_array)));
                DB::table('consumables')
                    ->where('id', $consumableId)
                    ->update($this->update_array);
            } // endforeach
            return redirect()->route("consumables.index")->with('success', trans('admin/consumables/message.update.success'));
        // no values given, nothing to update
        }
        return redirect()->route("consumables.index")->with('warning', trans('admin/consumables/message.update.nothing_updated'));

    }

    /**
     * Array to store update data per item
     * @var Array
     */
    private $update_array;

    /**
     * Adds parameter to update array for an item if it exists in request
     * @param  String $field field name
     * @return BulkAssetsController Model for Chaining
     */
    protected function conditionallyAddItem($field)
    {
        if(request()->filled($field)) {
            $this->update_array[$field] = request()->input($field);
        }
        return $this;
    }

    /**
     * Save bulk deleted.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @internal param array $assets
     * @since [v2.0]
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Consumable::class);

        if ($request->filled('ids')) {
            $consumables = Consumable::find($request->get('ids'));
            foreach ($consumables as $consumable) {
                $update_array['deleted_at'] = date('Y-m-d H:i:s');

                DB::table('consumables')
                    ->where('id', $consumable->id)
                    ->update($update_array);
            } // endforeach
            return redirect()->to("consumables")->with('success', trans('admin/consumables/message.delete.success'));
            // no values given, nothing to update
        }
        return redirect()->to("consumables")->with('info', trans('admin/consumables/message.delete.nothing_updated'));
    }
}
