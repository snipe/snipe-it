<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

/**
 * AssetObserver::created writes a matching Order + OrderItem for every
 * new asset regardless of how the asset arrived (web form, API, CSV
 * importer). Dedupe semantics match the adjust-quantity flow: a
 * populated order_number shares the Order row with same-tuple assets,
 * a blank one gets its own Order per event.
 */
class AssetObserverOrderTest extends TestCase
{
    public function test_asset_create_with_order_number_writes_matching_order_and_order_item(): void
    {
        $actor = User::factory()->createAssets()->create();
        $supplier = Supplier::factory()->create();

        $asset = Asset::factory()->create([
            'created_by' => $actor->id,
            'company_id' => $actor->company_id,
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-OBS-1',
            'purchase_date' => '2026-04-01',
            'purchase_cost' => 199.99,
        ]);

        $line = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->firstOrFail();

        $this->assertSame(1, (int) $line->qty);
        $this->assertEquals(199.99, (float) $line->price);

        $order = Order::findOrFail($line->order_id);
        $this->assertSame('PO-OBS-1', $order->order_number);
        $this->assertSame($supplier->id, (int) $order->supplier_id);
        $this->assertSame($actor->company_id, $order->company_id);
        $this->assertSame('2026-04-01', $order->purchase_date->toDateString());
    }

    public function test_two_assets_with_same_order_tuple_share_one_order_row(): void
    {
        $actor = User::factory()->createAssets()->create();
        $supplier = Supplier::factory()->create();

        $shared = [
            'created_by' => $actor->id,
            'company_id' => $actor->company_id,
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-OBS-SHARED',
            'purchase_date' => '2026-04-02',
        ];

        $first = Asset::factory()->create($shared + ['purchase_cost' => 100]);
        $second = Asset::factory()->create($shared + ['purchase_cost' => 200]);

        $orders = Order::where('order_number', 'PO-OBS-SHARED')
            ->where('supplier_id', $supplier->id)
            ->where('company_id', $actor->company_id)
            ->get();

        $this->assertCount(1, $orders, 'Same (order_number, supplier, company) tuple must dedupe.');

        $lineIds = OrderItem::where('item_type', Asset::class)
            ->whereIn('item_id', [$first->id, $second->id])
            ->pluck('order_id')
            ->unique()
            ->values();

        $this->assertCount(1, $lineIds);
        $this->assertSame($orders->first()->id, (int) $lineIds->first());
    }

    public function test_blank_order_number_creates_a_distinct_order_per_asset(): void
    {
        $actor = User::factory()->createAssets()->create();
        $supplier = Supplier::factory()->create();
        $ordersBefore = Order::count();

        $shared = [
            'created_by' => $actor->id,
            'company_id' => $actor->company_id,
            'supplier_id' => $supplier->id,
            'order_number' => null,
        ];

        Asset::factory()->create($shared);
        Asset::factory()->create($shared);

        // Blank order_number = distinct transaction, so both assets get
        // their own Order rows even though supplier + company match.
        $this->assertSame($ordersBefore + 2, Order::count());
    }

    public function test_asset_purchase_cost_change_syncs_to_linked_order_item(): void
    {
        // #19564 sync: editing purchase_cost on a saved asset (single
        // edit, bulk edit, importer update, or API) must write through
        // to the linked OrderItem's price so order-side reads don't
        // diverge from the current asset row.
        $supplier = Supplier::factory()->create();

        $asset = Asset::factory()->create([
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-EDIT-COST',
            'purchase_cost' => 100.00,
        ]);

        $asset->purchase_cost = 175.50;
        $asset->save();

        $line = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->firstOrFail();

        $this->assertEquals(175.50, (float) $line->price);
    }

    public function test_asset_order_number_change_repoints_line_and_cleans_up_orphan(): void
    {
        // Rename an asset's order_number. The asset's OrderItem must
        // detach from the old Order, attach to a firstOrNew'd Order
        // matching the new (order_number, supplier_id, company_id)
        // tuple, and the old Order must be deleted when it's left
        // with no other OrderItems.
        $supplier = Supplier::factory()->create();

        $asset = Asset::factory()->create([
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-OLD',
        ]);

        $oldOrderId = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->value('order_id');

        $this->assertNotNull(Order::find($oldOrderId));

        $asset->order_number = 'PO-NEW';
        $asset->save();

        $line = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->firstOrFail();

        $newOrder = Order::find($line->order_id);

        $this->assertSame('PO-NEW', $newOrder->order_number);
        $this->assertNotSame($oldOrderId, $line->order_id);
        $this->assertNull(Order::find($oldOrderId), 'The old Order should be deleted after the only OrderItem moves away.');
    }

    public function test_asset_order_number_change_preserves_old_order_when_it_has_siblings(): void
    {
        // Two assets share PO-SHARED. Rename asset A to PO-NEW. Old
        // Order (PO-SHARED) must survive because asset B still points
        // at it.
        $supplier = Supplier::factory()->create();

        $assetA = Asset::factory()->create([
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-SHARED',
        ]);
        $assetB = Asset::factory()->create([
            'supplier_id' => $supplier->id,
            'company_id' => $assetA->company_id,
            'order_number' => 'PO-SHARED',
        ]);

        $sharedOrderId = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $assetA->id)
            ->value('order_id');

        $this->assertSame(
            $sharedOrderId,
            OrderItem::where('item_type', Asset::class)->where('item_id', $assetB->id)->value('order_id'),
            'Precondition: both assets share the same Order.',
        );

        $assetA->order_number = 'PO-NEW';
        $assetA->save();

        $this->assertNotNull(Order::find($sharedOrderId), 'The old Order must survive because asset B still references it.');
    }

    public function test_unrelated_save_does_not_touch_the_linked_order_item(): void
    {
        // Sanity: touching a field other than purchase_cost /
        // order_number leaves the OrderItem's price and order_id
        // completely untouched.
        $supplier = Supplier::factory()->create();

        $asset = Asset::factory()->create([
            'supplier_id' => $supplier->id,
            'order_number' => 'PO-NOTES',
            'purchase_cost' => 42.00,
        ]);

        $originalLine = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->firstOrFail();

        $asset->notes = 'edited notes';
        $asset->save();

        $freshLine = OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->firstOrFail();

        $this->assertSame($originalLine->id, $freshLine->id);
        $this->assertSame($originalLine->order_id, $freshLine->order_id);
        $this->assertEquals((float) $originalLine->price, (float) $freshLine->price);
    }
}
