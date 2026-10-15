<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\User;
use Tests\Concerns\TestsFullMultipleCompaniesSupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class StoreAccessoryTest extends TestCase implements TestsFullMultipleCompaniesSupport, TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.store'))
            ->assertForbidden();
    }

    public function test_adheres_to_full_multiple_companies_support_scoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $userInCompanyA = User::factory()->forCompany($companyA)->createAccessories()->create();

        $this->settings->enableMultipleFullCompanySupport();

        // A user in company A cannot create an accessory assigned to company B — request is rejected.
        $this->actingAsForApi($userInCompanyA)
            ->postJson(route('api.accessories.store'), [
                'category_id' => Category::factory()->forAccessories()->create()->id,
                'name' => 'My Awesome Accessory',
                'qty' => 1,
                'company_id' => $companyB->id,
            ])->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('accessories', ['name' => 'My Awesome Accessory']);
    }

    public function test_can_store_accessory()
    {
        $category = Category::factory()->forAccessories()->create();
        $company = Company::factory()->create();
        $location = Location::factory()->create();
        $manufacturer = Manufacturer::factory()->create();
        $supplier = Supplier::factory()->create();

        // order_number in the request body silently drops here — the parent
        // column was renamed to legacy_order_number and taken out of the
        // fillable set. Real order-number tracking lives on QuantityAdjust
        // action_log rows created via the adjust-quantity endpoint.
        $this->actingAsForApi(User::factory()->createAccessories()->create())
            ->postJson(route('api.accessories.store'), [
                'name' => 'My Awesome Accessory',
                'qty' => 2,
                'purchase_cost' => 100.00,
                'purchase_date' => '2024-09-18',
                'model_number' => '98765',
                'category_id' => $category->id,
                'company_id' => $company->id,
                'location_id' => $location->id,
                'manufacturer_id' => $manufacturer->id,
                'supplier_id' => $supplier->id,
            ])->assertStatusMessageIs('success');

        // supplier_id / purchase_date / purchase_cost from the request
        // body no longer land on the accessories row — they flow to the
        // observer-written Order + OrderItem (see AccessoryObserverOrderTest).
        // The parent's default_supplier_id gets seeded from supplier_id
        // so future orders pre-populate correctly.
        $this->assertDatabaseHas('accessories', [
            'name' => 'My Awesome Accessory',
            'qty' => 2,
            'model_number' => '98765',
            'category_id' => $category->id,
            'company_id' => $company->id,
            'location_id' => $location->id,
            'manufacturer_id' => $manufacturer->id,
            'default_supplier_id' => $supplier->id,
        ]);
    }
}
