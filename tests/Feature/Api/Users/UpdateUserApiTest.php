<?php

namespace Tests\Feature\Api\Users;

use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;
use Tests\Support\InteractsWithAuthentication;


class UpdateUserApiTest extends TestCase
{
    use InteractsWithSettings;
    use InteractsWithAuthentication;

    public function testApiUsersCanBeActivatedWithNumber()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => 0]);

        $this->actingAsForApi($admin)
            ->patch(route('api.users.update', $user), [
                'activated' => 1,
            ]);

        $this->assertEquals(1, $user->refresh()->activated);
    }

    public function testApiUsersCanBeActivatedWithBooleanTrue()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => false]);

        $this->actingAsForApi($admin)
            ->patch(route('api.users.update', $user), [
                'activated' => true,
            ]);

        $this->assertEquals(1, $user->refresh()->activated);
    }

    public function testApiUsersCanBeDeactivatedWithNumber()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => true]);

        $this->actingAsForApi($admin)
            ->patch(route('api.users.update', $user), [
                'activated' => 0,
            ]);

        $this->assertEquals(0, $user->refresh()->activated);
    }

    public function testApiUsersCanBeDeactivatedWithBooleanFalse()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->create(['activated' => true]);

        $this->actingAsForApi($admin)
            ->patch(route('api.users.update', $user), [
                'activated' => false,
            ]);

        $this->assertEquals(0, $user->refresh()->activated);
    }

}
