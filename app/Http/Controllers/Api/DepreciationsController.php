<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Depreciation;
use App\Http\Transformers\DepreciationsTransformer;

class DepreciationsController extends Controller
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
        $this->authorize('view', Depreciation::class);
        $allowed_columns = ['id','name','created_at'];

        $depreciations = Depreciation::select('id','name','months','user_id','created_at','updated_at');

        if ($request->has('search')) {
            $depreciations = $depreciations->TextSearch($request->input('search'));
        }

        $offset = (($depreciations) && (request('offset') > $depreciations->count())) ? 0 : request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $depreciations->orderBy($sort, $order);

        $total = $depreciations->count();
        $depreciations = $depreciations->skip($offset)->take($limit)->get();
        return (new DepreciationsTransformer)->transformDepreciations($depreciations, $total);
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
        $this->authorize('create', Depreciation::class);
        $depreciation = new Depreciation;
        $depreciation->fill($request->all());

        if ($depreciation->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $depreciation, trans('admin/depreciations/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $depreciation->getErrors()));

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
        $this->authorize('view', Depreciation::class);
        $depreciation = Depreciation::findOrFail($id);
        return (new DepreciationsTransformer)->transformDepreciation($depreciation);
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
        $this->authorize('update', Depreciation::class);
        $depreciation = Depreciation::findOrFail($id);
        $depreciation->fill($request->all());

        if ($depreciation->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $depreciation, trans('admin/depreciations/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $depreciation->getErrors()));
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
        $this->authorize('delete', Depreciation::class);
        $depreciation = Depreciation::findOrFail($id);
        $this->authorize('delete', $depreciation);

        if ($depreciation->has_models() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', trans('admin/depreciations/message.assoc_users')));
        }

        $depreciation->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/depreciations/message.delete.success')));

    }



}
