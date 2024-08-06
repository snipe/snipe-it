<?php

namespace Tests\Feature\Groups\Ui;

use App\Models\User;
use Tests\TestCase;

class IndexGroupTest extends TestCase
{
    public function testPermissionRequiredToViewGroupList(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('groups.index'))
            ->assertForbidden();

        //$this->followRedirects($response)->assertSee('sad-panda.png');
    }

    public function testUserCanListGroups(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('groups.index'))
            ->assertOk();
    }
}
