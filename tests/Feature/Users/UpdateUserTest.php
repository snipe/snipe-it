<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use InteractsWithSettings;

    public function testUsersCanBeActivated()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => false]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                'activated' => 1,
            ]);

        $this->assertTrue($user->refresh()->activated);
    }

    public function testUsersCanBeDeactivated()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                // checkboxes that are not checked are
                // not included in the request payload
                // 'activated' => 0,
            ]);

        $this->assertFalse($user->refresh()->activated);
    }

    public function testUsersUpdatingThemselvesDoNotDeactivateTheirAccount()
    {
        $admin = User::factory()->superuser()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'first_name' => $admin->first_name,
                'username' => $admin->username,
                // checkboxes that are disabled are not
                // included in the request payload
                // even if they are checked
                // 'activated' => 0,
            ]);

        $this->assertTrue($admin->refresh()->activated);
    }
}
