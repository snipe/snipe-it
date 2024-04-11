<?php

namespace Tests\Feature\Api\Assets;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetCheckoutTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([CheckoutableCheckedOut::class]);
    }

    public function testCheckingOutAssetRequiresCorrectPermission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.asset.checkout', Asset::factory()->create()), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertForbidden();
    }

    public function testNonExistentAssetCannotBeCheckedOut()
    {
        $this->actingAsForApi(User::factory()->checkoutAssets()->create())
            ->postJson(route('api.asset.checkout', 1000), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertStatusMessageIs('error');
    }

    public function testAssetNotAvailableForCheckoutCannotBeCheckedOut()
    {
        $assetAlreadyCheckedOut = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkoutAssets()->create())
            ->postJson(route('api.asset.checkout', $assetAlreadyCheckedOut), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertStatusMessageIs('error');
    }

    public function testValidationWhenCheckingOutAsset()
    {
        $this->actingAsForApi(User::factory()->checkoutAssets()->create())
            ->postJson(route('api.asset.checkout', Asset::factory()->create()), [])
            ->assertStatusMessageIs('error');

        Event::assertNotDispatched(CheckoutableCheckedOut::class);
    }

    public function testCannotCheckoutAcrossCompaniesWhenFullCompanySupportEnabled()
    {
        $this->markTestIncomplete('This is not implemented');
    }

    public function testAssetCanBeCheckedOut()
    {
        $this->markTestIncomplete();
    }

    public function testLicenseSeatsAreAssignedToUserUponCheckout()
    {
        $this->markTestIncomplete('This is not implemented');
    }

    public function testLastCheckoutUsesCurrentDateIfNotProvided()
    {
        $this->markTestIncomplete();
    }
}
