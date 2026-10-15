<?php

namespace Tests\Feature\Consumables\Ui;

use App\Models\Consumable;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

/**
 * Consumable mirror of CloneAccessoryTest. See that file for the
 * Orders-refactor rationale behind the clone-prefill fix.
 */
class CloneConsumableTest extends TestCase
{
    public function test_permission_required_to_clone_consumable(): void
    {
        $consumable = Consumable::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('consumables.clone.create', $consumable))
            ->assertForbidden();
    }

    public function test_create_permission_alone_is_not_enough_to_clone_consumable(): void
    {
        $consumable = Consumable::factory()->create();

        $this->actingAs(User::factory()->createConsumables()->create())
            ->get(route('consumables.clone.create', $consumable))
            ->assertForbidden();
    }

    public function test_clone_page_renders(): void
    {
        $consumable = Consumable::factory()->create();

        $this->actingAs(User::factory()->cloneConsumables()->create())
            ->get(route('consumables.clone.create', $consumable))
            ->assertOk();
    }

    public function test_clone_prefills_supplier_and_order_context_from_last_order(): void
    {
        $supplier = Supplier::factory()->create();
        $source = Consumable::factory()
            ->withInitialAcquisition($supplier, 5.75, '2026-05-10')
            ->create(['qty' => 20]);

        $source->orderItems()->latest('id')->first()->order()->update([
            'order_number' => 'PO-CONS-CLONE-1',
        ]);

        $response = $this->actingAs(User::factory()->cloneConsumables()->create())
            ->get(route('consumables.clone.create', $source))
            ->assertOk();

        $response->assertSee('name="supplier_id"', false);
        $response->assertSee('value="'.$supplier->id.'"', false);
        $response->assertSee('name="order_number"', false);
        $response->assertSee('value="PO-CONS-CLONE-1"', false);
        $response->assertSee('name="purchase_date"', false);
        $response->assertSee('value="2026-05-10"', false);
        $response->assertSee('name="purchase_cost"', false);
        $response->assertSee('value="5.75"', false);
    }
}
