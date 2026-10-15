<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\User;
use Tests\Concerns\TestsFullMultipleCompaniesSupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class UpdateAccessoryTest extends TestCase implements TestsFullMultipleCompaniesSupport, TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->patchJson(route('api.accessories.update', $accessory))
            ->assertForbidden();
    }

    public function test_adheres_to_full_multiple_companies_support_scoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $accessoryA = Accessory::factory()->for($companyA)->create(['name' => 'A Name to Change']);
        $accessoryB = Accessory::factory()->for($companyB)->create(['name' => 'A Name to Change']);
        $accessoryC = Accessory::factory()->for($companyB)->create(['name' => 'A Name to Change']);

        $superuser = User::factory()->superuser()->create();
        $userInCompanyA = $companyA->users()->save(User::factory()->editAccessories()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->editAccessories()->make());

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($userInCompanyA)
            ->patchJson(route('api.accessories.update', $accessoryB), ['name' => 'New Name'])
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($userInCompanyB)
            ->patchJson(route('api.accessories.update', $accessoryA), ['name' => 'New Name'])
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($superuser)
            ->patchJson(route('api.accessories.update', $accessoryC), ['name' => 'New Name'])
            ->assertOk();

        $this->assertEquals('A Name to Change', $accessoryA->fresh()->name);
        $this->assertEquals('A Name to Change', $accessoryB->fresh()->name);
        $this->assertEquals('New Name', $accessoryC->fresh()->name);
    }

    public function test_prevents_cross_tenant_company_reassignment_when_fmcs_enabled()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $accessory = Accessory::factory()->for($companyA)->create();
        $userInCompanyA = User::factory()->forCompany($companyA)->editAccessories()->create();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($userInCompanyA)
            ->patchJson(route('api.accessories.update', $accessory), [
                'company_id' => $companyB->id,
            ])
            ->assertStatusMessageIs('error');

        $this->assertSame($companyA->id, $accessory->fresh()->company_id);
    }

    public function test_allows_superuser_company_reassignment_when_fmcs_enabled()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $accessory = Accessory::factory()->for($companyA)->create();
        $superuser = User::factory()->superuser()->withoutCompany()->create();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($superuser)
            ->patchJson(route('api.accessories.update', $accessory), [
                'company_id' => $companyB->id,
            ])
            ->assertStatusMessageIs('success');

        $this->assertSame($companyB->id, $accessory->fresh()->company_id);
    }

    public function test_can_update_accessory_via_patch()
    {
        [$categoryA, $categoryB] = Category::factory()->count(2)->create();
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$locationA, $locationB] = Location::factory()->count(2)->create();
        [$manufacturerA, $manufacturerB] = Manufacturer::factory()->count(2)->create();
        [$supplierA, $supplierB] = Supplier::factory()->count(2)->create();

        $accessory = Accessory::factory()->create([
            'name' => 'A Name to Change',
            'qty' => 5,
            'model_number' => 'ABC098',
            'category_id' => $categoryA->id,
            'company_id' => $companyA->id,
            'location_id' => $locationA->id,
            'manufacturer_id' => $manufacturerA->id,
            'default_supplier_id' => $supplierA->id,
        ]);

        // Payload shape preserved for API back-compat. Acquisition-only
        // fields (order_number, purchase_date, purchase_cost, and the
        // per-Order supplier_id) don't touch the parent — post-create
        // changes flow through Orders + OrderItems via the
        // adjust-quantity endpoint. default_supplier_id IS editable
        // (parent template).
        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), [
                'name' => 'A New Name',
                'qty' => 10,
                'order_number' => 'B54321',
                'purchase_cost' => 199.99,
                'model_number' => 'XYZ123',
                'category_id' => $categoryB->id,
                'company_id' => $companyB->id,
                'location_id' => $locationB->id,
                'manufacturer_id' => $manufacturerB->id,
                'default_supplier_id' => $supplierB->id,
            ])
            ->assertOk();

        $accessory = $accessory->fresh();
        $this->assertEquals('A New Name', $accessory->name);
        // qty stays supported on the PATCH endpoint for API back-compat:
        // the update controller routes qty deltas through adjustQuantity
        // so a payload with qty=10 (original 5) writes a +5 OrderItem
        // and moves the parent qty to 10.
        $this->assertEquals(10, $accessory->qty);
        $this->assertEquals($supplierB->id, $accessory->default_supplier_id);
        $this->assertEquals('XYZ123', $accessory->model_number);
        $this->assertEquals($categoryB->id, $accessory->category_id);
        $this->assertEquals($companyB->id, $accessory->company_id);
        $this->assertEquals($locationB->id, $accessory->location_id);
        $this->assertEquals($manufacturerB->id, $accessory->manufacturer_id);
    }

    public function test_update_logs_changed_fields_in_log_meta()
    {
        $accessory = Accessory::factory()->create(['qty' => 5, 'name' => 'Old Name']);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), ['qty' => 10, 'name' => 'New Name']);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', 'update')
            ->latest()
            ->first();

        $this->assertNotNull($log, 'No update log entry was created');
        $this->assertNotNull($log->log_meta, 'log_meta was not stored');

        // qty change writes its own QuantityAdjust log (asserted below);
        // it does not appear in the update log_meta because the fill()
        // deliberately excludes qty to route it through adjustQuantity.
        $meta = json_decode($log->log_meta, true);
        $this->assertArrayNotHasKey('qty', $meta);
        $this->assertEquals('Old Name', $meta['name']['old']);
        $this->assertEquals('New Name', $meta['name']['new']);
    }

    public function test_qty_change_via_api_creates_quantity_adjust_log()
    {
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), ['qty' => 12, 'order_number' => 'PO-API'])
            ->assertOk();

        $this->assertSame(12, (int) $accessory->fresh()->qty);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', \App\Enums\ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(7, (int) $log->quantity);
        $this->assertSame('PO-API', $log->orderItem->order->order_number);
        $this->assertNotEmpty($log->note, 'Adjustment note must be synthesized when the API caller omits one');
    }

    public function test_qty_only_change_via_api_creates_no_update_log_entry()
    {
        $accessory = Accessory::factory()->create(['qty' => 5, 'name' => 'Same Name']);

        $updateLogsBefore = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), ['qty' => 8, 'name' => 'Same Name'])
            ->assertOk();

        $updateLogsAfter = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', 'update')
            ->count();

        // Only qty changed. The QuantityAdjust log captures that change;
        // no separate 'update' log should exist because nothing else was dirty.
        $this->assertSame($updateLogsBefore, $updateLogsAfter);
        $this->assertSame(1, Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', \App\Enums\ActionType::QuantityAdjust->value)
            ->count());
    }

    public function test_qty_change_below_in_use_returns_422()
    {
        $accessory = Accessory::factory()->create(['qty' => 10]);
        \App\Models\AccessoryCheckout::factory()->count(4)->create([
            'accessory_id' => $accessory->id,
            'assigned_type' => User::class,
            'assigned_to' => User::factory()->create()->id,
        ]);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), ['qty' => 3]) // below the 4 in use
            ->assertStatus(422);

        $this->assertSame(10, (int) $accessory->fresh()->qty);
    }

    public function test_no_op_update_does_not_create_log_entry()
    {
        $accessory = Accessory::factory()->create(['qty' => 5, 'name' => 'Same Name']);

        $before = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->count();

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->patchJson(route('api.accessories.update', $accessory), ['qty' => 5, 'name' => 'Same Name']);

        $after = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->count();

        $this->assertEquals($before, $after, 'A spurious log entry was created for a no-op update');
    }
}
