<?php

namespace Tests\Feature\Users\Ui;

use App\Models\User;
use Tests\TestCase;

final class UpdateUserTest extends TestCase
{
    public function testUsersCanBeActivatedWithNumber(): void
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => 0]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                'activated' => 1,
            ]);

        $this->assertEquals(1, $user->refresh()->activated);
    }

    public function testUsersCanBeActivatedWithBooleanTrue(): void
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => false]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                'activated' => true,
            ]);

        $this->assertEquals(1, $user->refresh()->activated);
    }

    public function testUsersCanBeDeactivatedWithNumber(): void
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                'activated' => 0,
            ]);

        $this->assertEquals(0, $user->refresh()->activated);
    }

    public function testUsersCanBeDeactivatedWithBooleanFalse(): void
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'first_name' => $user->first_name,
                'username' => $user->username,
                'activated' => false,
            ]);

        $this->assertEquals(0, $user->refresh()->activated);
    }

    public function testUsersUpdatingThemselvesDoNotDeactivateTheirAccount(): void
    {
        $admin = User::factory()->superuser()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'first_name' => $admin->first_name,
                'username' => $admin->username,
            ]);

        $this->assertEquals(1, $admin->refresh()->activated);
    }
}
