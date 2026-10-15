<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class OrderItemsTransformer
{
    public function transformOrderItems(Collection $lines, $total): array
    {
        $rows = [];
        foreach ($lines as $line) {
            $rows[] = $this->transformOrderItem($line);
        }

        return (new DatatablesTransformer)->transformDatatables($rows, $total);
    }

    public function transformOrderItem(OrderItem $line): array
    {
        $order = $line->order;
        $qty = (int) $line->qty;
        $price = $line->price !== null ? (float) $line->price : null;
        // Prefer the OrderItem's own creator (per-line authorship).
        // Falls back to the parent Order's created_by so
        // rows with a null order_items.created_by still show a name.
        $admin = $line->admin ?? $order?->admin;

        return [
            'id' => (int) $line->id,
            'order_number' => $order?->order_number ? e($order->order_number) : null,
            'supplier' => $order?->supplier ? [
                'id' => (int) $order->supplier->id,
                'name' => e($order->supplier->name),
                // Drives suppliersLinkObjFormatter: rendered as plain
                // text when the caller cannot view the supplier show
                // page, so a scoped viewer's click does not 403.
                'viewable' => Gate::allows('view', $order->supplier),
            ] : null,
            'purchase_date' => Helper::getFormattedDateObject($order?->purchase_date, 'date'),
            'qty' => $qty,
            'unit_cost' => $price !== null ? Helper::formatCurrencyOutput($price) : null,
            'currency' => $order?->currency ? e($order->currency) : null,
            'total_cost' => $price !== null ? Helper::formatCurrencyOutput($qty * $price) : null,
            'notes' => $order?->notes ? Helper::parseEscapedMarkedownInline($order->notes) : null,
            'receipt' => $this->transformReceipt($line),
            'created_by' => $admin ? [
                'id' => (int) $admin->id,
                'name' => e($admin->display_name),
                // Drives usersLinkObjFormatter: same rationale as
                // supplier above. Components-only viewer without
                // users.view sees the actor name but no dead link.
                'viewable' => Gate::allows('view', $admin),
            ] : null,
            'created_at' => Helper::getFormattedDateObject($line->created_at, 'datetime'),
        ];
    }

    /**
     * Surface the receipt/whatever file uploaded via the adjust-quantity modal.
     * The file is attached to the action_log (not to the OrderItem itself)
     * so this walks the OrderItem's actionlog relation and builds a
     * download URL using Controller::$map_class_url_segment. Returns null
     * when no file was uploaded or when the item's class is not
     * registered for URL-segment lookup.
     */
    private function transformReceipt(OrderItem $line): ?string
    {
        $log = $line->actionlog;
        if (! $log || ! $log->filename) {
            return null;
        }

        $segment = Controller::getMapClassUrlSegment()[$log->item_type] ?? null;
        if ($segment === null) {
            return null;
        }

        return route('ui.files.show', [
            'object_type' => $segment,
            'id' => $log->item_id,
            'file_id' => $log->id,
        ]);
    }
}
