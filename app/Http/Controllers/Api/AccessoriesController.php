<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Accessory;

class AccessoriesController extends Controller
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
        $this->authorize('view', Accessory::class);
        $accessories = Accessory::all();
        return $accessories;
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
        $this->authorize('create', Accessory::class);
        $accessory = new Accessory;
        $accessory->fill($request->all());

        if ($accessory->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $accessory, trans('admin/accessories/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $accessory->getErrors()));

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
        $this->authorize('view', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        return $accessory;
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
        $this->authorize('edit', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        $accessory->fill($request->all());

        if ($accessory->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $accessory, trans('admin/accessories/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $accessory->getErrors()));
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
        $this->authorize('delete', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        $this->authorize('delete', $accessory);
        $accessory->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/accessories/message.delete.success')));

    }
}
