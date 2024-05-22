<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\Group;
use App\Models\User;
use Tests\TestCase;

class UpdateUserApiTest extends TestCase
{
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

    public function testUsersScopedToCompanyDuringUpdateWhenMultipleFullCompanySupportEnabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create(['name'=>'Company A']);
        $companyB = Company::factory()->create(['name'=>'Company B']);

        $adminA = User::factory(['company_id' => $companyA->id])->admin()->create();
        $adminB = User::factory(['company_id' => $companyB->id])->admin()->create();
        $adminNoCompany = User::factory(['company_id' => null])->admin()->create();

        // Create users that belongs to company A and B and one that is unscoped
        $scoped_user_in_companyA = User::factory()->create(['company_id' => $companyA->id]);
        $scoped_user_in_companyB = User::factory()->create(['company_id' => $companyB->id]);
        $scoped_user_in_no_company = User::factory()->create(['company_id' => null]);

        // Admin for Company A should allow updating user from Company A
        $this->actingAsForApi($adminA)
            ->patchJson(route('api.users.update', $scoped_user_in_companyA))
            ->assertStatus(200);

        // Admin for Company A should get denied updating user from Company B
        $this->actingAsForApi($adminA)
            ->patchJson(route('api.users.update', $scoped_user_in_companyB))
            ->assertStatus(403);

        // Admin for Company A should get denied updating user without a company
        $this->actingAsForApi($adminA)
            ->patchJson(route('api.users.update', $scoped_user_in_no_company))
            ->assertStatus(403);

        // Admin for Company B should allow updating user from Company B
        $this->actingAsForApi($adminB)
            ->patchJson(route('api.users.update', $scoped_user_in_companyB))
            ->assertStatus(200);

        // Admin for Company B should get denied updating user from Company A
        $this->actingAsForApi($adminB)
            ->patchJson(route('api.users.update', $scoped_user_in_companyA))
            ->assertStatus(403);

        // Admin for Company B should get denied updating user without a company
        $this->actingAsForApi($adminB)
            ->patchJson(route('api.users.update', $scoped_user_in_no_company))
            ->assertStatus(403);

        // Admin without a company should allow updating user without a company
        $this->actingAsForApi($adminNoCompany)
            ->patchJson(route('api.users.update', $scoped_user_in_no_company))
            ->assertStatus(200);

        // Admin without a company should get denied updating user from Company A
        $this->actingAsForApi($adminNoCompany)
            ->patchJson(route('api.users.update', $scoped_user_in_companyA))
            ->assertStatus(403);

        // Admin without a company should get denied updating user from Company B
        $this->actingAsForApi($adminNoCompany)
            ->patchJson(route('api.users.update', $scoped_user_in_companyB))
            ->assertStatus(403);
    }

    public function testUserGroupsAreOnlyUpdatedIfAuthenticatedUserIsSuperUser()
    {
        $groupToJoin = Group::factory()->create();

        $userWhoCanEditUsers = User::factory()->editUsers()->create();
        $superUser = User::factory()->superuser()->create();

        $userToUpdateByUserWhoCanEditUsers = User::factory()->create();
        $userToUpdateByToUserBySuperuser = User::factory()->create();

        $this->actingAsForApi($userWhoCanEditUsers)
            ->patchJson(route('api.users.update', $userToUpdateByUserWhoCanEditUsers), [
                'groups' => [$groupToJoin->id],
            ]);

        $this->actingAsForApi($superUser)
            ->patchJson(route('api.users.update', $userToUpdateByToUserBySuperuser), [
                'groups' => [$groupToJoin->id],
            ]);

        $this->assertFalse($userToUpdateByUserWhoCanEditUsers->refresh()->groups->contains($groupToJoin),
            'Non-super-user was able to modify user group'
        );

        $this->assertTrue($userToUpdateByToUserBySuperuser->refresh()->groups->contains($groupToJoin));
    }

    public function testUserGroupsCanBeClearedBySuperUser()
    {
        $normalUser = User::factory()->editUsers()->create();
        $superUser = User::factory()->superuser()->create();

        $oneUserToUpdate = User::factory()->create();
        $anotherUserToUpdate = User::factory()->create();

        $joinedGroup = Group::factory()->create();
        $oneUserToUpdate->groups()->sync([$joinedGroup->id]);
        $anotherUserToUpdate->groups()->sync([$joinedGroup->id]);

        $this->actingAsForApi($normalUser)
            ->patchJson(route('api.users.update', $oneUserToUpdate), [
                'groups' => null,
            ]);

        $this->actingAsForApi($superUser)
            ->patchJson(route('api.users.update', $anotherUserToUpdate), [
                'groups' => null,
            ]);

        $this->assertTrue($oneUserToUpdate->refresh()->groups->contains($joinedGroup));
        $this->assertFalse($anotherUserToUpdate->refresh()->groups->contains($joinedGroup));
    }

    public function testNonSuperuserCannotUpdateOwnGroups()
    {
        $groupToJoin = Group::factory()->create();
        $user = User::factory()->editUsers()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.users.update', $user), [
                'groups' => [$groupToJoin->id],
            ]);

        $this->assertFalse($user->refresh()->groups->contains($groupToJoin),
            'Non-super-user was able to modify user group'
        );

    }

    public function testNonSuperuserCannotUpdateGroups()
    {
        $user = User::factory()->editUsers()->create();
        $group = Group::factory()->create();
        $user->groups()->sync([$group->id]);
        $newGroupToJoin = Group::factory()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.users.update', $user), [
                'groups' => [$newGroupToJoin->id],
            ]);


        $this->assertFalse($user->refresh()->groups->contains($newGroupToJoin),
            'Non-super-user was able to modify user group membership'
        );

        $this->assertTrue($user->refresh()->groups->contains($group));

    }

    public function testUsersGroupsAreNotClearedIfNoGroupPassedBySuperUser()
    {
        $user = User::factory()->create();
        $superUser = User::factory()->superuser()->create();

        $group = Group::factory()->create();
        $user->groups()->sync([$group->id]);

        $this->actingAsForApi($superUser)
            ->patchJson(route('api.users.update', $user), []);

        $this->assertTrue($user->refresh()->groups->contains($group));
    }

    public function testMultipleGroupsUpdateBySuperUser()
    {
        $user = User::factory()->create();
        $superUser = User::factory()->superuser()->create();

        $groupA = Group::factory()->create(['name'=>'Group A']);
        $groupB = Group::factory()->create(['name'=>'Group B']);

        $this->actingAsForApi($superUser)
            ->patchJson(route('api.users.update', $user), [
                'groups' => [$groupA->id, $groupB->id],
            ])->json();

        $this->assertTrue($user->refresh()->groups->contains($groupA));
        $this->assertTrue($user->refresh()->groups->contains($groupB));
    }

}
