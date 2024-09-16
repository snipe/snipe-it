<?php

namespace Tests\Feature\Checkins\Api;

use App\Models\Accessory;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class AccessoryCheckinTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $accessory = Accessory::factory()->checkedOutToUser()->create();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.checkin', $accessory))
            ->assertForbidden();
    }
}
