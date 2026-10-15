<?php

use App\Models\License;
use App\Models\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Backfill the Orders / OrderItems tables from every pre-existing
 * inventory row on accessories, consumables, components, and assets.
 * Every source row becomes an OrderItem so the polymorphic ledger is
 * complete after the migration runs — the reconcile migration
 * (`2026_08_03_144000_...`) relies on every row having at least one
 * OrderItem to represent its starting qty.
 *
 * Rows with a non-null order_number dedupe on
 * (order_number, supplier_id, company_id) so multiple inventory lines
 * placed against the same PO collapse under one shared Order. A raw
 * string like "PO-42" can legitimately recur across different suppliers
 * or across companies in FMCS installs, so the supplier and company
 * are part of the dedupe key.
 *
 * Rows with a null / empty order_number get a fresh Order per row (no
 * dedupe). Blank order_number is a distinct transaction each time, not
 * a bucket to pool anonymous acquisitions into — same convention as
 * HandlesAdjustQuantity::resolveOrderForAdjustment at runtime.
 *
 * Licenses are intentionally out of scope. Per-seat product-key
 * semantics need their own design pass before License can join the
 * Orders flow cleanly.
 *
 * The follow-up rename migration (`2026_08_03_143000_...`) renames the
 * source columns to `legacy_*` names once this backfill has run.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Order dedupe cache: (order_number|supplier_id|company_id) => order_id.
        // Keeps us from hitting the DB with a lookup per source row.
        $orderIndex = [];

        // Order.currency stays NULL for backfilled rows. The source
        // inventory tables didn't have their own currency column, and
        // stamping every historical Order with today's system
        // default_currency would fabricate information we don't
        // actually have, orders placed years ago may have been in a
        // different currency than the install's current setting.
        // Downstream display code can fall back to
        // $snipeSettings->default_currency at render time (matching how
        // the pre-Orders info panels rendered purchase_cost anyway).
        //
        // Order iteration is purely cosmetic: a chronological report
        // would sort by Order.purchase_date or Order.created_at.
        //
        // License is filtered out because per-seat product-key
        // semantics need their own design pass before License can join
        // the Orders flow cleanly.
        $sourceClasses = array_diff(OrderItem::ITEM_TYPES, [License::class]);

        foreach ($sourceClasses as $modelClass) {
            $table = (new $modelClass)->getTable();

            // Defensive skip: if a source table has already had its
            // order_number column dropped (partial rerun, hand rollback,
            // schema drift), there's nothing to backfill from and the
            // migration should keep moving rather than blow up.
            if (! Schema::hasColumn($table, 'order_number')) {
                continue;
            }

            $hasQtyColumn = Schema::hasColumn($table, 'qty');

            DB::table($table)
                ->select([
                    'id',
                    'order_number',
                    'supplier_id',
                    'company_id',
                    'purchase_date',
                    'purchase_cost',
                    'created_by',
                    'created_at',
                ])
                ->orderBy('id')
                ->chunkById(500, function ($rows) use ($modelClass, $table, $hasQtyColumn, &$orderIndex) {
                    // Chunked pull grabs qty separately since assets
                    // don't have a qty column (1:1 with the asset row)
                    // and the primary select stays portable across the
                    // four source tables.
                    $qtyMap = $hasQtyColumn
                        ? DB::table($table)
                            ->whereIn('id', $rows->pluck('id'))
                            ->pluck('qty', 'id')
                            ->all()
                        : [];

                    foreach ($rows as $row) {
                        $hasOrderNumber = $row->order_number !== null && $row->order_number !== '';

                        if ($hasOrderNumber) {
                            $key = $row->order_number
                                .'|'.($row->supplier_id ?? '')
                                .'|'.($row->company_id ?? '');

                            if (! array_key_exists($key, $orderIndex)) {
                                $orderIndex[$key] = DB::table('orders')->insertGetId([
                                    'order_number' => $row->order_number,
                                    'supplier_id' => $row->supplier_id,
                                    'company_id' => $row->company_id,
                                    'purchase_date' => $row->purchase_date,
                                    'created_by' => $row->created_by,
                                    'created_at' => $row->created_at ?? now(),
                                    'updated_at' => $row->created_at ?? now(),
                                ]);
                            }
                            $orderId = $orderIndex[$key];
                        } else {
                            // No order_number → fresh Order per row.
                            // Matches the runtime convention in
                            // HandlesAdjustQuantity::resolveOrderForAdjustment.
                            $orderId = DB::table('orders')->insertGetId([
                                'order_number' => null,
                                'supplier_id' => $row->supplier_id,
                                'company_id' => $row->company_id,
                                'purchase_date' => $row->purchase_date,
                                'created_by' => $row->created_by,
                                'created_at' => $row->created_at ?? now(),
                                'updated_at' => $row->created_at ?? now(),
                            ]);
                        }

                        DB::table('order_items')->insert([
                            'order_id' => $orderId,
                            'item_type' => $modelClass,
                            'item_id' => $row->id,
                            'qty' => max(1, (int) ($qtyMap[$row->id] ?? 1)),
                            'price' => $row->purchase_cost,
                            'created_by' => $row->created_by,
                            'created_at' => $row->created_at ?? now(),
                            'updated_at' => $row->created_at ?? now(),
                        ]);
                    }
                });
        }
    }

    public function down(): void
    {
        // Reversible only in a coarse sense: the delete wipes every row
        // in both tables rather than trying to reconstruct the original
        // per-source-column state. Combined with the follow-up
        // rename-columns migration (143000, which does have a real
        // down() that restores the original column names), a full
        // rollback restores the pre-Orders layout.
        DB::table('order_items')->delete();
        DB::table('orders')->delete();
    }
};
