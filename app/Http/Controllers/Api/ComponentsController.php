<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\ComponentsTransformer;
use App\Http\Transformers\ComponentsAssetsTransformer;
use App\Models\Component;
use App\Models\Company;
use App\Helpers\Helper;

class ComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Component::class);
        $components = Company::scopeCompanyables(Component::select('components.*')->whereNull('components.deleted_at')
            ->with('company', 'location', 'category'));

        if ($request->has('search')) {
            $components = $components->TextSearch($request->input('search'));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name','min_amt','order_number','serial','purchase_date','purchase_cost','company','category','qty','location','image'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        switch ($sort) {
            case 'category':
                $components = $components->OrderCategory($order);
                break;
            case 'location':
                $components = $components->OrderLocation($order);
                break;
            case 'company':
                $components = $components->OrderCompany($order);
                break;
            default:
                $components = $components->orderBy($sort, $order);
                break;
        }

        $total = $components->count();
        $components = $components->skip($offset)->take($limit)->get();
        return (new ComponentsTransformer)->transformComponents($components, $total);
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
        $this->authorize('create', Component::class);
        $component = new Component;
        $component->fill($request->all());

        if ($component->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $component, trans('admin/components/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $component->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Component::class);
        $component = Component::find($id);

        if ($component) {
            return (new ComponentsTransformer)->transformComponent($component);
        }
        
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/components/message.does_not_exist')));
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
        $this->authorize('edit', Component::class);
        $component = Component::findOrFail($id);
        $component->fill($request->all());

        if ($component->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $component, trans('admin/components/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $component->getErrors()));
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
        $this->authorize('delete', Component::class);
        $component = Component::findOrFail($id);
        $this->authorize('delete', $component);
        $component->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/components/message.delete.success')));
    }

    /**
     * Display all assets attached to a component
     *
     * @author [A. Bergamasco] [@vjandrea]
     * @since [v4.0]
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function getAssets(Request $request, $id)
    {
        $this->authorize('index', Asset::class);
        
        $component = Component::findOrFail($id);
        $assets = $component->assets();

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();
        return (new ComponentsTransformer)->transformCheckedoutComponents($assets, $total);
    }
}
