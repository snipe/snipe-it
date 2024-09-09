<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\User;
use Tests\TestCase;

class IndexAccessoryTest extends TestCase
{
    public function testPermissionRequiredToViewAccessoriesIndex()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.accessories.index'))
            ->assertForbidden();
    }
}
