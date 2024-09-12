<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use Tests\Concerns\TestsMultipleFullCompanySupport;
use Tests\TestCase;

class DeleteAccessoryTest extends TestCase implements TestsMultipleFullCompanySupport
{
    public function testPermissionRequiredToDeleteAccessory()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.accessories.destroy', $accessory))
            ->assertForbidden();
    }

    public function testCanDeleteAccessory()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->deleteAccessories()->create())
            ->deleteJson(route('api.accessories.destroy', $accessory))
            ->assertStatusMessageIs('success');

        $this->assertTrue($accessory->fresh()->trashed());
    }

    public function testCannotDeleteAccessoryThatHasCheckouts()
    {
        $accessory = Accessory::factory()->checkedOutToUser()->create();

        $this->actingAsForApi(User::factory()->deleteAccessories()->create())
            ->deleteJson(route('api.accessories.destroy', $accessory))
            ->assertStatusMessageIs('error');

        $this->assertFalse($accessory->fresh()->trashed());
    }

    public function testAdheresToMultipleFullCompanySupportScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $accessoryA = Accessory::factory()->for($companyA)->create();
        $accessoryB = Accessory::factory()->for($companyB)->create();
        $accessoryC = Accessory::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->deleteAccessories()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->deleteAccessories()->make());

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($userInCompanyA)
            ->deleteJson(route('api.accessories.destroy', $accessoryB))
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($userInCompanyB)
            ->deleteJson(route('api.accessories.destroy', $accessoryA))
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($superUser)
            ->deleteJson(route('api.accessories.destroy', $accessoryC))
            ->assertStatusMessageIs('success');

        $this->assertNull($accessoryA->fresh()->deleted_at, 'Accessory unexpectedly deleted');
        $this->assertNull($accessoryB->fresh()->deleted_at, 'Accessory unexpectedly deleted');
        $this->assertNotNull($accessoryC->fresh()->deleted_at, 'Accessory was not deleted');
    }
}
