<?php

namespace Tests\Feature\Scim;

use App\Models\Actionlog;
use App\Models\Group;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Coverage for SCIM-driven group membership logging. SCIM PATCHes
 * against /scim/v2/Groups mutate the users_groups pivot from the
 * Group side via SnipeMutableCollection::add() / ::remove(), never
 * through User::syncGroupsWithLogging(). Without a per-user log the
 * Activity Report would silently omit every IdP-driven role change.
 */
class ScimGroupMembershipLoggingTest extends TestCase
{
    public function test_scim_add_member_logs_group_change_on_the_user()
    {
        $group = Group::factory()->create(['name' => 'Engineering']);
        $newMember = User::factory()->create();
        Passport::actingAs(User::factory()->superuser()->create());

        $this->patchJson('/scim/v2/Groups/'.$group->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                [
                    'op' => 'add',
                    'path' => 'members',
                    'value' => [['value' => (string) $newMember->id]],
                ],
            ],
        ])->assertOk();

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $newMember->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $this->assertNotNull($log, 'SCIM add member must produce a per-user Actionlog');

        $meta = json_decode($log->log_meta, true);
        $this->assertArrayHasKey('groups', $meta);
        $this->assertSame(
            [['id' => $group->id, 'name' => 'Engineering']],
            $meta['groups']['new'],
            'SCIM add must snapshot the group name at write time',
        );
        $this->assertSame([], $meta['groups']['old']);
    }

    public function test_scim_remove_member_via_filter_path_logs_group_change_on_the_user()
    {
        $group = Group::factory()->create(['name' => 'Engineering']);
        $departing = User::factory()->create();
        $group->users()->attach($departing->id);
        Passport::actingAs(User::factory()->superuser()->create());

        $this->patchJson('/scim/v2/Groups/'.$group->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                [
                    'op' => 'remove',
                    'path' => 'members[value eq "'.$departing->id.'"]',
                ],
            ],
        ])->assertOk();

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $departing->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $this->assertNotNull($log, 'SCIM remove member must produce a per-user Actionlog');

        $meta = json_decode($log->log_meta, true);
        $this->assertArrayHasKey('groups', $meta);
        $this->assertSame(
            [['id' => $group->id, 'name' => 'Engineering']],
            $meta['groups']['old'],
            'SCIM remove must snapshot the group name at write time',
        );
        $this->assertSame([], $meta['groups']['new']);
    }

    public function test_scim_add_of_already_attached_member_does_not_log_a_change()
    {
        // Azure Entra sometimes re-sends a member the group already
        // has (e.g. reconciliation runs). The pivot's
        // syncWithoutDetaching is a no-op there, and the log path
        // must match, otherwise the Activity Report fills with
        // spurious "no change" entries.
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);
        Passport::actingAs(User::factory()->superuser()->create());

        $preLogCount = Actionlog::where('item_type', User::class)
            ->where('item_id', $member->id)
            ->count();

        $this->patchJson('/scim/v2/Groups/'.$group->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                [
                    'op' => 'add',
                    'path' => 'members',
                    'value' => [['value' => (string) $member->id]],
                ],
            ],
        ])->assertOk();

        $postLogCount = Actionlog::where('item_type', User::class)
            ->where('item_id', $member->id)
            ->count();

        $this->assertSame($preLogCount, $postLogCount, 'No-op re-add must not produce a log entry');
    }

    public function test_scim_bulk_add_produces_one_log_per_newly_attached_user()
    {
        // Multi-member add in one operation. Each newly-attached
        // user gets their own per-user log so the Activity Report
        // for each of them shows the group change independently.
        $group = Group::factory()->create();
        [$memberA, $memberB, $memberC] = User::factory()->count(3)->create();
        Passport::actingAs(User::factory()->superuser()->create());

        $this->patchJson('/scim/v2/Groups/'.$group->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                [
                    'op' => 'add',
                    'path' => 'members',
                    'value' => [
                        ['value' => (string) $memberA->id],
                        ['value' => (string) $memberB->id],
                        ['value' => (string) $memberC->id],
                    ],
                ],
            ],
        ])->assertOk();

        foreach ([$memberA, $memberB, $memberC] as $user) {
            $log = Actionlog::where('item_type', User::class)
                ->where('item_id', $user->id)
                ->where('action_type', 'update')
                ->latest('id')
                ->first();

            $this->assertNotNull($log, "User {$user->id} must have a group log entry");
            $meta = json_decode($log->log_meta, true);
            $this->assertSame(
                [['id' => $group->id, 'name' => $group->name]],
                $meta['groups']['new'],
            );
        }
    }
}
