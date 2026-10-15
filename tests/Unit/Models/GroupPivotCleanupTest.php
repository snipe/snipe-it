<?php

namespace Tests\Unit\Models;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupPivotCleanupTest extends TestCase
{
    public function test_deleting_group_detaches_users_groups_pivot_rows()
    {
        $group = Group::factory()->create();
        $users = User::factory()->count(3)->create();
        $group->users()->attach($users->pluck('id')->all());

        $this->assertEquals(3, DB::table('users_groups')->where('group_id', $group->id)->count());

        $group->delete();

        $this->assertEquals(0, DB::table('users_groups')->where('group_id', $group->id)->count());
    }

    public function test_deleting_group_does_not_delete_users()
    {
        $group = Group::factory()->create();
        $users = User::factory()->count(2)->create();
        $group->users()->attach($users->pluck('id')->all());

        $group->delete();

        foreach ($users as $user) {
            $this->assertDatabaseHas('users', ['id' => $user->id]);
        }
    }
}
