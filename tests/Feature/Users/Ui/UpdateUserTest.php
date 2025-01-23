<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.edit', User::factory()->create()->id))
            ->assertOk();
    }

    public function testUsersCanBeActivatedWithNumber()
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

    public function testUsersCanBeActivatedWithBooleanTrue()
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

    public function testUsersCanBeDeactivatedWithNumber()
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

    public function testUsersCanBeDeactivatedWithBooleanFalse()
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

    public function testUsersUpdatingThemselvesDoNotDeactivateTheirAccount()
    {
        $admin = User::factory()->superuser()->create(['activated' => true]);

        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'first_name' => $admin->first_name,
                'username' => $admin->username,
            ]);

        $this->assertEquals(1, $admin->refresh()->activated);
    }

    public function testMultiCompanyUserCannotBeMovedIfHasAssetInDifferentCompany()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $user = User::factory()->create([
            'company_id' => $companyA->id,
        ]);
        $superUser = User::factory()->superuser()->create();

        $asset = Asset::factory()->create([
            'company_id' => $companyA->id,
        ]);

        // no assets assigned, therefore success
        $this->actingAs($superUser)->put(route('users.update', $user), [
            'first_name'      => 'test',
            'username'        => 'test',
            'company_id'      => $companyB->id,
            'redirect_option' => 'index'
        ])->assertRedirect(route('users.index'));

        $asset->checkOut($user, $superUser);

        // asset assigned, therefore error
        $response = $this->actingAs($superUser)->patchJson(route('users.update', $user), [
            'first_name'      => 'test',
            'username'        => 'test',
            'company_id'      => $companyB->id,
            'redirect_option' => 'index'
        ]);

        $this->followRedirects($response)->assertSee('error');
    }

    public function testMultiCompanyUserCanBeUpdatedIfHasAssetInSameCompany()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $user = User::factory()->create([
            'company_id' => $companyA->id,
        ]);
        $superUser = User::factory()->superuser()->create();

        $asset = Asset::factory()->create([
            'company_id' => $companyA->id,
        ]);

        // no assets assigned, therefore success
        $this->actingAs($superUser)->put(route('users.update', $user), [
            'first_name'      => 'test',
            'username'        => 'test',
            'company_id'      => $companyA->id,
            'redirect_option' => 'index'
        ])->assertRedirect(route('users.index'));

        $asset->checkOut($user, $superUser);

        // asset assigned, therefore error
        $response = $this->actingAs($superUser)->patchJson(route('users.update', $user), [
            'first_name'      => 'test',
            'username'        => 'test',
            'company_id'      => $companyA->id,
            'redirect_option' => 'index'
        ]);

        $this->followRedirects($response)->assertSee('success');
    }
}
