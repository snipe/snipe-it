<?php

namespace Tests\Feature\Accessories\Api;

use App\Enums\ActionType;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

/**
 * Order-side behavior of the adjust-quantity endpoint. Covers when an
 * Order + OrderItem is written (positive delta only), the dedup rule
 * on (order_number, supplier_id, company_id, purchase_date), and the
 * split of anonymous receipts. Sibling to AdjustAccessoryQuantityApiTest,
 * which covers the action_log + qty side of the same endpoint.
 */
class AdjustAccessoryOrderRecordingTest extends TestCase
{
    public function test_supplier_purchase_date_unit_cost_and_currency_land_on_order_and_order_item()
    {
        $accessory = Accessory::factory()->create(['qty' => 2]);
        $supplier = Supplier::factory()->create();

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 5,
                'note' => 'PO arrived',
                'order_number' => 'PO-FULL-META',
                'supplier_id' => $supplier->id,
                'purchase_date' => '2026-03-15',
                'unit_cost' => 12.3456,
                'currency' => 'EUR',
            ])
            ->assertOk();

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $order = $log->orderItem->order;
        $this->assertSame('PO-FULL-META', $order->order_number);
        $this->assertSame($supplier->id, (int) $order->supplier_id);
        $this->assertSame('2026-03-15', $order->purchase_date->toDateString());
        $this->assertSame('EUR', $order->currency);

        $line = $order->orderItems()->firstOrFail();
        $this->assertSame(Accessory::class, $line->item_type);
        $this->assertSame($accessory->id, (int) $line->item_id);
        $this->assertSame(5, (int) $line->qty);
        $this->assertEquals(12.3456, (float) $line->price);
    }

    public function test_audit_only_zero_delta_with_no_order_metadata_skips_order_creation()
    {
        // Zero delta and no supplier / order number / date / cost /
        // currency = pure inventory audit. No Order row should be
        // created for these, since there was no transaction.
        $accessory = Accessory::factory()->create(['qty' => 5]);
        $ordersBefore = Order::count();

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 0,
                'note' => 'shelf count matches',
            ])
            ->assertOk();

        $this->assertSame($ordersBefore, Order::count());

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertNull($log->order_item_id);
    }

    public function test_multiple_adjusts_with_same_order_number_dedupe_to_one_order()
    {
        // Repeated qty adjusts referencing the same order_number should
        // reuse the existing Order row (dedupe on order_number +
        // supplier + company + purchase_date), while each adjust still
        // produces its own OrderItem line (one line per event).
        $accessory = Accessory::factory()->create(['qty' => 0]);
        $supplier = Supplier::factory()->create();
        $actor = User::factory()->editAccessories()->create();

        foreach ([3, 4] as $delta) {
            $this->actingAsForApi($actor)
                ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                    'amount' => $delta,
                    'note' => 'same receipt, split line',
                    'order_number' => 'ORD-DEDUPE',
                    'supplier_id' => $supplier->id,
                    'purchase_date' => '2026-04-01',
                ])
                ->assertOk();
        }

        $orders = Order::where('order_number', 'ORD-DEDUPE')->get();
        $this->assertCount(1, $orders, 'Same order_number + supplier + date should reuse the existing Order row.');

        $items = $orders->first()->orderItems;
        $this->assertCount(2, $items, 'Each adjust event should have its own OrderItem line.');
        $this->assertEqualsCanonicalizing([3, 4], $items->pluck('qty')->map(fn ($q) => (int) $q)->all());
    }

    public function test_same_order_number_on_different_purchase_dates_creates_distinct_orders()
    {
        // Snipe-IT has no partial-receipt concept. Every Order is a
        // completed receipt-in-hand, so the same order_number appearing
        // with two different purchase_dates represents two distinct
        // events and each gets its own Order row.
        $accessory = Accessory::factory()->create(['qty' => 0]);
        $supplier = Supplier::factory()->create();
        $actor = User::factory()->editAccessories()->create();

        foreach (['2026-04-01', '2026-04-15'] as $date) {
            $this->actingAsForApi($actor)
                ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                    'amount' => 5,
                    'note' => 'later receipt on same order number',
                    'order_number' => 'ORD-SPLIT-DATE',
                    'supplier_id' => $supplier->id,
                    'purchase_date' => $date,
                ])
                ->assertOk();
        }

        $this->assertSame(
            2,
            Order::where('order_number', 'ORD-SPLIT-DATE')->count(),
            'Different purchase_dates under the same order_number should be distinct Orders.',
        );
    }

    public function test_blank_order_number_creates_a_distinct_order_per_event()
    {
        // A blank order_number is a distinct transaction each time, not
        // a bucket to pool anonymous receipts into. Each adjust with
        // no order_number gets its own Order row.
        $accessory = Accessory::factory()->create(['qty' => 0]);
        $supplier = Supplier::factory()->create();
        $actor = User::factory()->editAccessories()->create();
        $ordersBefore = Order::count();

        foreach ([2, 3] as $delta) {
            $this->actingAsForApi($actor)
                ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                    'amount' => $delta,
                    'note' => 'anonymous receipt',
                    'supplier_id' => $supplier->id,
                ])
                ->assertOk();
        }

        $this->assertSame($ordersBefore + 2, Order::count());
    }
}
