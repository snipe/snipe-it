<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ManufacturersTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;

class ManufacturersController extends Controller
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
        $this->authorize('view', Manufacturer::class);
        $allowed_columns = ['id', 'name', 'url', 'support_url', 'support_email', 'support_phone', 'created_at', 'updated_at', 'image', 'assets_count', 'consumables_count', 'components_count', 'licenses_count'];

        $manufacturers = Manufacturer::select(
            ['id', 'name', 'url', 'support_url', 'support_email', 'support_phone', 'created_at', 'updated_at', 'image', 'deleted_at']
        )->withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count');

        if ($request->input('deleted') == 'true') {
            $manufacturers->onlyTrashed();
        }

        if ($request->filled('search')) {
            $manufacturers = $manufacturers->TextSearch($request->input('search'));
        }

        if ($request->filled('name')) {
            $manufacturers->where('name', '=', $request->input('name'));
        }

        if ($request->filled('url')) {
            $manufacturers->where('url', '=', $request->input('url'));
        }

        if ($request->filled('support_url')) {
            $manufacturers->where('support_url', '=', $request->input('support_url'));
        }

        if ($request->filled('support_phone')) {
            $manufacturers->where('support_phone', '=', $request->input('support_phone'));
        }

        if ($request->filled('support_email')) {
            $manufacturers->where('support_email', '=', $request->input('support_email'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($manufacturers) && ($request->get('offset') > $manufacturers->count())) ? $manufacturers->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $manufacturers->orderBy($sort, $order);

        $total = $manufacturers->count();
        $manufacturers = $manufacturers->skip($offset)->take($limit)->get();

        return (new ManufacturersTransformer)->transformManufacturers($manufacturers, $total);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Manufacturer::class);
        $manufacturer = new Manufacturer;
        $manufacturer->fill($request->all());
        $manufacturer = $request->handleImages($manufacturer);

        if ($manufacturer->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $manufacturer, trans('admin/manufacturers/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $manufacturer->getErrors()));

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
        $this->authorize('view', Manufacturer::class);
        $manufacturer = Manufacturer::withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count')->findOrFail($id);

        return (new ManufacturersTransformer)->transformManufacturer($manufacturer);
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
        $this->authorize('update', Manufacturer::class);
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->fill($request->all());
        $manufacturer = $request->handleImages($manufacturer);

        if ($manufacturer->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $manufacturer, trans('admin/manufacturers/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $manufacturer->getErrors()));
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
        $this->authorize('delete', Manufacturer::class);
        $manufacturer = Manufacturer::findOrFail($id);
        $this->authorize('delete', $manufacturer);

        if ($manufacturer->isDeletable()) {
            $manufacturer->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/manufacturers/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/manufacturers/message.assoc_users')));

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
        $manufacturers = Manufacturer::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $manufacturers = $manufacturers->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $manufacturers = $manufacturers->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($manufacturers as $manufacturer) {
            $manufacturer->use_text = $manufacturer->name;
            $manufacturer->use_image = ($manufacturer->image) ? Storage::disk('public')->url('manufacturers/'.$manufacturer->image, $manufacturer->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($manufacturers);
    }
}
