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
        $licenses = Company::scopeCompanyables(License::with('company', 'manufacturer', 'freeSeats', 'supplier')->withCount('freeSeats'));

        if ($request->has('search')) {
            $licenses = $licenses->TextSearch($request->input('search'));
        }

        if ($request->has('company_id')) {
            $licenses->where('company_id','=',$request->input('company_id'));
        }

        if ($request->has('name')) {
            $licenses->where('licenses.name','=',$request->input('name'));
        }

        if ($request->has('product_key')) {
            $licenses->where('licenses.serial','=',$request->input('product_key'));
        }

        if ($request->has('order_number')) {
            $licenses->where('order_number','=',$request->input('order_number'));
        }

        if ($request->has('purchase_order')) {
            $licenses->where('purchase_order','=',$request->input('purchase_order'));
        }

        if ($request->has('license_name')) {
            $licenses->where('license_name','=',$request->input('license_name'));
        }

        if ($request->has('license_email')) {
            $licenses->where('license_email','=',$request->input('license_email'));
        }

        if ($request->has('manufacturer_id')) {
            $licenses->where('manufacturer_id','=',$request->input('manufacturer_id'));
        }

        if ($request->has('supplier_id')) {
            $licenses->where('supplier_id','=',$request->input('supplier_id'));
        }

        if ($request->has('depreciation_id')) {
            $licenses->where('depreciation_id','=',$request->input('depreciation_id'));
        }

        if ($request->has('supplier_id')) {
            $licenses->where('supplier_id','=',$request->input('supplier_id'));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';


        switch ($request->input('sort')) {
                case 'manufacturer':
                    $licenses = $licenses->leftJoin('manufacturers', 'licenses.manufacturer_id', '=', 'manufacturers.id')->orderBy('manufacturers.name', $order);
                break;
            case 'supplier':
                $licenses = $licenses->leftJoin('suppliers', 'licenses.supplier_id', '=', 'suppliers.id')->orderBy('suppliers.name', $order);
                break;
            case 'company':
                $licenses = $licenses->leftJoin('companies', 'licenses.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
                break;
            default:
                $allowed_columns = ['id','name','purchase_cost','expiration_date','purchase_order','order_number','notes','purchase_date','serial','company','license_name','license_email','free_seats_count','seats'];
                $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
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
        $license = License::find($id);
        if (isset($license->id)) {
            $license = $license->load('assignedusers', 'licenseSeats.user', 'licenseSeats.asset');
            $this->authorize('view', $license);
            return (new LicensesTransformer)->transformLicense($license);
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/licenses/message.does_not_exist')), 200);
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
