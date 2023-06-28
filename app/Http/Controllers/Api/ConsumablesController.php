<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ConsumablesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;

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

        // This array is what determines which fields should be allowed to be sorted on ON the table itself, no relations
        // Relations will be handled in query scopes a little further down.
        $allowed_columns = 
            [
                'id',
                'name',
                'order_number',
                'min_amt',
                'purchase_date',
                'purchase_cost',
                'company',
                'category',
                'model_number', 
                'item_no', 
                'qty',
                'image',
                'notes',
                ];

        $consumables = Consumable::select('consumables.*')
            ->with('company', 'location', 'category', 'users', 'manufacturer');

        if ($request->filled('search')) {
            $consumables = $consumables->TextSearch(e($request->input('search')));
        }

        if ($request->filled('name')) {
            $consumables->where('name', '=', $request->input('name'));
        }

        if ($request->filled('company_id')) {
            $consumables->where('company_id', '=', $request->input('company_id'));
        }

        if ($request->filled('category_id')) {
            $consumables->where('category_id', '=', $request->input('category_id'));
        }

        if ($request->filled('model_number')) {
            $consumables->where('model_number','=',$request->input('model_number'));
        }

        if ($request->filled('manufacturer_id')) {
            $consumables->where('manufacturer_id', '=', $request->input('manufacturer_id'));
        }

        if ($request->filled('supplier_id')) {
            $consumables->where('supplier_id', '=', $request->input('supplier_id'));
        }

        if ($request->filled('location_id')) {
            $consumables->where('location_id','=',$request->input('location_id'));
        }

        if ($request->filled('notes')) {
            $consumables->where('notes','=',$request->input('notes'));
        }


        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $consumables->count()) ? $consumables->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');

        $allowed_columns = ['id', 'name', 'order_number', 'min_amt', 'purchase_date', 'purchase_cost', 'company', 'category', 'model_number', 'item_no', 'manufacturer', 'location', 'qty', 'image'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $sort_override =  $request->input('sort');
        $column_sort = in_array($sort_override, $allowed_columns) ? $sort_override : 'created_at';


        switch ($sort_override) {
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
            case 'supplier':
                $components = $consumables->OrderSupplier($order);
                break;
            default:
                $consumables = $consumables->orderBy($column_sort, $order);
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
     * @param  \App\Http\Requests\ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable;
        $consumable->fill($request->all());
        $consumable = $request->handleImages($consumable);

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
        $consumable = Consumable::with('users')->findOrFail($id);

        return (new ConsumablesTransformer)->transformConsumable($consumable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageUploadRequest $request, $id)
    {
        $this->authorize('update', Consumable::class);
        $consumable = Consumable::findOrFail($id);
        $consumable->fill($request->all());
        $consumable = $request->handleImages($consumable);
        
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

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/consumables/message.delete.success')));
    }

    /**
    * Returns a JSON response containing details on the users associated with this consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see \App\Http\Controllers\Consumables\ConsumablesController::getView() method that returns the form.
    * @since [v1.0]
    * @param int $consumableId
    * @return array
     */
    public function getDataView($consumableId)
    {
        $consumable = Consumable::with(['consumableAssignments'=> function ($query) {
            $query->orderBy($query->getModel()->getTable().'.created_at', 'DESC');
        },
        'consumableAssignments.admin'=> function ($query) {
        },
        'consumableAssignments.user'=> function ($query) {
        },
        ])->find($consumableId);

        if (! Company::isCurrentUserHasAccess($consumable)) {
            return ['total' => 0, 'rows' => []];
        }
        $this->authorize('view', Consumable::class);
        $rows = [];

        foreach ($consumable->consumableAssignments as $consumable_assignment) {
            $rows[] = [
                'avatar' => ($consumable_assignment->user) ? e($consumable_assignment->user->present()->gravatar) : '',
                'name' => ($consumable_assignment->user) ? $consumable_assignment->user->present()->nameUrl() : 'Deleted User',
                'created_at' => Helper::getFormattedDateObject($consumable_assignment->created_at, 'datetime'),
                'note' => ($consumable_assignment->note) ? e($consumable_assignment->note) : null,
                'admin' => ($consumable_assignment->admin) ? $consumable_assignment->admin->present()->nameUrl() : null,
            ];
        }

        $consumableCount = $consumable->users->count();
        $data = ['total' => $consumableCount, 'rows' => $rows];

        return $data;
    }

    /**
     * Checkout a consumable
     *
     * @author [A. Gutierrez] [<andres@baller.tv>]
     * @param int $id
     * @since [v4.9.5]
     * @return JsonResponse
     */
    public function checkout(Request $request, $id)
    {
        // Check if the consumable exists
        if (!$consumable = Consumable::with('users')->find($id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.does_not_exist')));
        }

        $this->authorize('checkout', $consumable);

        // Make sure there is at least one available to checkout
        if ($consumable->numRemaining() <= 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.checkout.unavailable')));
            \Log::debug('No enough remaining');
        }

        // Check if the user exists - @TODO:  this should probably be handled via validation, not here??
        if (!$user = User::find($request->input('assigned_to'))) {
            // Return error message
            return response()->json(Helper::formatStandardApiResponse('error', null, 'No user found'));
            \Log::debug('No valid user');
        }

        // Update the consumable data
        $consumable->assigned_to = $request->input('assigned_to');

        $consumable->users()->attach($consumable->id,
                [
                    'consumable_id' => $consumable->id,
                    'user_id' => $user->id,
                    'assigned_to' => $request->input('assigned_to'),
                    'note' => $request->input('note'),
                ]
            );

            // Log checkout event
            $logaction = $consumable->logCheckout($request->input('note'), $user);
            $data['log_id'] = $logaction->id;
            $data['eula'] = $consumable->getEula();
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $consumable->name;
            $data['checkout_date'] = $logaction->created_at;
            $data['note'] = $logaction->note;
            $data['require_acceptance'] = $consumable->requireAcceptance();

            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/consumables/message.checkout.success')));

    }

    /**
    * Gets a paginated collection for the select2 menus
    *
    * @see \App\Http\Transformers\SelectlistTransformer
    */
    public function selectlist(Request $request)
    {
        $consumables = Consumable::select([
            'consumables.id',
            'consumables.name',
        ]);

        if ($request->filled('search')) {
            $consumables = $consumables->where('consumables.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $consumables = $consumables->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($consumables);
    }
}
