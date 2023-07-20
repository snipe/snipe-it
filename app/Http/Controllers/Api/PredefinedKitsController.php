<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\PredefinedKitsTransformer;
use App\Models\PredefinedKit;
use Illuminate\Http\Request;

/**
 *  @author [D. Minaev.] [<dmitriy.minaev.v@gmail.com>]
 */
class PredefinedKitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', PredefinedKit::class);
        $allowed_columns = ['id', 'name'];

        $kits = PredefinedKit::query();

        if ($request->filled('search')) {
            $kits = $kits->TextSearch($request->input('search'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $kits->count()) ? $kits->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'desc' ? 'desc' : 'asc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'name';
        $kits->orderBy($sort, $order);

        $total = $kits->count();
        $kits = $kits->skip($offset)->take($limit)->get();

        return (new PredefinedKitsTransformer)->transformPredefinedKits($kits, $total);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', PredefinedKit::class);
        $kit = new PredefinedKit;
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.create_success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        return (new PredefinedKitsTransformer)->transformPredefinedKit($kit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id kit id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.update_success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        // Delete childs
        $kit->models()->detach();
        $kit->licenses()->detach();
        $kit->consumables()->detach();
        $kit->accessories()->detach();

        $kit->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/kits/general.delete_success')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {
        $kits = PredefinedKit::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $kits = $kits->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $kits = $kits->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($kits);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indexLicenses($kit_id)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $licenses = $kit->licenses;

        return (new PredefinedKitsTransformer)->transformElements($licenses, $licenses->count());
    }

    /**
     * Store the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeLicense(Request $request, $kit_id)
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $license_id = $request->get('license');
        $relation = $kit->licenses();
        if ($relation->find($license_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['license' => trans('admin/kits/general.license_error')]));
        }

        $relation->attach($license_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_added_success')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function updateLicense(Request $request, $kit_id, $license_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->licenses()->syncWithoutDetaching([$license_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_updated')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function detachLicense($kit_id, $license_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->licenses()->detach($license_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.delete_success')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function indexModels($kit_id)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $models = $kit->models;

        return (new PredefinedKitsTransformer)->transformElements($models, $models->count());
    }

    /**
     * Store the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeModel(Request $request, $kit_id)
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);

        $model_id = $request->get('model');
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $relation = $kit->models();
        if ($relation->find($model_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['model' => 'Model already attached to kit']));
        }
        $relation->attach($model_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, 'Model added successfull'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function updateModel(Request $request, $kit_id, $model_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->models()->syncWithoutDetaching([$model_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_updated')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function detachModel($kit_id, $model_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->models()->detach($model_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.model_removed_success')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function indexConsumables($kit_id)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $consumables = $kit->consumables;

        return (new PredefinedKitsTransformer)->transformElements($consumables, $consumables->count());
    }

    /**
     * Store the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeConsumable(Request $request, $kit_id)
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $consumable_id = $request->get('consumable');
        $relation = $kit->consumables();
        if ($relation->find($consumable_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['consumable' => trans('admin/kits/general.consumable_error')]));
        }

        $relation->attach($consumable_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_added_success')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function updateConsumable(Request $request, $kit_id, $consumable_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->consumables()->syncWithoutDetaching([$consumable_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_updated')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function detachConsumable($kit_id, $consumable_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->consumables()->detach($consumable_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_deleted')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function indexAccessories($kit_id)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $accessories = $kit->accessories;

        return (new PredefinedKitsTransformer)->transformElements($accessories, $accessories->count());
    }

    /**
     * Store the specified resource.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function storeAccessory(Request $request, $kit_id)
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $accessory_id = $request->get('accessory');
        $relation = $kit->accessories();
        if ($relation->find($accessory_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['accessory' => trans('admin/kits/general.accessory_error')]));
        }

        $relation->attach($accessory_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_added_success')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function updateAccessory(Request $request, $kit_id, $accessory_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->accessories()->syncWithoutDetaching([$accessory_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_updated')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function detachAccessory($kit_id, $accessory_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->accessories()->detach($accessory_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_deleted')));
    }
}
