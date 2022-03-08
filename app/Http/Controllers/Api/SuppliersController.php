<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\SuppliersTransformer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Supplier::class);
        $allowed_columns = ['id', 'name', 'address', 'phone', 'contact', 'fax', 'email', 'image', 'assets_count', 'licenses_count', 'accessories_count', 'url'];
        
        $suppliers = Supplier::select(
                ['id', 'name', 'address', 'address2', 'city', 'state', 'country', 'fax', 'phone', 'email', 'contact', 'created_at', 'updated_at', 'deleted_at', 'image', 'notes']
            )->withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('accessories as accessories_count');


        if ($request->filled('search')) {
            $suppliers = $suppliers->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($suppliers) && ($request->get('offset') > $suppliers->count())) ? $suppliers->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $suppliers->orderBy($sort, $order);

        $total = $suppliers->count();
        $suppliers = $suppliers->skip($offset)->take($limit)->get();

        return (new SuppliersTransformer)->transformSuppliers($suppliers, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Supplier::class);
        $supplier = new Supplier;
        $supplier->fill($request->all());
        $supplier = $request->handleImages($supplier);

        if ($supplier->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $supplier, trans('admin/suppliers/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $supplier->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Supplier::class);
        $supplier = Supplier::findOrFail($id);

        return (new SuppliersTransformer)->transformSupplier($supplier);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageUploadRequest $request, $id)
    {
        $this->authorize('update', Supplier::class);
        $supplier = Supplier::findOrFail($id);
        $supplier->fill($request->all());
        $supplier = $request->handleImages($supplier);

        if ($supplier->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $supplier, trans('admin/suppliers/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $supplier->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Supplier::class);
        $supplier = Supplier::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count', 'assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $supplier);


        if ($supplier->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/suppliers/message.delete.assoc_assets', ['asset_count' => (int) $supplier->assets_count])));
        }

        if ($supplier->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/suppliers/message.delete.assoc_maintenances', ['asset_maintenances_count' => $supplier->asset_maintenances_count])));
        }

        if ($supplier->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/suppliers/message.delete.assoc_licenses', ['licenses_count' => (int) $supplier->licenses_count])));
        }

        $supplier->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/suppliers/message.delete.success')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {

        $this->authorize('view.selectlists');

        $suppliers = Supplier::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $suppliers = $suppliers->where('suppliers.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $suppliers = $suppliers->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($suppliers as $supplier) {
            $supplier->use_text = $supplier->name;
            $supplier->use_image = ($supplier->image) ? Storage::disk('public')->url('suppliers/'.$supplier->image, $supplier->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($suppliers);
    }
}
