<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LicenseSeatsTransformer;
use App\Http\Transformers\LicensesTransformer;
use App\Models\Company;
use App\Models\LicenseModel;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $this->authorize('view', LicenseModel::class);
        $licenseModels = Company::scopeCompanyables(LicenseModel::with('company', 'manufacturer', 'freeSeats', 'supplier','category')->withCount('freeSeats as free_seats_count'));


        if ($request->filled('company_id')) {
            $licenseModels->where('company_id','=',$request->input('company_id'));
        }

        if ($request->filled('name')) {
            $licenseModels->where('licenses.name','=',$request->input('name'));
        }

        if ($request->filled('product_key')) {
            $licenseModels->where('licenses.serial','=',$request->input('product_key'));
        }

        if ($request->filled('order_number')) {
            $licenseModels->where('order_number','=',$request->input('order_number'));
        }

        if ($request->filled('purchase_order')) {
            $licenseModels->where('purchase_order','=',$request->input('purchase_order'));
        }

        if ($request->filled('license_name')) {
            $licenseModels->where('license_name','=',$request->input('license_name'));
        }

        if ($request->filled('license_email')) {
            $licenseModels->where('license_email','=',$request->input('license_email'));
        }

        if ($request->filled('manufacturer_id')) {
            $licenseModels->where('manufacturer_id','=',$request->input('manufacturer_id'));
        }

        if ($request->filled('supplier_id')) {
            $licenseModels->where('supplier_id','=',$request->input('supplier_id'));
        }

        if ($request->filled('category_id')) {
            $licenseModels->where('category_id','=',$request->input('category_id'));
        }

        if ($request->filled('depreciation_id')) {
            $licenseModels->where('depreciation_id','=',$request->input('depreciation_id'));
        }

        if ($request->filled('supplier_id')) {
            $licenseModels->where('supplier_id','=',$request->input('supplier_id'));
        }


        if ($request->filled('search')) {
            $licenseModels = $licenseModels->TextSearch($request->input('search'));
        }


        $offset = request('offset', 0);
        $limit = request('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';


        switch ($request->input('sort')) {
                case 'manufacturer':
                    $licenseModels = $licenseModels->leftJoin('manufacturers', 'licenses.manufacturer_id', '=', 'manufacturers.id')->orderBy('manufacturers.name', $order);
                break;
            case 'supplier':
                $licenseModels = $licenseModels->leftJoin('suppliers', 'licenses.supplier_id', '=', 'suppliers.id')->orderBy('suppliers.name', $order);
                break;
            case 'category':
                $licenseModels = $licenseModels->leftJoin('categories', 'licenses.category_id', '=', 'categories.id')->orderBy('categories.name', $order);
                break;
            case 'company':
                $licenseModels = $licenseModels->leftJoin('companies', 'licenses.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
                break;
            default:
                $allowed_columns = ['id','name','purchase_cost','expiration_date','purchase_order','order_number','notes','purchase_date','serial','company','category','license_name','license_email','free_seats_count','seats'];
                $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
                $licenseModels = $licenseModels->orderBy($sort, $order);
                break;
        }



        $total = $licenseModels->count();

        $licenseModels = $licenseModels->skip($offset)->take($limit)->get();
        return (new LicensesTransformer)->transformLicenses($licenseModels, $total);

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
        $this->authorize('create', LicenseModel::class);
        $licenseModel = new LicenseModel;
        $licenseModel->fill($request->all());

        if($licenseModel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $licenseModel, trans('admin/licenses/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $licenseModel->getErrors()));
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
        $this->authorize('view', LicenseModel::class);
        $licenseModel = LicenseModel::findOrFail($id);
        $licenseModel = $licenseModel->load('assignedusers', 'licenseSeats.user', 'licenseSeats.asset');
        return (new LicensesTransformer)->transformLicense($licenseModel);
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
        $this->authorize('update', LicenseModel::class);

        $licenseModel = LicenseModel::findOrFail($id);
        $licenseModel->fill($request->all());

        if ($licenseModel->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $licenseModel, trans('admin/licenses/message.update.success')));
        }

        return Helper::formatStandardApiResponse('error', null, $licenseModel->getErrors());
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
        $licenseModel = LicenseModel::findOrFail($id);
        $this->authorize('delete', $licenseModel);

        if($licenseModel->assigned_seats_count == 0) {
            // Delete the licenseModel and the associated licenseModel seats
            DB::table('license_seats')
                ->where('id', $licenseModel->id)
                ->update(array('assigned_to' => null,'asset_id' => null));

            $license = $licenseModel->licenseseats();
            $license->delete();
            $licenseModel->delete();

            // Redirect to the licenses management page
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/licenses/message.delete.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/licenses/message.assoc_users')));
    }

    /**
     * Get license seat listing
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @return \Illuminate\Contracts\View\View
     */
    public function seats(Request $request, $licenseId)
    {

        if ($licenseModel = LicenseModel::find($licenseId)) {

            $this->authorize('view', $licenseModel);

            $seats = License::where('license_id', $licenseId)->with('model', 'user', 'asset');

            $offset = request('offset', 0);
            $limit = request('limit', 50);
            $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

            $total = $seats->count();
            $seats = $seats->skip($offset)->take($limit)->get();

            if ($seats) {
                return (new LicenseSeatsTransformer)->transformLicenseSeats($seats, $total);
            }

        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/licenses/message.does_not_exist')), 200);

    }


}
