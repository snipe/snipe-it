<?php

namespace App\Http\Traits;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdjustQuantityRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\Order;
use App\Models\OrderItem;
use DomainException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Shared body of the adjust-quantity controller action. Authorize,
 * save the optional receipt, resolve or create an Order + OrderItem,
 * call the AdjustsQuantity trait with the OrderItem id, turn
 * DomainException into the shared error string. Each controller wraps
 * the outcome in its own response shape (redirect or JSON).
 */
trait HandlesAdjustQuantity
{
    /**
     * Run the shared adjust-quantity work. Returns null on success or a
     * translated error string on failure, so the caller can wrap the
     * outcome in whichever response shape (RedirectResponse or
     * JsonResponse) is appropriate for the invoking controller.
     */
    protected function runAdjustQuantity(
        AdjustQuantityRequest $request,
        Model $model,
        string $storageKey,
    ): ?string {
        $this->authorize('update', $model);

        $filename = null;
        if ($request->hasFile('file')) {
            $filename = app(UploadFileRequest::class)->handleFile(
                Controller::getMapStoragePath()[$storageKey],
                Controller::getMapFilePrefix()[$storageKey].'-'.$model->id,
                $request->file('file'),
            );
        }

        $delta = (int) $request->input('amount');
        $orderItemId = $this->resolveOrderForAdjustment($request, $model, $delta);

        try {
            $model->adjustQuantity(
                $delta,
                $request->input('note'),
                $orderItemId,
                $filename,
            );
        } catch (DomainException) {
            return trans('general.adjust_quantity_below_zero');
        }

        return null;
    }

    /**
     * Land the post-save redirect on the page the operator was on when
     * they opened the modal. From the item's show page: the show page
     * with the `#history` fragment so the newly-written log entry is
     * visible as confirmation. From an index / listing page: back to
     * that listing so bulk-adjust flows don't force the operator to
     * back out and re-navigate for every item. Referer is validated
     * as same-origin to prevent open-redirect abuse; missing or
     * cross-origin referers fall back to the item show page.
     */
    protected function adjustQuantityRedirect(Request $request, string $itemShowUrl): RedirectResponse
    {
        $referer = Helper::sameOriginUrl($request->headers->get('referer'));
        $success = trans('general.adjust_quantity_success');

        if ($referer && $referer !== $itemShowUrl && ! str_starts_with($referer, $itemShowUrl.'#')) {
            return redirect()->to($referer)->with('success', $success);
        }

        return redirect()->to($itemShowUrl)->withFragment('history')->with('success', $success);
    }

    /**
     * Full web controller flow. Runs the shared work and wraps the
     * outcome in the standard redirect-with-flash shape. Route target
     * derives from Controller::$map_class_url_segment so a new inventory
     * model that adopts HandlesAdjustQuantity only needs an entry in
     * that map, not a per-model method or a controller-side segment
     * string.
     */
    protected function adjustQuantityAsRedirect(AdjustQuantityRequest $request, Model $model): RedirectResponse
    {
        $segment = Controller::getMapClassUrlSegment()[$model::class];
        $error = $this->runAdjustQuantity($request, $model, $segment);

        if ($error) {
            return redirect()->back()->with('error', $error);
        }

        return $this->adjustQuantityRedirect($request, route("$segment.show", $model));
    }

    /**
     * Full API controller flow. Runs the shared work and wraps the
     * outcome in the standard Snipe-IT JSON envelope. 422 on validation
     * / floor errors, 200 with the refreshed model on success.
     */
    protected function adjustQuantityAsJson(AdjustQuantityRequest $request, Model $model): JsonResponse
    {
        $segment = Controller::getMapClassUrlSegment()[$model::class];
        $error = $this->runAdjustQuantity($request, $model, $segment);

        if ($error !== null) {
            return response()->json(
                Helper::formatStandardApiResponse('error', null, $error),
                422,
            );
        }

        return response()->json(
            Helper::formatStandardApiResponse('success', $model->fresh(), trans('general.adjust_quantity_success')),
        );
    }

    /**
     * Find or create an Order from the request payload and append one
     * OrderItem line for the model / delta being adjusted. Returns the
     * OrderItem id (the parent Order is reachable via OrderItem->order),
     * or null when the request carried no acquisition info (audit-only
     * zero-delta with no order metadata).
     *
     * Dedupes the Order on (order_number, supplier_id, company_id).
     * Each adjustment gets its own OrderItem line so staggered receipts
     * under one order_number stay distinguishable.
     *
     * Accepts the base Request so the legacy Api\...Controller::update
     * paths (which use ImageUploadRequest) can call it the same way as
     * the dedicated adjust-quantity endpoint.
     */
    protected function resolveOrderForAdjustment(
        Request $request,
        Model $model,
        int $delta,
    ): ?int {
        // Orders / OrderItems record purchases only. A negative delta is
        // a correction / consumption / loss and a zero delta is a
        // physical-count audit, neither is a purchase, so neither
        // writes to the Orders ledger. Both still write an action_log
        // entry (that's the QuantityAdjust source of truth), just
        // without an order_item_id link.
        if ($delta <= 0) {
            return null;
        }

        $orderNumberRaw = trim((string) $request->input('order_number', ''));
        $currencyRaw = $request->filled('currency') ? trim((string) $request->input('currency')) : null;
        $noteRaw = $request->filled('note') ? trim((string) $request->input('note')) : null;

        $payload = [
            'order_number' => $orderNumberRaw !== '' ? $orderNumberRaw : null,
            'supplier_id' => $request->filled('supplier_id') ? (int) $request->input('supplier_id') : null,
            'purchase_date' => $request->filled('purchase_date') ? $request->input('purchase_date') : null,
            'unit_cost' => $request->filled('unit_cost') ? (float) $request->input('unit_cost') : null,
            'currency' => ($currencyRaw !== null && $currencyRaw !== '') ? $currencyRaw : null,
            'notes' => ($noteRaw !== null && $noteRaw !== '') ? $noteRaw : null,
        ];

        if ($this->orderPayloadIsEmpty($payload)) {
            return null;
        }

        // Only dedupe when there's a real order_number label to match
        // on. A blank order_number is a distinct transaction each time
        // (own timestamp, supplier, cost, currency), not a bucket to
        // pool anonymous acquisitions into. purchase_date is part of
        // the dedup key because Snipe-IT has no partial-receipt concept,
        // every Order is a completed receipt-in-hand, so "same
        // order_number on a different receipt date" is a distinct
        // event, not a staggered delivery of one order. created_by is
        // set via property assignment rather than mass-fill because
        // it's guarded on both Order and OrderItem to prevent forgery.
        $companyId = $model->company_id ?? null;

        if ($payload['order_number'] === null) {
            $order = new Order([
                'order_number' => $payload['order_number'],
                'supplier_id' => $payload['supplier_id'],
                'company_id' => $companyId,
                'purchase_date' => $payload['purchase_date'],
                'currency' => $payload['currency'],
                'notes' => $payload['notes'],
            ]);
            $order->created_by = auth()->id();
            $order->save();
        } else {
            $order = Order::firstOrNew(
                [
                    'order_number' => $payload['order_number'],
                    'supplier_id' => $payload['supplier_id'],
                    'company_id' => $companyId,
                    'purchase_date' => $payload['purchase_date'],
                ],
                [
                    'currency' => $payload['currency'],
                    'notes' => $payload['notes'],
                ],
            );

            if (! $order->exists) {
                $order->created_by = auth()->id();
                $order->save();
            }
        }

        $orderItem = new OrderItem([
            'order_id' => $order->id,
            'item_type' => $model::class,
            'item_id' => $model->id,
            // OrderItem.qty is always positive. The delta sign lives on
            // the sibling action_log.
            'qty' => max(1, abs($delta)),
            'price' => $payload['unit_cost'],
        ]);
        $orderItem->created_by = auth()->id();
        $orderItem->save();

        return $orderItem->id;
    }

    /**
     * Update the observer-created initial Order + OrderItem for a
     * freshly-saved inventory item with the form-supplied transaction
     * fields. None of these fields live on the accessory / consumable /
     * component parent column any more — they moved to Orders /
     * OrderItems, so the observer writes placeholders and the
     * controller enriches with the form values right after save.
     *
     * Order fields:    order_number, supplier_id, purchase_date, currency
     * OrderItem field: price (from request `purchase_cost`)
     *
     * No-op when the request carried none of them.
     */
    protected function enrichInitialOrderFromRequest(Request $request, Model $item): void
    {
        $orderInputs = [
            'order_number' => $this->trimmedOrNull($request->input('order_number')),
            'currency' => $this->trimmedOrNull($request->input('currency')),
            'supplier_id' => $request->filled('supplier_id') ? (int) $request->input('supplier_id') : null,
            'purchase_date' => $request->filled('purchase_date') ? $request->input('purchase_date') : null,
            'purchase_cost' => $request->filled('purchase_cost') ? (float) $request->input('purchase_cost') : null,
            'notes' => $this->trimmedOrNull($request->input('notes')),
        ];
        $purchaseCost = $orderInputs['purchase_cost'];

        if ($this->initialOrderEnrichmentIsEmpty($orderInputs, $purchaseCost)) {
            return;
        }

        $initialLine = $item->orderItems()->latest('id')->first();
        if (! $initialLine || ! $initialLine->order) {
            return;
        }

        $orderUpdates = $this->diffInitialOrder($initialLine->order, $orderInputs);
        if ($orderUpdates !== []) {
            $initialLine->order->update($orderUpdates);
        }

        if ($purchaseCost !== null && (float) $initialLine->price !== $purchaseCost) {
            $initialLine->update(['price' => $purchaseCost]);
        }
    }

    private function trimmedOrNull(mixed $raw): ?string
    {
        if ($raw === null) {
            return null;
        }
        $trimmed = trim((string) $raw);

        return $trimmed === '' ? null : $trimmed;
    }

    private function initialOrderEnrichmentIsEmpty(array $inputs, ?float $purchaseCost): bool
    {
        return $inputs['order_number'] === null
            && $inputs['currency'] === null
            && $inputs['supplier_id'] === null
            && $inputs['purchase_date'] === null
            && $inputs['notes'] === null
            && $purchaseCost === null;
    }

    /**
     * Build the Order-column diff between what the request wants and
     * what the observer wrote. Only differing fields are returned so
     * the update() runs the smallest possible set of column writes.
     */
    private function diffInitialOrder(Order $initialOrder, array $inputs): array
    {
        $candidates = [
            'order_number' => $inputs['order_number'],
            'currency' => $inputs['currency'],
            'supplier_id' => $inputs['supplier_id'],
            'notes' => $inputs['notes'],
        ];

        $updates = [];
        foreach ($candidates as $column => $incoming) {
            if ($incoming !== null && $initialOrder->getAttribute($column) != $incoming) {
                $updates[$column] = $incoming;
            }
        }

        if ($inputs['purchase_date'] !== null
            && optional($initialOrder->purchase_date)->toDateString() !== $inputs['purchase_date']
        ) {
            $updates['purchase_date'] = $inputs['purchase_date'];
        }

        return $updates;
    }

    /**
     * True when the request carried no acquisition context. Audit-only
     * zero-delta submissions with no order metadata fall through here
     * so we don't accrete meaningless Order rows for pure counts.
     *
     * @param  array{order_number: ?string, supplier_id: ?int, purchase_date: ?string, unit_cost: ?float, currency: ?string}  $payload
     */
    private function orderPayloadIsEmpty(array $payload): bool
    {
        return $payload['order_number'] === null
            && $payload['supplier_id'] === null
            && $payload['purchase_date'] === null
            && $payload['unit_cost'] === null
            && $payload['currency'] === null;
    }
}
