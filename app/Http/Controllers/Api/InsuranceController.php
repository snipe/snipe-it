<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Insurance;
use App\Http\Transformers\DatatablesTransformer;
use App\Http\Transformers\InsuranceTransformer;
use App\Http\Transformers\SelectlistTransformer;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Insurance::class);
        $allowed_columns = ['id','name','started_at','ended_at','created_at','notes'];

        $insurance = Insurance::select(
            array('id','name','provider','policy_number','started_at','ended_at','created_at','notes','created_at'))->whereNotNull("name");
        //)->with('assets')->withCount('licenses')->withCount('consumables')->withCount('accessories');

        if ($request->input('deleted')=='true') {
            $insurance->onlyTrashed();
        }

        if ($request->has('search')) {
            $insurance = $insurance->TextSearch($request->input('search'));
        }

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $insurance->orderBy($sort, $order);

        $total = $insurance->count();
        $insurance = $insurance->skip($offset)->take($limit)->get();
        return (new InsuranceTransformer)->transformInsurances($insurance, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Insurance::class);
        $insurance = new Insurance;
        $insurance->fill($request->all());

        if ($insurance->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $insurance, trans('admin/insurance/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $insurance->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Insurance::class);
        $insurance = Insurance::findOrFail($id);
        return (new InsuranceTranspromer)->transformInsurance($insurance);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', Manufacturer::class);
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->fill($request->all());

        if ($manufacturer->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $manufacturer, trans('admin/manufacturers/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $manufacturer->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Insurance::class);
        $insurance = Insurance::findOrFail($id);
        $this->authorize('delete', $insurance);
        $insurance->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/insurance/message.delete.success')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $insurance = Insurance::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->has('search')) {
            $insurance = $insurance->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $insurance = $insurance->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($insurance as $ins) {
            $ins->use_text = $ins->name;
            $ins->use_image = ($ins->image) ? url('/').'/uploads/insurance/'.$ins->image : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($insurance);

    }
}
