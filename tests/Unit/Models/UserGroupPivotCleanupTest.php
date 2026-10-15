<?php

namespace Tests\Unit\Models;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserGroupPivotCleanupTest extends TestCase
{
    public function test_force_deleting_user_detaches_users_groups_pivot_rows()
    {
        $user = User::factory()->create();
        $groups = Group::factory()->count(2)->create();
        $user->groups()->attach($groups->pluck('id')->all());

        $this->assertEquals(2, DB::table('users_groups')->where('user_id', $user->id)->count());

        $user->forceDelete();

        $this->assertEquals(0, DB::table('users_groups')->where('user_id', $user->id)->count());
    }

    public function test_soft_deleting_user_preserves_users_groups_pivot_rows()
    {
        $user = User::factory()->create();
        $groups = Group::factory()->count(2)->create();
        $user->groups()->attach($groups->pluck('id')->all());

        $user->delete();

        $this->assertEquals(2, DB::table('users_groups')->where('user_id', $user->id)->count());
    }

    public function test_force_deleting_user_does_not_delete_groups()
    {
        $user = User::factory()->create();
        $groups = Group::factory()->count(2)->create();
        $user->groups()->attach($groups->pluck('id')->all());

        $user->forceDelete();

        foreach ($groups as $group) {
            $this->assertDatabaseHas('permission_groups', ['id' => $group->id]);
        }
    }
}
