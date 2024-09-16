<?php

namespace Tests\Feature\Suppliers\Api;

use App\Models\AssetMaintenance;
use App\Models\Supplier;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteSuppliersTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $supplier = Supplier::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.suppliers.destroy', $supplier))
            ->assertForbidden();

        $this->assertNotSoftDeleted($supplier);
    }

    public function testCannotDeleteSupplierWithDataStillAssociated()
    {
        $supplierWithAsset = Supplier::factory()->hasAssets()->create();
        $supplierWithAssetMaintenance = Supplier::factory()->has(AssetMaintenance::factory(), 'asset_maintenances')->create();
        $supplierWithLicense = Supplier::factory()->hasLicenses()->create();

        $actor = $this->actingAsForApi(User::factory()->deleteSuppliers()->create());

        $actor->deleteJson(route('api.suppliers.destroy', $supplierWithAsset))->assertStatusMessageIs('error');
        $actor->deleteJson(route('api.suppliers.destroy', $supplierWithAssetMaintenance))->assertStatusMessageIs('error');
        $actor->deleteJson(route('api.suppliers.destroy', $supplierWithLicense))->assertStatusMessageIs('error');

        $this->assertNotSoftDeleted($supplierWithAsset);
        $this->assertNotSoftDeleted($supplierWithAssetMaintenance);
        $this->assertNotSoftDeleted($supplierWithLicense);
    }

    public function testCanDeleteSupplier()
    {
        $supplier = Supplier::factory()->create();

        $this->actingAsForApi(User::factory()->deleteSuppliers()->create())
            ->deleteJson(route('api.suppliers.destroy', $supplier))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSoftDeleted($supplier);
    }
}
