<?php
namespace App\Http\Controllers\Api;

use App\Models\AssetModel;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Transformers\AssetModelsTransformer;

/**
 * This class controls all actions related to asset models for
 * the Snipe-IT Asset Management application.
 *
 * @version    v4.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetModelsController extends Controller
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
        $this->authorize('view', AssetModel::class);
        $allowed_columns = ['id','image','name','model_number','eol','notes','created_at'];

        $assetmodels = AssetModel::select(['id','image','name','model_number','eol','notes','created_at','category_id','manufacturer_id','depreciation_id','fieldset_id'])
            ->with('category','depreciation', 'manufacturer','fieldset')
            ->withCount('assets');

        if ($request->has('search')) {
            $assetmodels = $assetmodels->TextSearch($request->input('search'));
        }

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $assetmodels->orderBy($sort, $order);

        $total = $assetmodels->count();
        $assetmodels = $assetmodels->skip($offset)->take($limit)->get();
        return (new AssetModelsTransformer)->transformAssetModels($assetmodels, $total);
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
        $this->authorize('create', AssetModel::class);
        $assetmodel = new AssetModel;
        $assetmodel->fill($request->all());

        if ($assetmodel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assetmodel, trans('admin/assetmodels/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $assetmodel->getErrors()));

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
        $this->authorize('view', AssetModel::class);
        $assetmodel = AssetModel::findOrFail($id);
        return (new AssetModelsTransformer)->transformAssetModel($assetmodel);
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
        $this->authorize('edit', AssetModel::class);
        $assetmodel = AssetModel::findOrFail($id);
        $assetmodel->fill($request->all());

        if ($assetmodel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assetmodel, trans('admin/assetmodels/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $assetmodel->getErrors()));
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
        $this->authorize('delete', AssetModel::class);
        $assetmodel = AssetModel::findOrFail($id);
        $this->authorize('delete', $assetmodel);
        $assetmodel->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/assetmodels/message.delete.success')));

    }
}
