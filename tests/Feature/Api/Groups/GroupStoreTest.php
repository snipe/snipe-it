<?php

namespace Tests\Feature\Api\Groups;

use App\Models\Group;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class GroupStoreTest extends TestCase
{
    use InteractsWithSettings;

    public function testStoringGroupRequiresSuperAdminPermission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.groups.store'))
            ->assertForbidden();
    }

    public function testCanStoreGroup()
    {
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.groups.store'), [
                'name' => 'My Awesome Group',
                'permissions' => [
                    'admin' => '1',
                    'import' => '1',
                    'reports.view' => '0',
                ],
            ])
            ->assertOk();

        $group = Group::where('name', 'My Awesome Group')->first();

        $this->assertNotNull($group);
        $this->assertEquals('1', $group->decodePermissions()['admin']);
        $this->assertEquals('1', $group->decodePermissions()['import']);
        $this->assertEquals('0', $group->decodePermissions()['reports.view']);
    }
}
