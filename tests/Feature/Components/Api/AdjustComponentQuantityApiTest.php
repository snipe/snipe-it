<?php

namespace Tests\Feature\Components\Api;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Component;
use App\Models\User;
use Tests\TestCase;

// Focused wiring test: the shared AdjustQuantityRequest + AdjustsQuantity
// trait + controller pattern is fully covered in AdjustAccessoryQuantityApiTest.
// These assertions just prove the components route + controller are wired.
class AdjustComponentQuantityApiTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.components.adjust-quantity', $component), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();
    }

    public function test_signed_amount_writes_quantity_adjust_log()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editComponents()->create())
            ->postJson(route('api.components.adjust-quantity', $component), [
                'amount' => 3,
                'note' => 'restock',
                'order_number' => 'PO-CMP',
            ])
            ->assertOk();

        $this->assertSame(8, (int) $component->fresh()->qty);

        $log = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(3, (int) $log->quantity);
        $this->assertSame('PO-CMP', $log->orderItem->order->order_number);
    }

    public function test_note_is_required()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editComponents()->create())
            ->postJson(route('api.components.adjust-quantity', $component), ['amount' => 2])
            ->assertOk()
            ->assertJsonPath('status', 'error');
    }
}
