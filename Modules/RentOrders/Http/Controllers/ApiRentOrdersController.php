<?php

namespace Modules\RentOrders\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RentOrders\Entities\RentOrder;
use Modules\RentOrders\Http\Transformers\RentOrdersTransformer;
use Modules\RentOrders\System\RentOrderSystem;

class ApiRentOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $rentOrders = RentOrder::orderBy('id','desc')->get();

        return (new RentOrdersTransformer())->transformRentOrders($rentOrders, $rentOrders->count());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, RentOrderSystem $system)
    {

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
