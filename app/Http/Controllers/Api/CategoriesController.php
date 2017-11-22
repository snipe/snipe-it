<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Category;
use App\Http\Transformers\CategoriesTransformer;
use App\Http\Transformers\SelectlistTransformer;

class CategoriesController extends Controller
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
        $this->authorize('view', Category::class);
        $allowed_columns = ['id', 'name','category_type', 'category_type','use_default_eula','eula_text', 'require_acceptance','checkin_email', 'assets_count', 'accessories_count', 'consumables_count', 'components_count', 'image'];

        $categories = Category::select(['id', 'created_at', 'updated_at', 'name','category_type','use_default_eula','eula_text', 'require_acceptance','checkin_email','image'])
            ->withCount('assets', 'accessories', 'consumables', 'components');

        if ($request->has('search')) {
            $categories = $categories->TextSearch($request->input('search'));
        }

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'assets_count';
        $categories->orderBy($sort, $order);

        $total = $categories->count();
        $categories = $categories->skip($offset)->take($limit)->get();
        return (new CategoriesTransformer)->transformCategories($categories, $total);

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
        $this->authorize('create', Category::class);
        $category = new Category;
        $category->fill($request->all());

        if ($category->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $category, trans('admin/categories/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $category->getErrors()));

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
        $this->authorize('view', Category::class);
        $category = Category::findOrFail($id);
        return (new CategoriesTransformer)->transformCategory($category);

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
        $this->authorize('edit', Category::class);
        $category = Category::findOrFail($id);
        $category->fill($request->all());

        if ($category->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $category, trans('admin/categories/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $category->getErrors()));
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
        $this->authorize('delete', Category::class);
        $category = Category::findOrFail($id);

        if ($category->has_models() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/categories/message.assoc_items', ['asset_type'=>'model'])));
        } elseif ($category->accessories()->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/categories/message.assoc_items', ['asset_type'=>'accessory'])));
        } elseif ($category->consumables()->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/categories/message.assoc_items', ['asset_type'=>'consumable'])));
        } elseif ($category->components()->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/categories/message.assoc_items', ['asset_type'=>'component'])));
        }
        $category->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/categories/message.delete.success')));

    }


    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request, $category_type = 'asset')
    {

        $categories = Category::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->has('search')) {
            $categories = $categories->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $categories = $categories->where('category_type', $category_type)->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($categories as $category) {
            $category->use_image = ($category->image) ? url('/').'/uploads/categories/'.$category->image : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($categories);

    }

}
