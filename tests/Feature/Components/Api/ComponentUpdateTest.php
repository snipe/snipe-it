<?php

namespace Tests\Feature\Components\Api;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Component;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class ComponentUpdateTest extends TestCase
{
    public function test_qty_change_via_api_creates_quantity_adjust_log()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.components.update', $component), ['qty' => 12, 'order_number' => 'PO-API'])
            ->assertOk();

        $this->assertSame(12, (int) $component->fresh()->qty);

        $log = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
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
        // template that seeds new Orders. It stays editable after create;
        // per-acquisition supplier lives on Order.supplier_id and is
        // unaffected by this write.
        $original = Supplier::factory()->create();
        $component = Component::factory()->create(['default_supplier_id' => $original->id]);
        $newSupplier = Supplier::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.components.update', $component), ['default_supplier_id' => $newSupplier->id])
            ->assertOk();

        $this->assertSame($newSupplier->id, (int) $component->fresh()->default_supplier_id);
    }

    public function test_qty_only_change_via_api_creates_no_update_log_entry()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $updateLogsBefore = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', 'update')
            ->count();

        // company_id has to be echoed back — the controller unconditionally
        // sets $component->company_id = Company::getIdForCurrentUser(...),
        // which coerces a missing company_id in the payload to null and
        // would silently mark the model dirty. Pre-existing quirk, not
        // introduced by the qty-adjust changes.
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.components.update', $component), [
                'qty' => 8,
                'company_id' => $component->company_id,
            ])
            ->assertOk();

        $updateLogsAfter = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', 'update')
            ->count();

        // Only qty changed. The QuantityAdjust log captures that change;
        // no separate 'update' log should exist because nothing else was dirty.
        $this->assertSame($updateLogsBefore, $updateLogsAfter);
        $this->assertSame(1, Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->count());
    }
}
