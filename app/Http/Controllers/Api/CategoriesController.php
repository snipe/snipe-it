<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\CategoriesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Facades\Log;

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

        $myArr = array();
        $userData = Auth::user()->isAdminofGroup();

        foreach($userData as $id => $group){
            array_push($myArr,$id);
        }

        $allowed_columns = ['id', 'name','category_type', 'category_type','use_default_eula','eula_text', 'require_acceptance','checkin_email', 'assets_count', 'accessories_count', 'consumables_count', 'components_count','licenses_count', 'image'];

        $categories = Category::select(['id', 'created_at', 'updated_at', 'name','category_type','use_default_eula','eula_text', 'require_acceptance','checkin_email','image']);

        if ($request->filled('search')) {
            $categories = $categories->TextSearch($request->input('search'));
        }

        if(Auth::user()->isSuperUser()){
           $categories = $categories->withCount('assets as assets_count', 'accessories as accessories_count', 'consumables as consumables_count', 'components as components_count','licenses as licenses_count');
        }else{
        //    $categories = $categories->with('assets','assets.groups')
        //    ->withCount([
        //             'assets as assets_count' => function ($query) use ($myArr) {
        //                 $query->whereIn('group_id', $myArr);
        //     }]);

        $categories = $categories->withCount(['assets as assets_count' => function ($query) use($myArr){

                $query->whereHas('groups', function($query1) use ($myArr){
                    $query1->whereIn('group_id', $myArr);
                });
            },
            'accessories as accessories_count' => function ($query) use($myArr){

                $query->whereHas('groups', function($query1) use ($myArr){
                    $query1->whereIn('group_id', $myArr);
                });
            },
            'consumables as consumables_count' => function ($query) use($myArr){

                $query->whereHas('groups', function($query1) use ($myArr){
                    $query1->whereIn('group_id', $myArr);
                });
            },
            'components as components_count' => function ($query) use($myArr){

                $query->whereHas('groups', function($query1) use ($myArr){
                    $query1->whereIn('group_id', $myArr);
                });
            },
            'licenses as licenses_count' => function ($query) use($myArr){

                $query->whereHas('groups', function($query1) use ($myArr){
                    $query1->whereIn('group_id', $myArr);
                });
            },
        ]);

            // $categories = $categories->with(['assets','assets.groups' => function($query) use($myArr){
            //     $query->whereIn('group_id', $myArr);
            // },
            // 'accessories','accessories.groups' => function($query) use($myArr){
            //     $query->whereIn('group_id', $myArr);
            // },
            // 'consumables','consumables.groups' => function($query) use($myArr){
            //     $query->whereIn('group_id', $myArr);
            // },
            // 'components','components.groups' => function($query) use($myArr){
            //     $query->whereIn('group_id', $myArr);
            // },
            // 'licenses','licenses.groups' => function($query) use($myArr){
            //     $query->whereIn('group_id', $myArr);
            // }
            // ])->withCount('assets as assets_count', 'accessories as accessories_count', 'consumables as consumables_count', 
            // 'components as components_count','licenses as licenses_count');
        }

        

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($categories) && ($request->get('offset') > $categories->count())) ? $categories->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

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
     * @param  \App\Http\Requests\ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Category::class);
        $category = new Category;
        $category->fill($request->all());
        $category->category_type = strtolower($request->input('category_type'));
        $category = $request->handleImages($category);

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
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageUploadRequest $request, $id)
    {
        $this->authorize('update', Category::class);
        $category = Category::findOrFail($id);
        $category->fill($request->all());
        $category->category_type = strtolower($request->input('category_type'));
        $category = $request->handleImages($category);

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

        if (! $category->isDeletable()) {
            return response()->json(
                Helper::formatStandardApiResponse('error', null, trans('admin/categories/message.assoc_items', ['asset_type'=>$category->category_type]))
            );
        }
        $category->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/categories/message.delete.success')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request, $category_type = 'asset')
    {
        $categories = Category::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $categories = $categories->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $categories = $categories->where('category_type', $category_type)->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($categories as $category) {
            $category->use_image = ($category->image) ? Storage::disk('public')->url('categories/'.$category->image, $category->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($categories);
    }
}
