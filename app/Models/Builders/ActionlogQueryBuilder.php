<?php

namespace App\Models\Builders;

use App\Models\Actionlog;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @template TModel of Actionlog
 *
 * @extends Builder<TModel>
 */
class ActionlogQueryBuilder extends Builder
{
    /**
     * Eager load history relations used by the API transformer to avoid
     * N+1 queries.
     */
    public function forApiHistory(): self
    {
        return $this->with([
            'adminuser',
            'location',
            'item' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Asset::class => ['model'],
                ]);
            },
            'target' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Asset::class => ['model'],
                ]);
            },
        ]);
    }

    public function orderByCreatedBy(string $order): self
    {
        return $this
            ->leftJoin('users as admin_sort', 'action_logs.created_by', '=', 'admin_sort.id')
            ->addSelect('action_logs.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }

    public function orderByLocation(string $order): self
    {
        return $this
            ->leftJoin('locations as location_sort', 'action_logs.location_id', '=', 'location_sort.id')
            ->addSelect('action_logs.*')
            ->orderBy('location_sort.name', $order);
    }

    public function orderByAssetNextAuditDate(string $order): self
    {
        return $this
            ->leftJoin('assets as asset_sort', function ($join) {
                $join->on('action_logs.item_id', '=', 'asset_sort.id')
                    ->where('action_logs.item_type', '=', Asset::class);
            })
            ->addSelect('action_logs.*')
            ->orderBy('asset_sort.next_audit_date', $order);
    }

    /**
     * Item name sort for the audit report (#9430). Only Assets get
     * audited, so the action_type=audit filter upstream guarantees
     * item_type=Asset. Fixing truly-polymorphic item sort is a bigger
     * change.
     */
    public function orderByItemName(string $order): self
    {
        return $this
            ->leftJoin('assets as asset_item_sort', function ($join) {
                $join->on('action_logs.item_id', '=', 'asset_item_sort.id')
                    ->where('action_logs.item_type', '=', Asset::class);
            })
            ->addSelect('action_logs.*')
            ->orderBy('asset_item_sort.name', $order);
    }
}
