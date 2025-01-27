<?php
namespace Tests\Feature\Checkins\Api;

use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseCheckinTest extends TestCase
{

    public function testUnreassignableLicenseSeatMarkedUponCheckin()
    {
        $licenseSeat = LicenseSeat::factory()
            ->notReassignable()
            ->assignedToUser()
            ->create();

        $this->assertEquals(false, $licenseSeat->unreassignable_seat);

        $this->actingAs(User::factory()->checkoutLicenses()->create())
            ->post(route('licenses.checkin.save', $licenseSeat));

        $licenseSeat->refresh();

        $this->assertEquals(true, $licenseSeat->unreassignable_seat);
    }
}