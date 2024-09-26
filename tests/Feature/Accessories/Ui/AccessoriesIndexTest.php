<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\User;
use Tests\TestCase;

class AccessoriesIndexTest extends TestCase
{
    public function testPermissionRequiredToViewAccessoryList()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('accessories.index'))
            ->assertForbidden();
    }
}
