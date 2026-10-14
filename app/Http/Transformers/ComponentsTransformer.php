<?php

namespace App\Http\Transformers;

use App\Enums\FileStorage;
use App\Helpers\Helper;
use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ComponentsTransformer
{
    public function transformComponents(Collection $components, $total)
    {
        $array = [];
        foreach ($components as $component) {
            $array[] = self::transformComponent($component);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformComponent(Component $component)
    {
        // See AccessoriesTransformer for the last-acquisition-with-fallback
        // resolution pattern for supplier / purchase_date / purchase_cost.
        $lastDefaults = $component->lastOrderDefaults();
        $lastSupplier = $component->lastAcquisitionSupplier();

        $array = [
            'id' => (int) $component->id,
            'name' => e($component->name),
            'image' => ($component->image) ? Storage::disk('public')->url(FileStorage::Components->publicPath().e($component->image)) : null,
            'qr_code_url' => route('qr_code/common', ['object_type' => 'components', 'id' => $component->id]),
            'serial' => ($component->serial) ? e($component->serial) : null,
            'location' => ($component->location) ? [
                'id' => (int) $component->location->id,
                'name' => e($component->location->name),
                'tag_color' => $component->location->tag_color ? e($component->location->tag_color) : null,
            ] : null,
            'qty' => ($component->qty != '') ? (int) $component->qty : null,
            'min_amt' => ($component->min_amt != '') ? (int) $component->min_amt : null,
            'category' => ($component->category) ? [
                'id' => (int) $component->category->id,
                'name' => e($component->category->name),
                'tag_color' => $component->category->tag_color ? e($component->category->tag_color) : null,
            ] : null,
            'supplier' => $lastSupplier ? [
                'id' => $lastSupplier->id,
                'name' => e($lastSupplier->name),
                'tag_color' => $lastSupplier->tag_color ? e($lastSupplier->tag_color) : null,
            ] : null,
            'manufacturer' => ($component->manufacturer) ? [
                'id' => $component->manufacturer->id,
                'name' => e($component->manufacturer->name),
                'tag_color' => $component->manufacturer->tag_color ? e($component->manufacturer->tag_color) : null,
            ] : null,
            'model_number' => ($component->model_number) ? e($component->model_number) : null,
            // See AccessoriesTransformer for why order_number is no longer
            // in the parent-level output.
            //
            // Distinct order numbers this component has been purchased on,
            // pulled from the eager-loaded orderItems.order relation
            // (Api\ComponentsController::index preloads it). Feeds the
            // datatable's ordersSummaryFormatter.
            'orders' => $component->orderItems->pluck('order.order_number')->filter()->unique()->values()->all(),
            'purchase_date' => ($lastDefaults['purchase_date'] ?? null) ? Helper::getFormattedDateObject($lastDefaults['purchase_date'], 'date') : null,
            'purchase_cost' => Helper::formatCurrencyOutput($lastDefaults['unit_cost'] ?? null),
            'total_cost' => Helper::formatCurrencyOutput($component->totalCostSum()),
            'remaining' => (int) $component->numRemaining(),
            'percent_remaining' => round($component->percentRemaining()),
            'company' => ($component->company) ? [
                'id' => (int) $component->company->id,
                'name' => e($component->company->name),
                'tag_color' => $component->company->tag_color ? e($component->company->tag_color) : null,
            ] : null,
            'notes' => ($component->notes) ? Helper::parseEscapedMarkedownInline($component->notes) : null,
            'requestable' => (bool) $component->requestable,
            'created_by' => ($component->adminuser) ? [
                'id' => (int) $component->adminuser->id,
                'name' => e($component->adminuser->display_name),
            ] : null,
            'created_at' => Helper::getFormattedDateObject($component->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($component->updated_at, 'datetime'),
            'user_can_checkout' => ($component->numRemaining() > 0) ? 1 : 0,
        ];

        // See AccessoriesTransformer for the assigned_to_self /
        // available_actions.request/cancel rationale. relationLoaded
        // gate keeps the standard-index path from firing an N+1 (only
        // the requestable() endpoint preloads `requests`).
        $userHasOpenRequest = auth()->check() && $component->relationLoaded('requests') && $component->requests->contains(
            fn (\App\Models\CheckoutRequest $request) => $request->user_id === auth()->id() && $request->canceled_at === null
        );
        $permissions_array = [];
        $permissions_array['assigned_to_self'] = $userHasOpenRequest;

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', $component),
            'checkin' => Gate::allows('checkin', $component),
            'update' => Gate::allows('update', $component),
            'adjust_quantity' => Gate::allows('update', $component),
            'clone' => Gate::allows('clone', $component),
            'delete' => $component->isDeletable(),
            'request' => (bool) $component->requestable && ! $userHasOpenRequest,
            'cancel' => (bool) $component->requestable && $userHasOpenRequest,
        ];
        $array += $permissions_array;

        return $array;
    }

    public function transformRequestedComponents(Collection $components, $total)
    {
        $array = [];
        foreach ($components as $component) {
            $array[] = self::transformRequestedComponent($component);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRequestedComponent(Component $component)
    {
        $userHasOpenRequest = auth()->check() && $component->relationLoaded('requests') && $component->requests->contains(
            fn (\App\Models\CheckoutRequest $request) => $request->user_id === auth()->id() && $request->canceled_at === null
        );

        return [
            'id' => (int) $component->id,
            'name' => e($component->name),
            'image' => ($component->image) ? Storage::disk('public')->url(FileStorage::Components->publicPath().e($component->image)) : null,
            'serial' => ($component->serial) ? e($component->serial) : null,
            'model_number' => ($component->model_number) ? e($component->model_number) : null,
            'location' => ($component->location) ? [
                'id' => (int) $component->location->id,
                'name' => e($component->location->name),
                'tag_color' => $component->location->tag_color ? e($component->location->tag_color) : null,
            ] : null,
            'qty' => ($component->qty != '') ? (int) $component->qty : null,
            'remaining' => (int) $component->numRemaining(),
            'requestable' => (bool) $component->requestable,
            'assigned_to_self' => $userHasOpenRequest,
            'available_actions' => [
                'request' => (bool) $component->requestable && ! $userHasOpenRequest,
                'cancel' => (bool) $component->requestable && $userHasOpenRequest,
            ],
        ];
    }

    public function transformCheckedoutComponents(Collection $components_assets, $total)
    {
        $array = [];
        foreach ($components_assets as $asset) {
            $array[] = [
                'assigned_pivot_id' => (int) $asset->pivot->id,
                'name' => $this->transformAssignedTo($asset),
                'qty' => $asset->pivot->assigned_qty, // legacy?
                'assigned_qty' => $asset->pivot->assigned_qty,
                'note' => ($asset->pivot->note) ? e($asset->pivot->note) : null,
                'created_at' => Helper::getFormattedDateObject($asset->pivot->created_at, 'datetime'),
                'available_actions' => ['checkin' => true],
            ];
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssignedTo($componentCheckout)
    {
        return (new AssetsTransformer)->transformAssetCompact($componentCheckout);
    }
}
