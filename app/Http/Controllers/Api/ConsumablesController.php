<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Consumable;
use App\Http\Transformers\ConsumablesTransformer;
use App\Helpers\Helper;

class ConsumablesController extends Controller
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
        $this->authorize('index', Consumable::class);
        $consumables = Company::scopeCompanyables(
            Consumable::select('consumables.*')
                ->whereNull('consumables.deleted_at')
                ->with('company', 'location', 'category', 'users', 'manufacturer')
        );

        if ($request->has('search')) {
            $consumables = $consumables->TextSearch(e($request->input('search')));
        }

        if ($request->has('company_id')) {
            $consumables->where('company_id','=',$request->input('company_id'));
        }

        if ($request->has('manufacturer_id')) {
            $consumables->where('manufacturer_id','=',$request->input('manufacturer_id'));
        }


        $offset = request('offset', 0);
        $limit = request('limit', 50);
        $allowed_columns = ['id','name','order_number','min_amt','purchase_date','purchase_cost','company','category','model_number', 'item_no', 'manufacturer','location','qty','image'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        switch ($sort) {
            case 'category':
                $consumables = $consumables->OrderCategory($order);
                break;
            case 'location':
                $consumables = $consumables->OrderLocation($order);
                break;
            case 'manufacturer':
                $consumables = $consumables->OrderManufacturer($order);
                break;
            case 'company':
                $consumables = $consumables->OrderCompany($order);
                break;
            default:
                $consumables = $consumables->orderBy($sort, $order);
                break;
        }



        $total = $consumables->count();
        $consumables = $consumables->skip($offset)->take($limit)->get();
        return (new ConsumablesTransformer)->transformConsumables($consumables, $total);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable;
        $consumable->fill($request->all());

        if ($consumable->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $consumable, trans('admin/consumables/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $consumable->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Consumable::class);
        $consumable = Consumable::findOrFail($id);
        return (new ConsumablesTransformer)->transformConsumable($consumable);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', Consumable::class);
        $consumable = Consumable::findOrFail($id);
        $consumable->fill($request->all());

        if ($consumable->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $consumable, trans('admin/consumables/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $consumable->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Consumable::class);
        $consumable = Consumable::findOrFail($id);
        $this->authorize('delete', $consumable);
        $consumable->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/consumables/message.delete.success')));
    }

        /**
    * Returns a JSON response containing details on the users associated with this consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getView() method that returns the form.
    * @since [v1.0]
    * @param int $consumableId
    * @return array
     */
    public function getDataView($consumableId)
    {
        $consumable = Consumable::with(array('consumableAssignments'=>
        function ($query) {
            $query->orderBy('created_at', 'DESC');
        },
        'consumableAssignments.admin'=> function ($query) {
        },
        'consumableAssignments.user'=> function ($query) {
        },
        ))->find($consumableId);

        if (!Company::isCurrentUserHasAccess($consumable)) {
            return ['total' => 0, 'rows' => []];
        }
        $this->authorize('view', Consumable::class);
        $rows = array();

        foreach ($consumable->consumableAssignments as $consumable_assignment) {
            $rows[] = [
                'name' => ($consumable_assignment->user) ? $consumable_assignment->user->present()->nameUrl() : 'Deleted User',
                'created_at' => ($consumable_assignment->created_at->format('Y-m-d H:i:s')=='-0001-11-30 00:00:00') ? '' : $consumable_assignment->created_at->format('Y-m-d H:i:s'),
                'admin' => ($consumable_assignment->admin) ? $consumable_assignment->admin->present()->nameUrl() : '',
            ];
        }

        $consumableCount = $consumable->users->count();
        $data = array('total' => $consumableCount, 'rows' => $rows);
        return $data;
    }
}
