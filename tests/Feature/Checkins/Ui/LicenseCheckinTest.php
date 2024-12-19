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

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.checkin', LicenseSeat::factory()->assignedToUser()->create()->id))
            ->assertOk();
    }
}
