<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\DatatablesTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Company;

class CompaniesController extends Controller
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
        $this->authorize('view', Company::class);

        $allowed_columns = ['id','name'];

        $companies = Company::withCount('assets','licenses','accessories','consumables','components','users');

        if ($request->has('search')) {
            $companies->TextSearch($request->input('search'));
        }

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $companies->orderBy($sort, $order);

        $total = $companies->count();
        $companies = $companies->skip($offset)->take($limit)->get();
        return (new DatatablesTransformer)->transformDatatables($companies, $total);

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
        $this->authorize('create', Company::class);
        $company = new Company;
        $company->fill($request->all());

        if ($company->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $company, trans('admin/companies/message.create.success')));
        }
        return response()
            ->json(Helper::formatStandardApiResponse('error', null, $company->getErrors()));

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
        $this->authorize('view', Company::class);
        $company = Company::findOrFail($id);
        return $company;
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
        $this->authorize('edit', Company::class);
        $company = Company::findOrFail($id);
        $company->fill($request->all());

        if ($company->save()) {
            return response()
                ->json(Helper::formatStandardApiResponse('success', $company, trans('admin/companies/message.update.success')));
        }

        return response()
            ->json(Helper::formatStandardApiResponse('error', null, $company->getErrors()));
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
       $this->authorize('delete', Company::class);
       $company = Company::findOrFail($id);
            $this->authorize('delete', $company);
            $company->delete();
            return response()
                ->json(Helper::formatStandardApiResponse('success', null,  trans('admin/companies/message.delete.success')));

    }
}
