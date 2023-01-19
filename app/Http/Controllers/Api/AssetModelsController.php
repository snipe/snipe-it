<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AssetModelsTransformer;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Asset;
use App\Models\AssetModel;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;

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
        $allowed_columns =
            [
                'id',
                'image',
                'name',
                'model_number',
                'eol',
                'notes',
                'created_at',
                'manufacturer',
                'requestable',
                'assets_count',
                'category',
            ];

        $assetmodels = AssetModel::select([
            'models.id',
            'models.image',
            'models.name',
            'model_number',
            'eol',
            'requestable',
            'models.notes',
            'models.created_at',
            'category_id',
            'manufacturer_id',
            'depreciation_id',
            'fieldset_id',
            'models.deleted_at',
            'models.updated_at',
         ])
            ->with('category', 'depreciation', 'manufacturer', 'fieldset')
            ->withCount('assets as assets_count');

        if ($request->input('status')=='deleted') {
            $assetmodels->onlyTrashed();
        }

        if ($request->filled('category_id')) {
            $assetmodels = $assetmodels->where('models.category_id', '=', $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $assetmodels->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($assetmodels) && ($request->get('offset') > $assetmodels->count())) ? $assetmodels->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'models.created_at';

        switch ($sort) {
            case 'manufacturer':
                $assetmodels->OrderManufacturer($order);
                break;
            case 'category':
                $assetmodels->OrderCategory($order);
                break;
            default:
                $assetmodels->orderBy($sort, $order);
                break;
        }

        $total = $assetmodels->count();
        $assetmodels = $assetmodels->skip($offset)->take($limit)->get();

        return (new AssetModelsTransformer)->transformAssetModels($assetmodels, $total);
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
        $this->authorize('create', AssetModel::class);
        $assetmodel = new AssetModel;
        $assetmodel->fill($request->all());
        $assetmodel = $request->handleImages($assetmodel);

        if ($assetmodel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assetmodel, trans('admin/models/message.create.success')));
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
        $assetmodel = AssetModel::withCount('assets as assets_count')->findOrFail($id);

        return (new AssetModelsTransformer)->transformAssetModel($assetmodel);
    }

    /**
     * Display the specified resource's assets
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assets($id)
    {
        $this->authorize('view', AssetModel::class);
        $assets = Asset::where('model_id', '=', $id)->get();

        return (new AssetsTransformer)->transformAssets($assets, $assets->count());
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
        $this->authorize('update', AssetModel::class);
        $assetmodel = AssetModel::findOrFail($id);
        $assetmodel->fill($request->all());
        $assetmodel = $request->handleImages($assetmodel);
        
        /**
         * Allow custom_fieldset_id to override and populate fieldset_id.
         * This is stupid, but required for legacy API support.
         *
         * I have no idea why we manually overrode that field name
         * in previous versions. I assume there was a good reason for
         * it, but I'll be damned if I can think of one. - snipe
         */
        if ($request->filled('custom_fieldset_id')) {
            $assetmodel->fieldset_id = $request->get('custom_fieldset_id');
        }


        if ($assetmodel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assetmodel, trans('admin/models/message.update.success')));
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

        if ($assetmodel->assets()->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.assoc_users')));
        }

        if ($assetmodel->image) {
            try {
                Storage::disk('public')->delete('assetmodels/'.$assetmodel->image);
            } catch (\Exception $e) {
                \Log::info($e);
            }
        }

        $assetmodel->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/models/message.delete.success')));
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
        $assetmodels = AssetModel::select([
            'models.id',
            'models.name',
            'models.image',
            'models.model_number',
            'models.manufacturer_id',
            'models.category_id',
        ])->with('manufacturer', 'category');

        $settings = \App\Models\Setting::getSettings();

        if ($request->filled('search')) {
            $assetmodels = $assetmodels->SearchByManufacturerOrCat($request->input('search'));
        }

        $assetmodels = $assetmodels->OrderCategory('ASC')->OrderManufacturer('ASC')->orderby('models.name', 'asc')->orderby('models.model_number', 'asc')->paginate(50);

        foreach ($assetmodels as $assetmodel) {
            $assetmodel->use_text = '';

            if ($settings->modellistCheckedValue('category')) {
                $assetmodel->use_text .= (($assetmodel->category) ? $assetmodel->category->name.' - ' : '');
            }

            if ($settings->modellistCheckedValue('manufacturer')) {
                $assetmodel->use_text .= (($assetmodel->manufacturer) ? $assetmodel->manufacturer->name.' ' : '');
            }

            $assetmodel->use_text .= $assetmodel->name;

            if (($settings->modellistCheckedValue('model_number')) && ($assetmodel->model_number != '')) {
                $assetmodel->use_text .= ' (#'.$assetmodel->model_number.')';
            }

            $assetmodel->use_image = ($settings->modellistCheckedValue('image') && ($assetmodel->image)) ? Storage::disk('public')->url('models/'.e($assetmodel->image)) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($assetmodels);
    }
}
