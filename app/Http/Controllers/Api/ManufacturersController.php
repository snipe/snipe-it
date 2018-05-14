<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Manufacturer;
use App\Http\Transformers\DatatablesTransformer;
use App\Http\Transformers\ManufacturersTransformer;
use App\Http\Transformers\SelectlistTransformer;

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
        $allowed_columns = ['id','name','url','support_url','support_email','support_phone','created_at','updated_at','image', 'assets_count', 'consumables_count', 'components_count', 'licenses_count'];

        $manufacturers = Manufacturer::select(
            array('id','name','url','support_url','support_email','support_phone','created_at','updated_at','image', 'deleted_at')
        )->withCount('assets')->withCount('licenses')->withCount('consumables')->withCount('accessories');

        if ($request->input('deleted')=='true') {
            $manufacturers->onlyTrashed();
        }

        if ($request->has('search')) {
            $manufacturers = $manufacturers->TextSearch($request->input('search'));
        }




        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Manufacturer::class);
        $manufacturer = new Manufacturer;
        $manufacturer->fill($request->all());

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
        $manufacturer = Manufacturer::findOrFail($id);
        return (new ManufacturersTransformer)->transformManufacturer($manufacturer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', Manufacturer::class);
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->fill($request->all());

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
        $manufacturer->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/manufacturers/message.delete.success')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $manufacturers = Manufacturer::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->has('search')) {
            $manufacturers = $manufacturers->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $manufacturers = $manufacturers->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($manufacturers as $manufacturer) {
            $manufacturer->use_text = $manufacturer->name;
            $manufacturer->use_image = ($manufacturer->image) ? url('/').'/uploads/manufacturers/'.$manufacturer->image : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($manufacturers);

    }
}
