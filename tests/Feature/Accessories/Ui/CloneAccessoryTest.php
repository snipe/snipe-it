<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\Accessory;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

/**
 * The Orders refactor moved supplier / purchase_date / purchase_cost /
 * order_number off the Accessory parent row and onto Order+OrderItem.
 * Plain `clone $accessory` no longer carries those fields to the create
 * form, so operators using the clone-to-restock workflow lost prefill
 * on four fields they were relying on. getClone() reads back the
 * source item's most recent order (via HasOrders::lastOrderPrefill)
 * and sets those values onto the cloned in-memory model so the create
 * form pre-populates them again.
 */
class CloneAccessoryTest extends TestCase
{
    public function test_permission_required_to_clone_accessory(): void
    {
        $accessory = Accessory::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('clone/accessories', $accessory))
            ->assertForbidden();
    }

    public function test_create_permission_alone_is_not_enough_to_clone_accessory(): void
    {
        // Cloning renders the source accessory's data into the create form,
        // so a user with only accessories.create (no accessories.view)
        // must be blocked.
        $accessory = Accessory::factory()->create();

        $this->actingAs(User::factory()->createAccessories()->create())
            ->get(route('clone/accessories', $accessory))
            ->assertForbidden();
    }

    public function test_clone_page_renders(): void
    {
        $accessory = Accessory::factory()->create();

        $this->actingAs(User::factory()->cloneAccessories()->create())
            ->get(route('clone/accessories', $accessory))
            ->assertOk();
    }

    public function test_clone_prefills_supplier_and_order_context_from_last_order(): void
    {
        $supplier = Supplier::factory()->create();
        $source = Accessory::factory()
            ->withInitialAcquisition($supplier, 42.50, '2026-04-15')
            ->create(['qty' => 10]);

        $source->orderItems()->latest('id')->first()->order()->update([
            'order_number' => 'PO-CLONE-PREFILL-42',
        ]);

        $response = $this->actingAs(User::factory()->cloneAccessories()->create())
            ->get(route('clone/accessories', $source))
            ->assertOk();

        $response->assertSee('name="supplier_id"', false);
        $response->assertSee('value="'.$supplier->id.'"', false);
        $response->assertSee('name="order_number"', false);
        $response->assertSee('value="PO-CLONE-PREFILL-42"', false);
        $response->assertSee('name="purchase_date"', false);
        $response->assertSee('value="2026-04-15"', false);
        $response->assertSee('name="purchase_cost"', false);
        $response->assertSee('value="42.50"', false);
    }

    public function test_clone_leaves_prefill_fields_blank_when_source_has_no_order_history(): void
    {
        $source = Accessory::factory()->create(['qty' => 0]);

        $this->assertNull(
            $source->orderItems()->latest('id')->first(),
            'Expected qty=0 accessory to have no observer-written order (baseline for the no-history case).',
        );

        $response = $this->actingAs(User::factory()->cloneAccessories()->create())
            ->get(route('clone/accessories', $source))
            ->assertOk();

        $response->assertSee('name="order_number"', false);
        $response->assertDontSee('value="PO-', false);
    }
}
