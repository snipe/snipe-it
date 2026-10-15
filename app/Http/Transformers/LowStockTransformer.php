<?php

namespace App\Http\Transformers;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

/**
 * Normalizes low-stock rows for the dashboard widget's bs-table and any
 * other surface (email digests, exports) that wants the same shape.
 *
 * Consumes the array-of-arrays output of Helper::checkLowInventory() —
 * the same query that powers the top-nav alert bell — so the two
 * surfaces can't drift out of sync. Each input row already carries a
 * plural type discriminator ("consumables", "accessories", ...);
 * we singularize it to match polymorphicItemFormatter's expectation on
 * the frontend.
 *
 * Fields output per row:
 *   - id: composite "consumable-5" so bs-table has a unique row key
 *         across the five source tables (numeric ids collide)
 *   - item: { id, name, type, deleted_at } for polymorphicItemFormatter
 *   - qty / min_amt / remaining / percent: raw numbers
 *   - available_actions.adjust_quantity: per-type policy check;
 *     AssetModels and Licenses always get false (no adjust-quantity
 *     flow exists on those models today)
 */
class LowStockTransformer
{
    /**
     * Map the helper's plural type discriminators to the singular form
     * polymorphicItemFormatter expects. Anything not in this map falls
     * through as-is and will render without an icon.
     */
    private const TYPE_SINGULAR = [
        'consumables' => 'consumable',
        'accessories' => 'accessory',
        'components' => 'component',
        'models' => 'model',
        'licenses' => 'license',
    ];

    /**
     * The models that expose an adjust-quantity flow via the shared
     * blade/modals/adjust-quantity modal. AssetModels and Licenses use
     * different provisioning flows and don't participate.
     */
    private const ADJUST_QUANTITY_MODELS = [
        'consumable' => Consumable::class,
        'accessory' => Accessory::class,
        'component' => Component::class,
    ];

    /**
     * @param  array<int, array<string, mixed>>  $rows  as returned by Helper::checkLowInventory()
     */
    public function transformLowStockItems(array $rows, int $total): array
    {
        $out = [];
        foreach ($rows as $row) {
            $out[] = $this->transformLowStockItem($row);
        }

        return (new DatatablesTransformer)->transformDatatables($out, $total);
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    public function transformLowStockItem(array $row): array
    {
        $type = self::TYPE_SINGULAR[$row['type']] ?? $row['type'];
        $modelClass = self::ADJUST_QUANTITY_MODELS[$type] ?? null;

        return [
            'id' => $type.'-'.$row['id'],
            'item' => [
                'id' => (int) $row['id'],
                'name' => e($row['name']),
                'type' => $type,
                'deleted_at' => null,
            ],
            'qty' => (int) ($row['qty'] ?? 0),
            'min_amt' => (int) $row['min_amt'],
            'remaining' => (int) $row['remaining'],
            'percent' => (int) $row['percent'],
            'available_actions' => [
                'adjust_quantity' => $modelClass !== null && Gate::allows('update', $modelClass),
            ],
        ];
    }

    /**
     * Type-check for models that support in-place quantity adjustment.
     * Referenced from AssetModel + License classes when the transformer
     * needs to gate icon rendering; kept as a separate const so it's
     * easy to extend if another source model joins the flow.
     *
     * @return array<string, class-string>
     */
    public static function adjustQuantityModels(): array
    {
        return self::ADJUST_QUANTITY_MODELS;
    }

    /**
     * @return array<int, class-string>
     */
    public static function sourceModels(): array
    {
        return [
            Consumable::class,
            Accessory::class,
            Component::class,
            AssetModel::class,
            License::class,
        ];
    }

    /**
     * Drop rows from a Helper::checkLowInventory() result the given
     * viewer can't `view` per the model's policy. A viewer with only
     * accessories.view sees only accessory rows. Null viewer sees
     * nothing. The plural type-to-class map lives on Controller as
     * $map_object_type (shared across the app). Rows whose plural
     * type isn't in that map fall through gated on nothing, matching
     * pre-filter behavior.
     *
     * @param  array<int, array{type: string}>  $rows
     * @return array<int, array<string, mixed>>
     */
    public static function viewableByCaller(array $rows, ?User $viewer): array
    {
        if ($viewer === null) {
            return [];
        }

        $map = Controller::$map_object_type;

        return array_values(array_filter(
            $rows,
            fn ($row) => ! isset($map[$row['type']]) || $viewer->can('view', $map[$row['type']]),
        ));
    }
}
