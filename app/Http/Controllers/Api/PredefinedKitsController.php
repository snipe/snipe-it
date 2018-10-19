<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\PredefinedKit;
use App\Http\Transformers\PredefinedKitsTransformer;

class PredefinedKitsController extends Controller
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
        $this->authorize('view', PredefinedKit::class);
        $allowed_columns = ['id', 'name'];

        $kits = PredefinedKit::query();

        if ($request->filled('search')) {
            $kits = $kits->TextSearch($request->input('search'));
        }

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'assets_count';
        $kits->orderBy($sort, $order);

        $total = $kits->count();
        $kits = $kits->skip($offset)->take($limit)->get();
        return (new PredefinedKitsTransformer)->transformPrdefinedKits($kits, $total);

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
        $this->authorize('create', PredefinedKit::class);
        $kit = new PredefinedKit;
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, 'Created was successfull'));     // TODO: trans
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));

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
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);
        return (new PredefinedKitsTransformer)->transformPrdefinedKit($kit);
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
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, 'Update was successfull'));      // TODO: trans
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));
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
        $this->authorize('delete', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        $kit->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  'Delete was successfull'));     // TODO: trans

    }


    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $kits = PredefinedKit::select([
            'id',
            'name'
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
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indexLicenses($kit_id) {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $licenses = $kit->licenses;
        return (new PredefinedKitsTransformer)->transformElements($licenses, $licenses->count());
    }

    
    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function storeLicense(Request $request, $kit_id)
     {
         $this->authorize('update', PredefinedKit::class);
         
         $kit = PredefinedKit::findOrFail($kit_id);        
         $quantity = $request->input('quantity', 1);
         if( $quantity < 1) {
             $quantity = 1;
         }
         $kit->licenses()->attach( $request->get('license'), ['quantity' => $quantity]);
 
         return response()->json(Helper::formatStandardApiResponse('success', $kit, 'License added successfull'));     // TODO: trans
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
     public function updateLicense(Request $request, $kit_id, $license_id)
     {
         $this->authorize('update', PredefinedKit::class);
         $kit = PredefinedKit::findOrFail($id);
         $quantity = $request->input('quantity', 1);
         if( $quantity < 1) {
             $quantity = 1;
         }
         $kit->licenses()->sync([$license_id => ['quantity' =>  $quantity]]);
 
         return response()->json(Helper::formatStandardApiResponse('success', null, 'License updated'));  // TODO: trans
     }

     /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function destroyLicense($kit_id, $license_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        $kit->licenses()->detach($license_id);
        return response()->json(Helper::formatStandardApiResponse('success', null,  'Delete was successfull'));     // TODO: trans
    }
    
    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function indexModels($kit_id) {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $models = $kit->models;
        return (new PredefinedKitsTransformer)->transformElements($models, $models->count());
    }
    
    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function storeModel(Request $request, $kit_id)
     {
         $this->authorize('update', PredefinedKit::class);
         
         $kit = PredefinedKit::findOrFail($kit_id);        
         $quantity = $request->input('quantity', 1);
         if( $quantity < 1) {
             $quantity = 1;
         }
         $kit->models()->attach( $request->get('model'), ['quantity' => $quantity]);
 
         return response()->json(Helper::formatStandardApiResponse('success', $kit, 'License added successfull'));     // TODO: trans
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
     public function updateModel(Request $request, $kit_id, $model_id)
     {
         $this->authorize('update', PredefinedKit::class);
         $kit = PredefinedKit::findOrFail($id);
         $quantity = $request->input('quantity', 1);
         if( $quantity < 1) {
             $quantity = 1;
         }
         $kit->models()->sync([$model_id => ['quantity' =>  $quantity]]);
 
         return response()->json(Helper::formatStandardApiResponse('success', null, 'License updated'));  // TODO: trans
     }

     /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $kit_id
     * @return \Illuminate\Http\Response
     */
    public function destroyModel($kit_id, $model_id)
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        $kit->models()->detach($model_id);
        return response()->json(Helper::formatStandardApiResponse('success', null,  'Delete was successfull'));     // TODO: trans
    }
}
