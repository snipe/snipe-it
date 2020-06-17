<?php
namespace App\Http\Controllers\Api;


use App\Http\Transformers\InventoriesTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\InventoryItemTransformer;
use App\Models\Company;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Helpers\Helper;
use App\Http\Requests\SaveUserRequest;
use App\Models\Asset;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\AccessoriesTransformer;
use App\Http\Transformers\LicensesTransformer;
use Auth;
use App\Models\AssetModel;

class InventoryItemController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->authorize('view', User::class);

        $inventory_items = InventoryItem::with('asset','inventory')
            ->select([
                'inventory_items.id',
                'inventory_items.notes',
                'inventory_items.name',
                'inventory_items.model',
                'inventory_items.category',
                'inventory_items.manufacturer',
                'inventory_items.serial_number',
                'inventory_items.tag',
                'inventory_items.photo',
                'inventory_items.checked',
                'inventory_items.broken',
                'inventory_items.checked_at',
                'inventory_items.inventory_id',
                'inventory_items.asset_id',
                'inventory_items.created_at',
                'inventory_items.updated_at',
                'inventory_items.deleted_at',
            ]);

        if ($request->filled('inventory_id')) {
            $inventory_items->where('inventory_items.inventory_id', '=', $request->input('inventory_id'));
        }


        if ($request->filled('search')) {
            $inventory_items = $inventory_items->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($inventory_items) && ($request->get('offset') > $inventory_items->count())) ? $inventory_items->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $total = $inventory_items->count();
        $inventory_items = $inventory_items->skip($offset)->take($limit)->get();

        return (new InventoryItemTransformer)->transformInventoryItemsvsAsset($inventory_items, $total);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $this->authorize('view', Location::class);
        $inventory_item = InventoryItem::findOrFail($id);
        return (new InventoryItemTransformer)->transformInventoryItem($inventory_item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->authorize('update', Location::class);
        $inventory_item = InventoryItem::findOrFail($id);

        $inventory_item->fill($request->all());


        if ($inventory_item->save()) {
            if ($inventory_item->checked == true){
                $asset = $inventory_item->asset;
                $asset->last_audit_date = date('Y-m-d h:i:s');
                $asset->save();
            }

            /** @var Inventory $inventory */
            $inventory  = $inventory_item->inventory;
            $inventory_items = $inventory->inventory_items;
            $finished = true;
            foreach ($inventory_items as $item) {
                /** @var InventoryItem $item */
                if  ($item->checked == false){
                    $finished = false;
                    break;
                }
            }
            if ($finished){
                $inventory->status = "FINISH_OK";
                $inventory->save();
            }


            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    (new InventoryItemTransformer)->transformInventoryItem($inventory_item),
                    trans('admin/locations/message.update.success')
                )
            );
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $inventory_item->getErrors()));
    }
}