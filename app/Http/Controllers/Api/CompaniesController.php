<?php

namespace App\Http\Controllers\Api;

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
    public function index()
    {
        $this->authorize('view', Company::class);
        $companies = Company::all();
        return $companies;
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
