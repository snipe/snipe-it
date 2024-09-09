<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\User;
use Tests\TestCase;

class AccessoryShowTest extends TestCase
{
    public function testPermissionRequiredToShowAccessory()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.accessories.show', $accessory))
            ->assertForbidden();
    }
}
