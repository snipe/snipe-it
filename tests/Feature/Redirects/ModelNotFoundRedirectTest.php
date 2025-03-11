<?php

namespace Tests\Feature\Redirects;

use App\Models\User;
use Tests\TestCase;

class ModelNotFoundRedirectTest extends TestCase
{
    public function testHandlesLicenseSeat404()
    {
        $this->actingAs(User::factory()->viewLicenses()->create())
            ->get(route('licenses.checkin', 9999))
            ->assertRedirectToRoute('licenses.index');
    }
}
