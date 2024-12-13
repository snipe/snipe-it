<?php

namespace Tests\Feature\Checkins\Ui;

use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseCheckinTest extends TestCase
{
    public function testCheckingInLicenseRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('licenses.checkin.save', [
                'licenseId' => LicenseSeat::factory()->assignedToUser()->create()->id,
            ]))
            ->assertForbidden();
    }

    public function testCannotCheckinNonReassignableLicense()
    {
        $licenseSeat = LicenseSeat::factory()
            ->notReassignable()
            ->assignedToUser()
            ->create();

        $this->actingAs(User::factory()->checkoutLicenses()->create())
            ->post(route('licenses.checkin.save', $licenseSeat), [
                'notes' => 'my note',
                'redirect_option' => 'index',
            ])
            ->assertSessionHas('error', trans('admin/licenses/message.checkin.not_reassignable') . '.');

        $this->assertNotNull($licenseSeat->fresh()->assigned_to);
    }

    public function testCanCheckInLicenseAssignedToAsset()
    {
        $licenseSeat = LicenseSeat::factory()
            ->reassignable()
            ->assignedToAsset()
            ->create();

        $this->assertNotNull($licenseSeat->asset_id);

        $this->actingAs(User::factory()->checkoutLicenses()->create())
            ->post(route('licenses.checkin.save', $licenseSeat), [
                'notes' => 'my note',
                'redirect_option' => 'index',
            ])
            ->assertRedirect(route('licenses.index'));

        $this->assertNull($licenseSeat->fresh()->asset_id);
        $this->assertNull($licenseSeat->fresh()->assigned_to);
    }

    public function testCanCheckInLicenseAssignedToUser()
    {
        $licenseSeat = LicenseSeat::factory()
            ->reassignable()
            ->assignedToUser()
            ->create();

        $this->assertNotNull($licenseSeat->assigned_to);

        $this->actingAs(User::factory()->checkoutLicenses()->create())
            ->post(route('licenses.checkin.save', $licenseSeat), [
                'notes' => 'my note',
                'redirect_option' => 'index',
            ])
            ->assertRedirect(route('licenses.index'));

        $this->assertNull($licenseSeat->fresh()->asset_id);
        $this->assertNull($licenseSeat->fresh()->assigned_to);
    }
}
