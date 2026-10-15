<?php

namespace App\Http\Transformers;

use App\Enums\FileStorage;
use App\Helpers\Helper;
use App\Models\Accessory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AccessoriesTransformer
{
    public function transformAccessories(Collection $accessories, $total)
    {
        $array = [];
        foreach ($accessories as $accessory) {
            $array[] = self::transformAccessory($accessory);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAccessory(Accessory $accessory)
    {
        // Supplier / purchase_date / purchase_cost no longer live on the
        // parent column. Resolve them from the last acquisition (with
        // fallback to the parent's default_* template values) so the
        // public API surface still returns something meaningful per row.
        $lastDefaults = $accessory->lastOrderDefaults();
        $lastSupplier = $accessory->lastAcquisitionSupplier();

        $array = [
            'id' => $accessory->id,
            'name' => e($accessory->name),
            'image' => ($accessory->image) ? Storage::disk('public')->url(FileStorage::Accessories->publicPath().e($accessory->image)) : null,
            'qr_code_url' => route('qr_code/common', ['object_type' => 'accessories', 'id' => $accessory->id]),
            'company' => ($accessory->company) ? [
                'id' => $accessory->company->id,
                'name' => e($accessory->company->name),
                'tag_color' => ($accessory->company->tag_color) ? e($accessory->company->tag_color) : null,
            ] : null,
            'manufacturer' => ($accessory->manufacturer) ? [
                'id' => $accessory->manufacturer->id,
                'name' => e($accessory->manufacturer->name),
                'tag_color' => ($accessory->manufacturer->tag_color) ? e($accessory->manufacturer->tag_color) : null,
            ] : null,
            'supplier' => $lastSupplier ? [
                'id' => $lastSupplier->id,
                'name' => e($lastSupplier->name),
                'tag_color' => $lastSupplier->tag_color ? e($lastSupplier->tag_color) : null,
            ] : null,
            'model_number' => ($accessory->model_number) ? e($accessory->model_number) : null,
            'category' => ($accessory->category) ? [
                'id' => $accessory->category->id,
                'name' => e($accessory->category->name),
                'tag_color' => ($accessory->category->tag_color) ? e($accessory->category->tag_color) : null,
            ] : null,
            'location' => ($accessory->location) ? [
                'id' => $accessory->location->id,
                'name' => e($accessory->location->name),
                'tag_color' => ($accessory->location->tag_color) ? e($accessory->location->tag_color) : null,
            ] : null,
            'notes' => ($accessory->notes) ? Helper::parseEscapedMarkedownInline($accessory->notes) : null,
            'requestable' => (bool) $accessory->requestable,
            'qty' => ($accessory->qty) ? (int) $accessory->qty : null,
            'percent_remaining' => round($accessory->percentRemaining()),
            'purchase_date' => ($lastDefaults['purchase_date'] ?? null) ? Helper::getFormattedDateObject($lastDefaults['purchase_date'], 'date') : null,
            'purchase_cost' => Helper::formatCurrencyOutput($lastDefaults['unit_cost'] ?? null),
            'total_cost' => Helper::formatCurrencyOutput($accessory->totalCostSum()),
            // Distinct order numbers this accessory has been purchased on,
            // pulled from the eager-loaded orderItems.order relation
            // (Api\AccessoriesController::index preloads it). Replaces
            // the removed parent-level order_number attribute. Feeds the
            // datatable's ordersSummaryFormatter which renders empty /
            // single / comma-list / first + "(+N more)" depending on
            // count.
            'orders' => $accessory->orderItems->pluck('order.order_number')->filter()->unique()->values()->all(),
            'min_qty' => ($accessory->min_amt) ? (int) $accessory->min_amt : null, // Legacy - should phase out - replaced by below, for the bootstrap table formatter
            'min_amt' => ($accessory->min_amt) ? (int) $accessory->min_amt : null,
            'remaining_qty' => (int) ($accessory->qty - $accessory->checkouts_count), // Legacy - should phase out - replaced by below, for the bootstrap table formatter
            'remaining' => (int) ($accessory->qty - $accessory->checkouts_count),
            'checkouts_count' => $accessory->checkouts_count,
            'created_by' => ($accessory->adminuser) ? [
                'id' => (int) $accessory->adminuser->id,
                'name' => e($accessory->adminuser->display_name),
            ] : null,
            'created_at' => Helper::getFormattedDateObject($accessory->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($accessory->updated_at, 'datetime'),

        ];

        // Whether the current caller has an open request against this
        // accessory. Drives the request/cancel button-swap on the
        // requestable tab. Only populates when the relation
        // was preloaded (which the requestable() endpoint does); the
        // standard index endpoint doesn't preload requests, so the
        // relationLoaded gate keeps a per-row query out of that path.
        $userHasOpenRequest = auth()->check() && $accessory->relationLoaded('requests') && $accessory->requests->contains(
            fn (\App\Models\CheckoutRequest $request) => $request->user_id === auth()->id() && $request->canceled_at === null
        );

        $permissions_array = [];
        $permissions_array['assigned_to_self'] = $userHasOpenRequest;

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', $accessory),
            'checkin' => false,
            'update' => Gate::allows('update', $accessory),
            'adjust_quantity' => Gate::allows('update', $accessory),
            'delete' => $accessory->checkouts_count === 0 && Gate::allows('delete', $accessory),
            'clone' => Gate::allows('clone', $accessory),
            // Request / cancel: if the requestable flag is off the row
            // never surfaces on /account/requestable anyway (scoped out
            // by Requestable()), but honor it here too for
            // any consumer hitting the standard index endpoint.
            'request' => (bool) $accessory->requestable && ! $userHasOpenRequest,
            'cancel' => (bool) $accessory->requestable && $userHasOpenRequest,
            'bulk_selectable' => [
                'delete' => $accessory->checkouts_count === 0,
            ],
        ];

        $permissions_array['user_can_checkout'] = false;

        if (($accessory->qty - $accessory->checkouts_count) > 0) {
            $permissions_array['user_can_checkout'] = true;
        }

        $array += $permissions_array;

        return $array;
    }

    public function transformRequestedAccessories(Collection $accessories, $total)
    {
        $array = [];
        foreach ($accessories as $accessory) {
            $array[] = self::transformRequestedAccessory($accessory);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRequestedAccessory(Accessory $accessory)
    {
        $userHasOpenRequest = auth()->check() && $accessory->relationLoaded('requests') && $accessory->requests->contains(
            fn (\App\Models\CheckoutRequest $request) => $request->user_id === auth()->id() && $request->canceled_at === null
        );

        return [
            'id' => (int) $accessory->id,
            'name' => e($accessory->name),
            'image' => ($accessory->image) ? Storage::disk('public')->url(FileStorage::Accessories->publicPath().e($accessory->image)) : null,
            'model_number' => ($accessory->model_number) ? e($accessory->model_number) : null,
            'location' => ($accessory->location) ? [
                'id' => (int) $accessory->location->id,
                'name' => e($accessory->location->name),
                'tag_color' => ($accessory->location->tag_color) ? e($accessory->location->tag_color) : null,
            ] : null,
            'qty' => ($accessory->qty) ? (int) $accessory->qty : null,
            'remaining' => (int) ($accessory->qty - $accessory->checkouts_count),
            'remaining_qty' => (int) ($accessory->qty - $accessory->checkouts_count),
            'requestable' => (bool) $accessory->requestable,
            'assigned_to_self' => $userHasOpenRequest,
            'available_actions' => [
                'request' => (bool) $accessory->requestable && ! $userHasOpenRequest,
                'cancel' => (bool) $accessory->requestable && $userHasOpenRequest,
            ],
        ];
    }

    public function transformCheckedoutAccessory($accessory_checkouts, $total)
    {
        $array = [];

        foreach ($accessory_checkouts as $checkout) {
            $array[] = [
                'id' => $checkout->id,
                'assigned_to' => $this->transformAssignedTo($checkout),
                'note' => $checkout->note ? e($checkout->note) : null,
                'created_by' => $checkout->adminuser ? [
                    'id' => (int) $checkout->adminuser->id,
                    'name' => e($checkout->adminuser->present()->fullName),
                ] : null,
                'created_at' => Helper::getFormattedDateObject($checkout->created_at, 'datetime'),
                'available_actions' => Gate::allows('checkout', $checkout->accessory) ? ['checkin' => true] : ['checkin' => false],
            ];
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssignedTo($accessoryCheckout)
    {
        if (is_null($accessoryCheckout->assigned)) {
            return null;
        }

        if ($accessoryCheckout->checkedOutToUser()) {
            return (new UsersTransformer)->transformUserCompact($accessoryCheckout->assigned);
        } elseif ($accessoryCheckout->checkedOutToLocation()) {
            return (new LocationsTransformer)->transformLocationCompact($accessoryCheckout->assigned);
        } elseif ($accessoryCheckout->checkedOutToAsset()) {
            return (new AssetsTransformer)->transformAssetCompact($accessoryCheckout->assigned);
        }
    }
}
