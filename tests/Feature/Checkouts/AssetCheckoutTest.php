<?php

namespace Tests\Feature\Checkouts;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetCheckoutTest extends TestCase
{
    public function testCheckingOutAssetRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('hardware.checkout.store', Asset::factory()->create()), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertForbidden();
    }

    public function testNonExistentAssetCannotBeCheckedOut()
    {
        Event::fake([CheckoutableCheckedOut::class]);

        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('hardware.checkout.store', 1000), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
                'name' => 'Changed Name',
                'status_id' => Statuslabel::factory()->readyToDeploy()->create()->id,
                'checkout_at' => '2024-03-18',
                'expected_checkin' => '2024-03-28',
                'note' => 'An awesome note',
            ])
            ->assertSessionHas('error');

        Event::assertNotDispatched(CheckoutableCheckedOut::class);
    }

    public function testAssetNotAvailableForCheckoutCannotBeCheckedOut()
    {
        Event::fake([CheckoutableCheckedOut::class]);

        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
                'name' => 'Changed Name',
                'status_id' => Statuslabel::factory()->readyToDeploy()->create()->id,
                'checkout_at' => '2024-03-18',
                'expected_checkin' => '2024-03-28',
                'note' => 'An awesome note',
            ])
            ->assertSessionHas('error');

        Event::assertNotDispatched(CheckoutableCheckedOut::class);
    }

    public function testValidationWhenCheckingOutAsset()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('hardware.checkout.store', Asset::factory()->create()), [
                //
            ])
            ->assertSessionHasErrors();
    }

    public function checkoutTargets(): array
    {
        return [
            'User' => [function () {
                $userLocation = Location::factory()->create();
                $user = User::factory()->for($userLocation)->create();

                return [
                    'checkout_type' => 'user',
                    'target' => $user,
                    'expected_location' => $userLocation,
                ];
            }],
            'Asset without location set' => [function () {
                $rtdLocation = Location::factory()->create();
                $asset = Asset::factory()->for($rtdLocation, 'defaultLoc')->create(['location_id' => null]);

                return [
                    'checkout_type' => 'asset',
                    'target' => $asset,
                    'expected_location' => $rtdLocation,
                ];
            }],
            'Asset with location set' => [function () {
                $rtdLocation = Location::factory()->create();
                $location = Location::factory()->create();
                $asset = Asset::factory()->for($location)->for($rtdLocation, 'defaultLoc')->create();

                return [
                    'checkout_type' => 'asset',
                    'target' => $asset,
                    'expected_location' => $location,
                ];
            }],
            'Location' => [function () {
                $location = Location::factory()->create();

                return [
                    'checkout_type' => 'location',
                    'target' => $location,
                    'expected_location' => $location,
                ];
            }],
        ];
    }

    /** @dataProvider checkoutTargets */
    public function testAnAssetCanBeCheckedOut($data)
    {
        Event::fake([CheckoutableCheckedOut::class]);

        ['checkout_type' => $type, 'target' => $target, 'expected_location' => $expectedLocation] = $data();

        $originalStatus = Statuslabel::factory()->readyToDeploy()->create();
        $updatedStatus = Statuslabel::factory()->readyToDeploy()->create();
        $asset = Asset::factory()->create(['status_id' => $originalStatus->id]);
        $admin = User::factory()->checkoutAssets()->create();

        $this->actingAs($admin)
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => $type,
                'assigned_' . $type => $target->id,
                'name' => 'Changed Name',
                'status_id' => $updatedStatus->id,
                'checkout_at' => '2024-03-18',
                'expected_checkin' => '2024-03-28',
                'note' => 'An awesome note',
            ]);

        $asset->refresh();
        $this->assertTrue($asset->assignedTo()->is($target));
        $this->assertTrue($asset->location->is($expectedLocation));
        $this->assertEquals('Changed Name', $asset->name);
        $this->assertTrue($asset->assetstatus->is($updatedStatus));
        $this->assertEquals('2024-03-18 00:00:00', $asset->last_checkout);
        $this->assertEquals('2024-03-28 00:00:00', (string)$asset->expected_checkin);

        Event::assertDispatched(CheckoutableCheckedOut::class, 1);
        Event::assertDispatched(function (CheckoutableCheckedOut $event) use ($admin, $asset, $target) {
            return $event->checkoutable->is($asset)
                && $event->checkedOutTo->is($target)
                && $event->checkedOutBy->is($admin)
                && $event->note === 'An awesome note';
        });
    }

    public function testLicenseSeatsAreAssignedToUserUponCheckout()
    {
        $asset = Asset::factory()->create();
        $seat = LicenseSeat::factory()->assignedToAsset($asset)->create();
        $user = User::factory()->create();

        $this->assertFalse($user->licenses->contains($seat->license));

        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => $user->id,
            ]);

        $this->assertTrue($user->fresh()->licenses->contains($seat->license));
    }

    public function testLastCheckoutUsesCurrentDateIfNotProvided()
    {
        $this->markTestIncomplete();
    }
}
