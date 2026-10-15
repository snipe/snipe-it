<?php

namespace Tests\Feature\Checkins\Api;

use App\Events\CheckoutableCheckedIn;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetCheckinConcurrencyGuardTest extends TestCase
{
    public function test_second_checkin_on_an_already_checked_in_asset_does_not_fire_event_or_log()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $assignedUser = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignedUser)->create();

        $actor = User::factory()->checkinAssets()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.asset.checkin', $asset))
            ->assertStatusMessageIs('success');

        Event::assertDispatchedTimes(CheckoutableCheckedIn::class, 1);
        $logsAfterFirstCheckin = Actionlog::query()
            ->where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->count();

        // Second request against the now-checked-in asset must bail out
        // on the re-checked null target. Pre-fix the unlocked initial read
        // could still observe the asset as checked out mid-race and emit
        // a duplicate event + a duplicate log row.
        $this->actingAsForApi($actor)
            ->postJson(route('api.asset.checkin', $asset))
            ->assertStatusMessageIs('error');

        Event::assertDispatchedTimes(CheckoutableCheckedIn::class, 1);

        $logsAfterSecondCheckin = Actionlog::query()
            ->where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->count();

        $this->assertSame(
            $logsAfterFirstCheckin,
            $logsAfterSecondCheckin,
            'A second checkin against an already-checked-in asset must not create another action-log row.'
        );
    }
}
