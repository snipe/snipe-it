<?php

namespace Tests\Feature\Components\Ui;

use App\Models\User;
use Tests\TestCase;

class ComponentIndexTest extends TestCase
{
    public function testPermissionRequiredToViewComponentsList(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('components.index'))
            ->assertForbidden();
    }

    public function testUserCanListComponents(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('components.index'))
            ->assertOk();
    }
}
