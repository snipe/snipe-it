<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\User;
use Tests\TestCase;

class UpdateAccessoryTest extends TestCase
{
    public function testPermissionRequiredToUpdateAccessory()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->patchJson(route('api.accessories.update', $accessory))
            ->assertForbidden();
    }
}
