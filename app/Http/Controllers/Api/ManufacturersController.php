<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Manufacturer;

class ManufacturersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Manufacturer::class);
        $manufacturers = Manufacturer::all();
        return $manufacturers;
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
        return $manufacturer;
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
}
