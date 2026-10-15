<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Acquisition-transaction data model. `orders` is one row per
 * transaction (a supplier, a date, an optional supplier-issued
 * `order_number`, a currency). `order_items` is the polymorphic line
 * items on that transaction so a single acquisition can carry
 * accessories, consumables, components, and assets side by side.
 *
 * Replaces the parent-level `order_number` column that used to live on
 * each inventory table. The old column misrepresented current state on
 * models that get replenished across many transactions (accessories,
 * consumables, components). The dedicated Order model + polymorphic
 * line items records each transaction independently and lets
 * action_logs point at the Order for per-event acquisition context
 * rather than carrying a raw string.
 *
 * Explicitly NOT a purchase-order workflow (no state machine, no
 * approvals, no receiving). Just the "what was acquired, when, from
 * whom" record that the adjust-quantity flow, the AssetObserver, and
 * the CSV importers write to.
 *
 * Licenses are intentionally out of scope for this migration —
 * per-seat product-key semantics need their own design pass before
 * the License model can join the Orders flow cleanly.
 *
 * No UI or permission model is included yet. Rows arrive via the
 * adjust-quantity flow, the importer, and the backfill migrations that
 * follow this one.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            // Parent-level FMCS scope — a PO belongs to the company that
            // placed it. Same convention as accessories.company_id /
            // consumables.company_id / etc. so CompanyableScope hooks
            // through cleanly if / when this model opts into it.
            $table->unsignedBigInteger('company_id')->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('notes')->nullable();
            // string(10) matches locations.currency / settings.default_currency.
            // Order-level, not OrderItem-level: a single acquisition happens
            // in one currency, and mixing per-line currencies would defeat
            // the point of the Order aggregation.
            $table->string('currency', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Free-text search on inventory models hits order_number
            // through the polymorphic order_items relation, so the join
            // needs a fast index. Same for the supplier and company
            // filters used by FMCS scoping.
            $table->index('order_number');
            $table->index('supplier_id');
            $table->index('company_id');
            $table->index('created_by');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            // Polymorphic pointer at the inventory row this line refers
            // to. Uses the same shape as action_logs.item_type /
            // action_logs.item_id so the two tables read consistently.
            $table->string('item_type');
            $table->unsignedBigInteger('item_id');
            $table->integer('qty')->default(1);
            // (20,4) matches the widest precision already in use in the
            // code (components.purchase_cost). Covers 3-decimal
            // currencies and low-per-unit fractional prices without
            // rounding drift on aggregate totals.
            $table->decimal('price', 20, 4)->nullable();
            // Per-line authorship. Order.created_by records who opened
            // the transaction, but a single Order can accumulate lines
            // from multiple operators over time (Alice writes two lines
            // under Order-42, Bob replenishes with three more under the
            // same Order-42 later). Storing created_by on the OrderItem
            // itself preserves that per-line context. Nullable so
            // backfill rows written from parent inventory tables
            // without a captured actor don't fail.
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            // SoftDeletes so a force-delete on a referenced inventory
            // row (Accessory / Consumable / Component / Asset / License)
            // can trash the OrderItem line without losing the
            // acquisition ledger. HasOrders::bootHasOrders() wires the
            // observer that flips this flag on parent force-delete.
            $table->softDeletes();

            $table->index('order_id');
            $table->index(['item_type', 'item_id']);
            $table->index('created_by');
        });

        // FK from every action_log row that references a specific
        // acquisition line (today that's just QuantityAdjust events;
        // other action types can adopt it as they grow acquisition
        // semantics). Points at order_items, not orders — a single
        // Order deduped across staggered receipts under one order_number
        // carries multiple lines, and the log entry has to reach the
        // exact line for its event, not just the shared Order header.
        // Plain bigint + index, no DB-level FK constraint per Snipe-IT
        // convention (schema shifts often enough that constraints cause
        // churn).
        Schema::table('action_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable()->after('quantity');
            $table->index('order_item_id');
        });
    }

    public function down(): void
    {
        Schema::table('action_logs', function (Blueprint $table) {
            $table->dropIndex(['order_item_id']);
            $table->dropColumn('order_item_id');
        });
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
