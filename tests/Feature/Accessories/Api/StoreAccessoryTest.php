<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Tests\Concerns\TestsFullMultipleCompaniesSupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class StoreAccessoryTest extends TestCase implements TestsFullMultipleCompaniesSupport, TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.store'))
            ->assertForbidden();
    }

    public function testAdheresToFullMultipleCompaniesSupportScoping()
    {
        $this->markTestSkipped('This behavior is not implemented');

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $userInCompanyA = User::factory()->for($companyA)->createAccessories()->create();

        $this->settings->enableMultipleFullCompanySupport();

        // attempt to store an accessory for company B
        $this->actingAsForApi($userInCompanyA)
            ->postJson(route('api.accessories.store'), [
                'category_id' => Category::factory()->forAccessories()->create()->id,
                'name' => 'Accessory A',
                'qty' => 1,
                'company_id' => $companyB->id,
            ])->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('accessories', [
            'name' => 'Accessory A',
        ]);
    }

    public function testValidation()
    {
        $this->actingAsForApi(User::factory()->createAccessories()->create())
            ->postJson(route('api.accessories.store'), [
                //
            ])
            ->assertStatusMessageIs('error')
            ->assertMessagesContains([
                'category_id',
                'name',
                'qty',
            ]);
    }

    public function testCanStoreAccessory()
    {
        $this->markTestIncomplete();
    }
}
