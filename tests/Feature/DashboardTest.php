<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use InteractsWithSettings;

    public function testUsersWithoutAdminAccessAreRedirected()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertRedirect(route('view-assets'));
    }

    public function testUserCountIsScopedByCompany()
    {
        $this->markTestIncomplete(
            'Waiting for removal of Company::scopeCompanyables in DashboardController@index'
        );

        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->has(User::factory()->count(1))->create();
        Company::factory()->has(User::factory()->count(3))->create();

        $adminForCompanyA = $companyA->users()->save(User::factory()->admin()->make());

        $this->actingAs($adminForCompanyA)
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('dashboard')
            ->assertViewHas('counts', fn($counts) => $counts['user'] === $companyA->users->count());
    }
}
