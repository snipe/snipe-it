<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Tests\Concerns\TestsMultipleFullCompanySupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteAssetsTest extends TestCase implements TestsMultipleFullCompanySupport, TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.assets.destroy', $asset))
            ->assertForbidden();
    }

    public function testCanDeleteAsset()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->deleteAssets()->create())
            ->deleteJson(route('api.assets.destroy', $asset))
            ->assertStatusMessageIs('success');

        $this->assertTrue($asset->fresh()->trashed());
    }

    public function testCannotDeleteAssetThatIsCheckedOut()
    {
        $this->markTestSkipped('This behavior is not functioning yet.');
    }

    public function testAdheresToMultipleFullCompanySupportScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetA = Asset::factory()->for($companyA)->create();
        $assetB = Asset::factory()->for($companyB)->create();
        $assetC = Asset::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->deleteAssets()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->deleteAssets()->make());

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($userInCompanyA)
            ->deleteJson(route('api.assets.destroy', $assetB))
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($userInCompanyB)
            ->deleteJson(route('api.assets.destroy', $assetA))
            ->assertStatusMessageIs('error');

        $this->actingAsForApi($superUser)
            ->deleteJson(route('api.assets.destroy', $assetC))
            ->assertStatusMessageIs('success');

        $this->assertNull($assetA->fresh()->deleted_at, 'Asset unexpectedly deleted');
        $this->assertNull($assetB->fresh()->deleted_at, 'Asset unexpectedly deleted');
        $this->assertNotNull($assetC->fresh()->deleted_at, 'Asset was not deleted');
    }
}
