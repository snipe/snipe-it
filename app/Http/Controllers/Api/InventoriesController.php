<?php
namespace App\Http\Controllers\Api;


use App\Http\Transformers\InventoriesTransformer;
use App\Http\Transformers\InventoryItemTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\UsersTransformer;
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
use Illuminate\Database\Eloquent\Builder;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->authorize('view', User::class);

        $inventories = Inventory::with('inventory_items','location')
            ->select([
                'inventories.id',
                'inventories.status',
                'inventories.name',
                'inventories.device',
                'inventories.responsible_id',
                'inventories.responsible',
                'inventories.responsible_photo',
                'inventories.coords',
                'inventories.log',
                'inventories.comment',
                'inventories.location_id',
                'inventories.created_at',
                'inventories.updated_at',
            ])
            ->withCount([
                'inventory_items as total',
                'inventory_items as checked' => function (Builder $query) {
                    $query->where('checked', true);
                },
            ])
            ;

        if ($request->filled('location_id')) {
            $inventories->where('inventories.location_id', '=', $request->input('location_id'));
        }

        if ($request->filled('bitrix_id')) {
            $location = Location::where('bitrix_id', $request->input('bitrix_id'))->first();
            if($location){
                $inventories->where('inventories.location_id', '=', $location->id);
            } else{
                return response()->json(Helper::formatStandardApiResponse('error', null ));
            }
        }

        if ($request->filled('search')) {
            $inventories = $inventories->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($inventories) && ($request->get('offset') > $inventories->count())) ? $inventories->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $total = $inventories->count();
        $inventories = $inventories->skip($offset)->take($limit)->get();
        return (new InventoriesTransformer)->transformInventories($inventories, $total);
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
//        $inventory = Inventory::findOrFail($id);

        $inventory = Inventory::with('inventory_items','location')
            ->select([
                'inventories.id',
                'inventories.status',
                'inventories.name',
                'inventories.device',
                'inventories.responsible_id',
                'inventories.responsible',
                'inventories.responsible_photo',
                'inventories.coords',
                'inventories.log',
                'inventories.comment',
                'inventories.location_id',
                'inventories.created_at',
                'inventories.updated_at',
            ])
            ->withCount([
                'inventory_items as total',
                'inventory_items as checked' => function (Builder $query) {
                    $query->where('checked', true);
                },
            ])
            ->findOrFail($id);

        return (new InventoriesTransformer)->transformInventory($inventory);
    }


    /**

     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $location = Location::where('bitrix_id',$data["bitrix_id"] )->firstOrFail();

        $assets = Company::scopeCompanyables(Asset::select('assets.*'),"company_id","assets")
            ->with('location', 'assetstatus', 'assetlog', 'company', 'defaultLoc','assignedTo',
                'model.category', 'model.manufacturer', 'model.fieldset','supplier');
        $assets->where('assets.location_id', '=', $location->id);
        $assets= $assets->get();
//        $this->authorize('create', Location::class);
        $inventory = new Inventory;
        $inventory->name = $location->name ."_".date("d.m.Y H:i:s");
        $inventory->location_id = $location->id;
        $inventory->fill($request->all());
        if ($inventory->save()) {
            foreach ($assets as &$asset) {
                $inventory_item = new InventoryItem;
                $inventory_item->asset_id = $asset->id;
                $inventory_item->name = $asset->name;
                $inventory_item->notes = $asset->notes;
                $inventory_item->model = $asset->model->name;
                $inventory_item->manufacturer = $asset->model->manufacturer->name;
                $inventory_item->category = $asset->model->category->name;
                $inventory_item->tag = $asset->asset_tag;
                $inventory_item->serial_number= $asset->serial;
                $inventory_item->inventory_id = $inventory->id;
                $inventory_item->save();
            }

            return response()->json(Helper::formatStandardApiResponse('success', (new InventoriesTransformer)->transformInventory($inventory,true), trans('admin/locations/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $inventory->getErrors()));
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
        $inventory = Inventory::findOrFail($id);
        $inventory->fill($request->all());


        if ($inventory->save()) {
            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    (new InventoriesTransformer)->transformInventory($inventory,true),
                    trans('admin/locations/message.update.success')
                )
            );
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $inventory->getErrors()));
    }

}