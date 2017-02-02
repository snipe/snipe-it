<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Depreciation;
use App\Models\Asset;
use App\Http\Transformers\DatatablesTransformer;

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

        $depreciations = Depreciation::select('id','name','months');

        if ($request->has('search')) {
            $depreciations = $depreciations->TextSearch($request->input('search'));
        }

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $depreciations->orderBy($sort, $order);

        $total = $depreciations->count();
        $depreciations = $depreciations->skip($offset)->take($limit)->get();
        return (new DatatablesTransformer)->transformDatatables($depreciations, $total);
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
        return $depreciation;
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
        $this->authorize('edit', Depreciation::class);
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
        $depreciation->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/depreciations/message.delete.success')));

    }



    /**
     * Show a count of assets by status label for pie chart
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Http\Response
     */

    public function getAssetCountByDepreciation()
    {

        $statusLabels = Depreciation::with('assets')->get();
        $labels=[];
        $points=[];
        $colors=[];
        foreach ($statusLabels as $statusLabel) {
            if ($statusLabel->assets()->count() > 0) {
                $labels[]=$statusLabel->name;
                $points[]=$statusLabel->assets()->whereNull('assigned_to')->count();
                if ($statusLabel->color!='') {
                    $colors[]=$statusLabel->color;
                }
            }
        }
        $labels[]='Deployed';
        $points[]=Asset::whereNotNull('assigned_to')->count();

        $colors_array = array_merge($colors, Helper::chartColors());

        $result= [
            "labels" => $labels,
            "datasets" => [ [
                "data" => $points,
                "backgroundColor" => $colors_array,
                "hoverBackgroundColor" =>  $colors_array
            ]]
        ];
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assets(Request $request, $id)
    {
        $this->authorize('view', Depreciation::class);
        $this->authorize('index', Asset::class);
        $assets = Asset::where('status_id','=',$id);

        $allowed_columns = [
            'id',
            'name'
        ];

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $assets->orderBy($sort, $order);

        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();


        return (new AssetsTransformer)->transformAssets($assets, $total);
    }


    /**
     * Returns a boolean response based on whether the status label
     * is one that is deployable.
     *
     * This is used by the hardware create/edit view to determine whether
     * we should provide a dropdown of users for them to check the asset out to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return Bool
     */
    public function checkIfDeployable($id) {
        $depreciation = Depreciation::findOrFail($id);
        if ($depreciation->getDepreciationType()=='deployable') {
            return '1';
        }

        return '0';
    }
}
