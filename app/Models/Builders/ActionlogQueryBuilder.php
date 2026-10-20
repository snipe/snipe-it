<?php

namespace App\Models\Builders;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Department;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\Manufacturer;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\User;
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
     * item_type=Asset. For the polymorphic activity report, use
     * orderByItemTypeAndId instead.
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

    /**
     * This is genuinely awful, but...
     *
     * Alphabetical polymorphic item-name sort for the activity report
     * (#17288). action_logs.item is a polymorphic morphTo across every
     * entity on the install, so there is no cross-type "name" column
     * to ORDER BY. This LEFT JOINs each possible item_type table on
     * (item_id, item_type) and COALESCEs the per-type name expression,
     * so each row contributes exactly one non-null name value and the
     * query orders by that merged value.
     *
     * Per-type expressions handle the entities whose display name is
     * not just `name`: Asset falls back to asset_tag when name is
     * null, User concatenates first_name + last_name when display_name
     * is empty, LicenseSeat has no name column of its own so a second
     * JOIN to the parent license surfaces the license name.
     *
     * The joins are selective (each ON predicate includes the item_type
     * match, so a given action_logs row only joins to one child table)
     * and non-multiplying (one match per row at most), so count() and
     * pagination behavior are unaffected.
     */
    public function orderByPolymorphicItemName(string $order): self
    {
        $order = strtolower($order) === 'desc' ? 'desc' : 'asc';

        // Honor name_display_format for the User case so last-first
        // locales (Hungarian, CJK) sort users the same way the UI
        // reads them. display_name is user-authored so it ships as-is
        // regardless of locale. Only the first_name+last_name fallback
        // flips. #19626.
        //
        // NULLIF around display_name mirrors the User model's
        // display_name accessor, which falls back to the full name when
        // the stored value is empty. ConvertEmptyStringsToNull turns ''
        // into null on HTTP writes, but factory, seeder, and import
        // paths can land an actual '' in the column.
        $userNameExpr = Setting::getSettings()?->name_display_format === 'last_first'
            ? "COALESCE(NULLIF(poly_user.display_name, ''), CONCAT(poly_user.last_name, ' ', poly_user.first_name))"
            : "COALESCE(NULLIF(poly_user.display_name, ''), CONCAT(poly_user.first_name, ' ', poly_user.last_name))";

        $types = [
            [Accessory::class, 'accessories', 'poly_accessory', 'poly_accessory.name'],
            [Asset::class, 'assets', 'poly_asset', "COALESCE(NULLIF(poly_asset.name, ''), poly_asset.asset_tag)"],
            [AssetModel::class, 'models', 'poly_assetmodel', 'poly_assetmodel.name'],
            [Category::class, 'categories', 'poly_category', 'poly_category.name'],
            [Company::class, 'companies', 'poly_company', 'poly_company.name'],
            [Component::class, 'components', 'poly_component', 'poly_component.name'],
            [Consumable::class, 'consumables', 'poly_consumable', 'poly_consumable.name'],
            [Department::class, 'departments', 'poly_department', 'poly_department.name'],
            [License::class, 'licenses', 'poly_license', 'poly_license.name'],
            [Location::class, 'locations', 'poly_location', 'poly_location.name'],
            [Maintenance::class, 'maintenances', 'poly_maintenance', 'poly_maintenance.name'],
            [Manufacturer::class, 'manufacturers', 'poly_manufacturer', 'poly_manufacturer.name'],
            [Supplier::class, 'suppliers', 'poly_supplier', 'poly_supplier.name'],
            [User::class, 'users', 'poly_user', $userNameExpr],
        ];

        $query = $this;
        $nameExprs = [];
        foreach ($types as [$classString, $table, $alias, $nameExpr]) {
            $query = $query->leftJoin($table.' as '.$alias, function ($join) use ($alias, $classString) {
                $join->on('action_logs.item_id', '=', $alias.'.id')
                    ->where('action_logs.item_type', '=', $classString);
            });
            $nameExprs[] = $nameExpr;
        }

        // LicenseSeat has no name column of its own, so the join lands
        // on the seat row and a second join surfaces the parent license
        // name. The ON predicate for the seat join still carries the
        // item_type gate, so this pair of joins only fires on seat
        // rows and poly_seat_license.name is null on everything else.
        $query = $query
            ->leftJoin('license_seats as poly_license_seat', function ($join) {
                $join->on('action_logs.item_id', '=', 'poly_license_seat.id')
                    ->where('action_logs.item_type', '=', LicenseSeat::class);
            })
            ->leftJoin('licenses as poly_seat_license', 'poly_license_seat.license_id', '=', 'poly_seat_license.id');
        $nameExprs[] = 'poly_seat_license.name';

        return $query
            ->addSelect('action_logs.*')
            ->orderByRaw('COALESCE('.implode(', ', $nameExprs).') '.$order);
    }
}
