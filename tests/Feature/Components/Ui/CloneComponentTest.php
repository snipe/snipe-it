<?php

namespace Tests\Feature\Components\Ui;

use App\Models\Component;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class CloneComponentTest extends TestCase
{
    public function test_permission_required_to_create_component()
    {
        $component = Component::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('components.clone.create', $component))
            ->assertForbidden();
    }

    public function test_create_permission_alone_is_not_enough_to_clone_component()
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->createComponents()->create())
            ->get(route('components.clone.create', $component))
            ->assertForbidden();
    }

    public function test_page_can_be_accessed(): void
    {
        $component = Component::factory()->create();
        $response = $this->actingAs(User::factory()->cloneComponents()->create())
            ->get(route('components.clone.create', $component));
        $response->assertStatus(200);
    }

    public function test_component_can_be_cloned()
    {
        $component_to_clone = Component::factory()->create(['name' => 'Component to clone']);
        $this->actingAs(User::factory()->cloneComponents()->create())
            ->get(route('components.clone.create', $component_to_clone))
            ->assertOk()
            ->assertSee([
                'Component to clone',
            ], false);
    }

    /**
     * See tests/Feature/Accessories/Ui/CloneAccessoryTest for the
     * Orders-refactor rationale behind the clone-prefill fix.
     */
    public function test_clone_prefills_supplier_and_order_context_from_last_order(): void
    {
        $supplier = Supplier::factory()->create();
        $source = Component::factory()
            ->withInitialAcquisition($supplier, 12.34, '2026-04-01')
            ->create(['qty' => 5]);

        $source->orderItems()->latest('id')->first()->order()->update([
            'order_number' => 'PO-COMP-CLONE-9',
        ]);

        $response = $this->actingAs(User::factory()->cloneComponents()->create())
            ->get(route('components.clone.create', $source))
            ->assertOk();

        $response->assertSee('name="supplier_id"', false);
        $response->assertSee('value="'.$supplier->id.'"', false);
        $response->assertSee('name="order_number"', false);
        $response->assertSee('value="PO-COMP-CLONE-9"', false);
        $response->assertSee('name="purchase_date"', false);
        $response->assertSee('value="2026-04-01"', false);
        $response->assertSee('name="purchase_cost"', false);
        $response->assertSee('value="12.34"', false);
    }
}
