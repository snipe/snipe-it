<?php

namespace Tests\Feature\Checkins\Api;

use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use Tests\Concerns\TestsFullMultipleCompaniesSupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class AccessoryCheckinTest extends TestCase implements TestsFullMultipleCompaniesSupport, TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $accessory = Accessory::factory()->checkedOutToUser()->create();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.checkin', $accessory))
            ->assertForbidden();
    }

    public function testAdheresToFullMultipleCompaniesSupportScoping()
    {
        $this->markTestIncomplete();

        $this->withoutExceptionHandling();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $userInCompanyA = User::factory()->for($companyA)->checkinAccessories()->create();
        $accessoryForCompanyB = Accessory::factory()->for($companyB)->checkedOutToUser()->create();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($userInCompanyA)
            ->postJson(route('api.accessories.checkin', $accessoryForCompanyB))
            ->assertStatusMessageIs('error');

        // @todo:
    }
}
