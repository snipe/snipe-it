<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LicensesTransformer;
use App\Models\License;
use App\Models\Company;

class LicensesController extends Controller
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
        $this->authorize('view', License::class);
        $licenses = Company::scopeCompanyables(License::with('company', 'licenseSeatsRelation', 'manufacturer'));

        if ($request->has('search')) {
            $licenses = $licenses->TextSearch($request->input('search'));
        }

        if ($request->has('company_id')) {
            $licenses->where('company_id','=',$request->input('company_id'));
        }

        if ($request->has('manufacturer_id')) {
            $licenses->where('manufacturer_id','=',$request->input('manufacturer_id'));
        }

        if ($request->has('supplier_id')) {
            $licenses->where('supplier_id','=',$request->input('supplier_id'));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name','purchase_cost','expiration_date','purchase_order','order_number','notes','purchase_date','serial','manufacturer','company','license_name','license_email'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';

        switch ($sort) {
            case 'manufacturer':
                $licenses = $licenses->OrderManufacturer($order);
                break;
            case 'company':
                $licenses = $licenses->OrderCompany($order);
                break;
            default:
                $licenses = $licenses->orderBy($sort, $order);
                break;
        }

        $total = $licenses->count();
        $licenses = $licenses->skip($offset)->take($limit)->get();
        return (new LicensesTransformer)->transformLicenses($licenses, $total);

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
        //
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
        //
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
        //
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
        //
    }
}
