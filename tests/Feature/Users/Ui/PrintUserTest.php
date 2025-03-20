<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class PrintUserTest extends TestCase
{
    public function testPermissionsForPrintAllInventoryPage()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $user = User::factory()->for($companyB)->create();

        $this->actingAs(User::factory()->viewUsers()->for($companyA)->create())
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertStatus(302);

        $this->actingAs(User::factory()->viewUsers()->for($companyB)->create())
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertStatus(200);

        $this->actingAs($superuser)
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertOk()
            ->assertStatus(200);
    }
}
