<?php

namespace Tests\Feature\Consumables\Api;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

// Focused wiring test: the shared AdjustQuantityRequest + AdjustsQuantity
// trait + controller pattern is fully covered in AdjustAccessoryQuantityApiTest.
// These assertions just prove the consumables route + controller are wired.
class AdjustConsumableQuantityApiTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.consumables.adjust-quantity', $consumable), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();
    }

    public function test_signed_amount_writes_quantity_adjust_log()
    {
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editConsumables()->create())
            ->postJson(route('api.consumables.adjust-quantity', $consumable), [
                'amount' => 3,
                'note' => 'restock',
                'order_number' => 'PO-CON',
            ])
            ->assertOk();

        $this->assertSame(8, (int) $consumable->fresh()->qty);

        $log = Actionlog::where('item_type', Consumable::class)
            ->where('item_id', $consumable->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(3, (int) $log->quantity);
        $this->assertSame('PO-CON', $log->orderItem->order->order_number);
    }

    public function test_note_is_required()
    {
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editConsumables()->create())
            ->postJson(route('api.consumables.adjust-quantity', $consumable), ['amount' => 2])
            ->assertOk()
            ->assertJsonPath('status', 'error');
    }
}
