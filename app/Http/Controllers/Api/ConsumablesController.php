<?php

namespace App\Http\Controllers\Api;

use App\Events\CheckoutableCheckedOut;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdjustQuantityRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\StoreConsumableRequest;
use App\Http\Traits\HandlesAdjustQuantity;
use App\Http\Transformers\ActionlogsTransformer;
use App\Http\Transformers\ConsumablesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsumablesController extends Controller
{
    use HandlesAdjustQuantity;

    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     */
    public function index(FilterRequest $request): array
    {
        $this->authorize('index', Consumable::class);

        // See ComponentsController for the orderItems.order.supplier eager-load rationale.
        $consumables = Consumable::with('company', 'location', 'category', 'defaultSupplier', 'manufacturer', 'orderItems.order.supplier')
            ->withCount('users as consumables_users_count');

        // This array is what determines which fields should be allowed to be sorted on ON the table itself.
        // These must match a column on the consumables table directly.
        $allowed_columns = [
            'id',
            'name',
            'min_amt',
            'purchase_date',
            'purchase_cost',
            'company',
            'category',
            'model_number',
            'item_no',
            'manufacturer',
            'location',
            'qty',
            'image',
            // These are *relationships* so we wouldn't normally include them in this array,
            // since they would normally create a `column not found` error,
            // BUT we account for them in the ordering switch down at the end of this method
            // DO NOT ADD ANYTHING TO THIS LIST WITHOUT CHECKING THE ORDERING SWITCH BELOW!
            'company',
            'location',
            'category',
            'supplier',
            'manufacturer',
        ];

        // This invokes the Searchable model trait scopeTextSearch and will handle input by search or by advanced search filter
        if ($request->filled('filter') || $request->filled('search')) {
            $consumables->TextSearch($request->input('filter') ? $request->input('filter') : $request->input('search'));
        }

        if ($request->filled('name')) {
            $consumables->where('consumables.name', '=', $request->input('name'));
        }

        if ($request->filled('company_id')) {
            // expand_company_hierarchy=1 opts the company show-page tabs into the
            // parent/child rollup so a child shows items inherited from its parent.
            if ($request->boolean('expand_company_hierarchy')) {
                $consumables->whereIn('consumables.company_id', Company::reachableCompanyIds($request->input('company_id')));
            } else {
                $consumables->where('consumables.company_id', '=', $request->input('company_id'));
            }
        }

        if ($request->filled('order_number')) {
            // Reroute through the HasOrders orders() HasManyThrough since
            // the parent consumables.order_number column no longer exists.
            $orderNumber = $request->input('order_number');
            $consumables->whereHas('orders', function ($query) use ($orderNumber) {
                $query->where('orders.order_number', '=', $orderNumber);
            });
        }

        if ($request->filled('category_id')) {
            $consumables->where('consumables.category_id', '=', $request->input('category_id'));
        }

        if ($request->filled('model_number')) {
            $consumables->where('consumables.model_number', '=', $request->input('model_number'));
        }

        if ($request->filled('manufacturer_id')) {
            $consumables->where('consumables.manufacturer_id', '=', $request->input('manufacturer_id'));
        }

        if ($request->filled('supplier_id')) {
            $consumables->where('consumables.default_supplier_id', '=', $request->input('supplier_id'));
        }

        if ($request->filled('location_id')) {
            $consumables->where('consumables.location_id', '=', $request->input('location_id'));
        }

        if ($request->filled('notes')) {
            $consumables->where('consumables.notes', '=', $request->input('notes'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $total = $consumables->count();
        $offset = ($request->input('offset') > $total) ? $total : app('api_offset_value');
        $limit = app('api_limit_value');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        switch ($request->input('sort')) {
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
            case 'remaining':
                $consumables = $consumables->OrderRemaining($order);
                break;
            case 'percent_remaining':
                $consumables = $consumables->OrderPercentRemaining($order);
                break;
            case 'supplier':
                $consumables = $consumables->OrderSupplier($order);
                break;
            case 'created_by':
                $consumables = $consumables->OrderByCreatedBy($order);
                break;
            case 'purchase_cost':
                // See AccessoriesController for the rationale — these
                // three sorts walk order_items rather than removed
                // parent columns.
                $consumables = $consumables->OrderByLastPurchaseCost($order);
                break;
            case 'purchase_date':
                $consumables = $consumables->OrderByLastPurchaseDate($order);
                break;
            case 'total_cost':
                $consumables = $consumables->OrderByTotalOrderCost($order);
                break;
            default:
                $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
                $consumables = $consumables->orderBy($sort, $order);
                break;
        }

        $consumables = $consumables->skip($offset)->take($limit)->get();

        return (new ConsumablesTransformer)->transformConsumables($consumables, $total);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @param  ImageUploadRequest  $request
     */
    public function store(StoreConsumableRequest $request): JsonResponse
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable;
        $consumable->fill($request->all());
        $consumable->company_id = Company::getIdForCurrentUser($request->input('company_id'));
        // See AccessoriesController::store for the default-supplier seeding rationale.
        if (! $request->filled('default_supplier_id') && $request->filled('supplier_id')) {
            $consumable->default_supplier_id = $request->input('supplier_id');
        }
        $consumable = $request->handleImages($consumable);

        if ($consumable->save()) {
            $this->enrichInitialOrderFromRequest($request, $consumable);

            return response()->json(Helper::formatStandardApiResponse('success', $consumable, trans('admin/consumables/message.create.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $consumable->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @param  int  $id
     */
    public function show($id): array
    {
        $this->authorize('view', Consumable::class);
        $consumable = Consumable::with('users')->findOrFail($id);

        return (new ConsumablesTransformer)->transformConsumable($consumable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @param  ImageUploadRequest  $request
     * @param  int  $id
     */
    public function update(StoreConsumableRequest $request, $id): JsonResponse
    {
        $this->authorize('update', Consumable::class);
        $consumable = Consumable::findOrFail($id);

        // See Api\AccessoriesController::update for the qty / order_number
        // / supplier_id contract. Same logic mirrored here.
        $qtyBefore = (int) $consumable->qty;
        $qtyRequested = $request->has('qty') ? (int) $request->input('qty') : $qtyBefore;
        $qtyDelta = $qtyRequested - $qtyBefore;

        // supplier_id, purchase_date, purchase_cost, and order_number
        // are create-only on the parent. Post-create acquisitions live
        // as Orders + OrderItems, so update-mode drops all four.
        $consumable->fill($request->except([
            'qty',
            'order_number',
            'purchase_cost',
            'purchase_date',
            'supplier_id',
        ]));
        $consumable->company_id = Company::getIdForCurrentUser($request->input('company_id'));
        $consumable = $request->handleImages($consumable);

        if (! $consumable->save()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $consumable->getErrors()));
        }

        if ($qtyDelta !== 0) {
            $orderId = $this->resolveOrderForAdjustment($request, $consumable, $qtyDelta);
            try {
                $consumable->adjustQuantity(
                    $qtyDelta,
                    $request->input('note') ?: "API qty change: {$qtyBefore} → {$qtyRequested}",
                    $orderId,
                );
            } catch (DomainException) {
                return response()->json(
                    Helper::formatStandardApiResponse('error', null, trans('general.adjust_quantity_below_zero')),
                    422,
                );
            }
        }

        return response()->json(Helper::formatStandardApiResponse('success', $consumable, trans('admin/consumables/message.update.success')));
    }

    /**
     * See Api\AccessoriesController::adjustQuantity for the shape/contract.
     */
    public function adjustQuantity(AdjustQuantityRequest $request, Consumable $consumable): JsonResponse
    {
        return $this->adjustQuantityAsJson($request, $consumable);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
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
     *
     * @see \App\Http\Controllers\Consumables\ConsumablesController::getView() method that returns the form.
     * @since [v1.0]
     *
     * @param  int  $consumableId
     */
    public function getDataView($consumableId): array
    {
        $consumable = Consumable::with(['consumableAssignments' => function ($query) {
            $query->orderBy($query->getModel()->getTable().'.created_at', 'DESC');
        },
            'consumableAssignments.adminuser' => function ($query) {},
            'consumableAssignments.user' => function ($query) {},
        ])->find($consumableId);

        if (! Company::isCurrentUserHasAccess($consumable)) {
            return ['total' => 0, 'rows' => []];
        }
        $this->authorize('view', Consumable::class);
        $rows = [];

        foreach ($consumable->consumableAssignments as $consumable_assignment) {
            $rows[] = [
                'avatar' => ($consumable_assignment->user) ? e($consumable_assignment->user->present()->gravatar) : '',
                'user' => ($consumable_assignment->user) ? [
                    'id' => (int) $consumable_assignment->user->id,
                    'name' => e($consumable_assignment->user->display_name),
                ] : null,
                'created_at' => Helper::getFormattedDateObject($consumable_assignment->created_at, 'datetime'),
                'note' => ($consumable_assignment->note) ? e($consumable_assignment->note) : null,
                'created_by' => ($consumable_assignment->adminuser) ? [
                    'id' => (int) $consumable_assignment->adminuser->id,
                    'name' => e($consumable_assignment->adminuser->display_name),
                ] : null,
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
     *
     * @param  int  $id
     *
     * @since [v4.9.5]
     */
    public function checkout(Request $request, $id): JsonResponse
    {
        // Check if the consumable exists
        if (! $consumable = Consumable::with('users')->find($id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.does_not_exist')));
        }

        $this->authorize('checkout', $consumable);

        $consumable->checkout_qty = $request->input('checkout_qty', 1);

        // Make sure there is at least one available to checkout
        if ($consumable->numRemaining() <= 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.checkout.unavailable')));
        }

        // Make sure there is a valid category
        if (! $consumable->category) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.invalid_item_category_single', ['type' => trans('general.consumable')])));
        }

        // Make sure there is at least one available to checkout
        if ($consumable->numRemaining() <= 0 || $consumable->checkout_qty > $consumable->numRemaining()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.checkout.unavailable', ['requested' => $consumable->checkout_qty, 'remaining' => $consumable->numRemaining()])));
        }

        // Resolve the raw target first, then enforce FMCS explicitly.
        // Scoped lookup can hide cross-company users and make failures ambiguous.
        $user = User::withoutGlobalScopes()->find($request->input('assigned_to'));

        // withoutGlobalScopes bypasses SoftDeletes so we can tell "no such
        // user" from "user in another company" for FMCS messaging. Trashed
        // users must not be treated as valid checkout targets.
        if ($user && ! empty($user->deleted_at)) {
            $user = null;
        }

        if (! $user) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'No user found'));
        }

        if ((Setting::getSettings()->full_multiple_companies_support == '1') && (! $user->companies()->where('companies.id', $consumable->company_id)->exists())) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.error_user_company')));
        }

        // Update the consumable data
        $consumable->assigned_to = $request->input('assigned_to');

        // Concurrency guard. The unlocked numRemaining() check above is
        // advisory only — two simultaneous checkout requests can both read
        // "1 remaining", both pass the check, both attach a pivot row, and
        // land the register at -1. Re-fetch the parent row under
        // lockForUpdate INSIDE the transaction, re-check availability
        // against the locked snapshot, and only then write. Any concurrent
        // checkout blocks on the row lock until this transaction commits.
        // Mirrors the pattern already used by License checkout (which locks
        // LicenseSeat rows).
        $errorResponse = null;

        DB::transaction(function () use ($consumable, $request, $user, &$errorResponse): void {
            $locked = Consumable::whereKey($consumable->id)->lockForUpdate()->first();

            if (! $locked || $locked->numRemaining() < $consumable->checkout_qty) {
                $errorResponse = response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/consumables/message.checkout.unavailable', [
                    'requested' => $consumable->checkout_qty,
                    'remaining' => $locked ? $locked->numRemaining() : 0,
                ])));

                return;
            }

            for ($i = 0; $i < $consumable->checkout_qty; $i++) {
                $consumable->users()->attach($consumable->id,
                    [
                        'consumable_id' => $consumable->id,
                        // The pivot's created_by is the operator recording the
                        // checkout, not the checkout target. Sibling paths
                        // (web ConsumableCheckoutController, web + API
                        // ComponentCheckoutController) all key off auth()->id().
                        'created_by' => auth()->id(),
                        'assigned_to' => $request->input('assigned_to'),
                        'note' => $request->input('note'),
                    ]
                );
            }

            event(new CheckoutableCheckedOut(
                $consumable,
                $user,
                auth()->user(),
                $request->input('note'),
                [],
                $consumable->checkout_qty,
            ));
        });

        if ($errorResponse) {
            return $errorResponse;
        }

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/consumables/message.checkout.success')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @see SelectlistTransformer
     */
    public function selectlist(Request $request): array
    {
        $this->authorize('view.selectlists');

        $consumables = Consumable::select([
            'consumables.id',
            'consumables.name',
        ]);

        if ($request->filled('search')) {
            $consumables = $consumables->where('consumables.name', 'LIKE', '%'.$request->input('search').'%');
        }

        $consumables = $consumables->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($consumables);
    }

    public function history(Request $request, Consumable $consumable): JsonResponse|array
    {
        $this->authorize('history', $consumable);
        $historyQuery = $consumable->getHistory($request);
        $total = (clone $historyQuery)->count();
        $offset = ($request->input('offset') > $total) ? $total : app('api_offset_value');
        $limit = app('api_limit_value');
        $history = (clone $historyQuery)->skip($offset)->take($limit)->get();

        return response()->json((new ActionlogsTransformer)->transformActionlogs($history, $total), 200, ['Content-Type' => 'application/json;charset=utf8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * List consumables that are requestable AND reachable by the
     * current caller (per FMCS + location scoping). Hydrates the
     * consumables tab on /account/requestable. See the sibling
     * AccessoriesController::requestable for design rationale.
     */
    public function requestable(Request $request): array
    {
        $query = Consumable::with('category', 'location', 'company', 'manufacturer', 'requests')
            ->withCount('users as consumables_users_count')
            ->Requestable();

        if ($request->filled('search')) {
            $query->TextSearch($request->input('search'));
        }

        $total = $query->count();
        $offset = ($request->input('offset') > $total) ? $total : app('api_offset_value');
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), ['name', 'created_at'], true) ? $request->input('sort') : 'name';

        $rows = $query->orderBy($sort, $order)->skip($offset)->take($limit)->get();

        return (new ConsumablesTransformer)->transformRequestedConsumables($rows, $total);
    }
}
