<?php

namespace Tests\Feature\Consumables\Api;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Category;
use App\Models\Consumable;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class ConsumableUpdateTest extends TestCase
{
    public function test_can_update_consumable_via_patch_without_category_type()
    {
        $consumable = Consumable::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.consumables.update', $consumable), [
                'name' => 'Test Consumable',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $consumable->refresh();
        $this->assertEquals('Test Consumable', $consumable->name, 'Name was not updated');
    }

    public function test_cannot_update_consumable_via_patch_with_invalid_category_type()
    {
        $category = Category::factory()->create(['category_type' => 'asset']);
        $consumable = Consumable::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.consumables.update', $consumable), [
                'name' => 'Test Consumable',
                'category_id' => $category->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $consumable->refresh();
        $this->assertNotEquals('Test Consumable', $consumable->name, 'Name was not updated');
        $this->assertNotEquals('consumable', $consumable->category_id, 'Category was not updated');
    }

    public function test_qty_change_via_api_creates_quantity_adjust_log()
    {
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.consumables.update', $consumable), ['qty' => 12, 'order_number' => 'PO-API'])
            ->assertOk();

        $this->assertSame(12, (int) $consumable->fresh()->qty);

        $log = Actionlog::where('item_type', Consumable::class)
            ->where('item_id', $consumable->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(7, (int) $log->quantity);
        $this->assertSame('PO-API', $log->orderItem->order->order_number);
        $this->assertNotEmpty($log->note);
    }

    public function test_default_supplier_id_is_editable_on_update()
    {
        // default_supplier_id on the parent is the "typical supplier"
        // template — see ComponentUpdateTest for the full rationale.
        $original = Supplier::factory()->create();
        $consumable = Consumable::factory()->create(['default_supplier_id' => $original->id]);
        $newSupplier = Supplier::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.consumables.update', $consumable), ['default_supplier_id' => $newSupplier->id])
            ->assertOk();

        $this->assertSame($newSupplier->id, (int) $consumable->fresh()->default_supplier_id);
    }
}
