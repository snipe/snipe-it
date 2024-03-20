<?php

namespace Tests\Feature\Checkouts;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetCheckoutTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingOutAssetRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('hardware.checkout.store', Asset::factory()->create()), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertForbidden();
    }

    public function testValidationWhenCheckingOutAsset()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('hardware.checkout.store', Asset::factory()->create()), [
                //
            ])
            ->assertSessionHasErrors();
    }

    public function testAnAssetCanBeCheckedOutToAUser()
    {
        $this->markTestIncomplete();

        Event::fake([CheckoutableCheckedOut::class]);

        $status = Statuslabel::factory()->readyToDeploy()->create();
        $asset = Asset::factory()->create();
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => $user->id,
                'name' => 'Changed Name',
                'status_id' => $status->id,
                'checkout_at' => '2024-03-18',
                'expected_checkin' => '2024-03-28',
                'note' => 'An awesome note',
            ]);

        // @todo: assert CheckoutableCheckedOut dispatched with correct data
        Event::assertDispatched(CheckoutableCheckedOut::class);

        // @todo: assert action log entry created
    }

    public function testAnAssetCanBeCheckedOutToAnAsset()
    {
        $this->markTestIncomplete();
    }

    public function testAnAssetCanBeCheckedOutToALocation()
    {
        $this->markTestIncomplete();
    }
}
