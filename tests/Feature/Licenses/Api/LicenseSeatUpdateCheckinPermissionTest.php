<?php

namespace Tests\Feature\Licenses\Api;

use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseSeatUpdateCheckinPermissionTest extends TestCase
{
    public function test_seat_update_that_clears_assignment_requires_checkin_permission(): void
    {
        $license = License::factory()->create();
        $assignee = User::factory()->create();
        $seat = LicenseSeat::factory()->for($license)->create([
            'assigned_to' => $assignee->id,
        ]);

        $actor = User::factory()->checkoutLicenses()->viewLicenses()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.licenses.seats.update', ['license' => $license->id, 'seat' => $seat->id]), [
                'assigned_to' => null,
            ])
            ->assertForbidden();

        $seat->refresh();
        $this->assertSame($assignee->id, $seat->assigned_to);
    }

    public function test_seat_update_that_clears_assignment_succeeds_when_checkin_permission_granted(): void
    {
        $license = License::factory()->create();
        $assignee = User::factory()->create();
        $seat = LicenseSeat::factory()->for($license)->create([
            'assigned_to' => $assignee->id,
        ]);

        $actor = User::factory()->checkoutLicenses()->checkinLicenses()->viewLicenses()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.licenses.seats.update', ['license' => $license->id, 'seat' => $seat->id]), [
                'assigned_to' => null,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $seat->refresh();
        $this->assertNull($seat->assigned_to);
    }

    public function test_seat_update_that_reassigns_still_only_requires_checkout_permission(): void
    {
        $license = License::factory()->create();
        $oldAssignee = User::factory()->create();
        $newAssignee = User::factory()->create();
        $seat = LicenseSeat::factory()->for($license)->create([
            'assigned_to' => $oldAssignee->id,
        ]);

        $actor = User::factory()->checkoutLicenses()->viewLicenses()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.licenses.seats.update', ['license' => $license->id, 'seat' => $seat->id]), [
                'assigned_to' => $newAssignee->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $seat->refresh();
        $this->assertSame($newAssignee->id, $seat->assigned_to);
    }
}
