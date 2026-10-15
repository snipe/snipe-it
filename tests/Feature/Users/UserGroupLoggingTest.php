<?php

namespace Tests\Feature\Users;

use App\Models\Actionlog;
use App\Models\Group;
use App\Models\User;
use Tests\TestCase;

class UserGroupLoggingTest extends TestCase
{
    public function test_field_and_group_changes_produce_single_log_entry()
    {
        [$groupA, $groupB] = Group::factory()->count(2)->create();

        $user = User::factory()->create(['jobtitle' => 'Engineer']);
        $user->groups()->sync([$groupA->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'jobtitle' => 'Senior Engineer',
                'groups' => [$groupB->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->whereNotIn('id', $existingLogIds)
            ->get();

        $this->assertCount(1, $newLogs, 'Field and group changes should produce exactly one log entry');

        $meta = json_decode($newLogs->first()->log_meta, true);
        $this->assertArrayHasKey('jobtitle', $meta, 'Log should include field change');
        $this->assertArrayHasKey('groups', $meta, 'Log should include group change in same entry');
    }

    public function test_group_only_change_produces_standalone_log_entry()
    {
        [$groupA, $groupB] = Group::factory()->count(2)->create();

        $user = User::factory()->create();
        $user->groups()->sync([$groupA->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        // Patch with no field changes. Only groups differs.
        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'groups' => [$groupB->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->whereNotIn('id', $existingLogIds)
            ->get();

        $this->assertCount(1, $newLogs, 'Group-only change should produce one log entry');

        $meta = json_decode($newLogs->first()->log_meta, true);
        $this->assertArrayHasKey('groups', $meta, 'Log should record group change');
    }

    public function test_log_entry_records_old_and_new_group_snapshots_with_names()
    {
        [$groupA, $groupB, $groupC] = Group::factory()->count(3)
            ->sequence(['name' => 'Alpha'], ['name' => 'Bravo'], ['name' => 'Charlie'])
            ->create();

        $user = User::factory()->create();
        $user->groups()->sync([$groupA->id, $groupB->id]);

        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'groups' => [$groupC->id],
            ])
            ->assertOk();

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $meta = json_decode($log->log_meta, true);

        $this->assertEqualsCanonicalizing(
            [
                ['id' => $groupA->id, 'name' => 'Alpha'],
                ['id' => $groupB->id, 'name' => 'Bravo'],
            ],
            $meta['groups']['old'],
            'Log old snapshot should carry the pre-change group ids AND their names',
        );
        $this->assertEqualsCanonicalizing(
            [
                ['id' => $groupC->id, 'name' => 'Charlie'],
            ],
            $meta['groups']['new'],
            'Log new snapshot should carry the post-change group ids AND their names',
        );
    }

    public function test_transformer_renders_snapshot_names_not_unassigned_placeholders()
    {
        // Regression: clean_field() runs e(json_encode()) on array
        // values, HTML-escaping the quotes inside our snapshot JSON.
        // Without htmlspecialchars_decode before json_decode, the
        // groups handler saw an empty array and rendered "Unassigned"
        // for both old and new, hiding the actual change.
        [$groupA, $groupB] = Group::factory()->count(2)
            ->sequence(['name' => 'Sales'], ['name' => 'Ops'])
            ->create();
        $user = User::factory()->create();
        $user->syncGroupsWithLogging([$groupA->id]);
        $user->syncGroupsWithLogging([$groupB->id]);

        $log = \App\Models\Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $transformed = (new \App\Http\Transformers\ActionlogsTransformer)->transformActionlog($log, \App\Models\Setting::getSettings());

        $meta = $transformed['log_meta'];
        $groupsKey = trans('general.groups');
        $this->assertArrayHasKey($groupsKey, $meta, 'Transformer must relabel groups meta under the general.groups translation key');
        $this->assertSame('Sales', $meta[$groupsKey]['old'], 'Old snapshot must render the historical group name, not "Unassigned"');
        $this->assertSame('Ops', $meta[$groupsKey]['new'], 'New snapshot must render the current group name, not "Unassigned"');
    }

    public function test_group_name_in_log_is_preserved_across_a_rename()
    {
        // The whole point of snapshotting names at write time: the
        // history entry has to read "Alpha" forever, even after the
        // group gets renamed to "Renamed Alpha" later.
        $group = Group::factory()->create(['name' => 'Alpha']);

        $user = User::factory()->create();
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'groups' => [$group->id],
            ])
            ->assertOk();

        $group->update(['name' => 'Renamed Alpha']);

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $meta = json_decode($log->log_meta, true);
        $this->assertSame('Alpha', $meta['groups']['new'][0]['name']);
    }

    public function test_no_change_to_groups_does_not_create_extra_log_entry()
    {
        $group = Group::factory()->create();

        $user = User::factory()->create();
        $user->groups()->sync([$group->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        // Send the same groups, no field changes either.
        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'groups' => [$group->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->whereNotIn('id', $existingLogIds)
            ->count();

        $this->assertEquals(0, $newLogs, 'No changes should produce no new log entries');
    }

    public function test_non_superuser_edit_does_not_change_or_log_groups()
    {
        // Group membership on the API is gated to superusers. A
        // non-superuser editor whose payload includes a groups key
        // must not mutate the pivot AND must not produce a groups
        // log entry, even when other allowed fields are changing.
        $group = Group::factory()->create();
        $otherGroup = Group::factory()->create();

        $user = User::factory()->editUsers()->create(['jobtitle' => 'Engineer']);
        $user->groups()->sync([$group->id]);

        $actor = User::factory()->editUsers()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'jobtitle' => 'Senior Engineer',
                'groups' => [$otherGroup->id],
            ])
            ->assertOk();

        $this->assertEquals(
            [$group->id],
            $user->groups()->pluck('permission_groups.id')->toArray(),
            'Non-superuser must not mutate group pivot',
        );

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $meta = json_decode($log->log_meta ?? '{}', true);
        $this->assertArrayNotHasKey('groups', $meta, 'Non-superuser edit must not log a group change');
    }

    /**
     * Regression guard mirroring the company version. Same hostile
     * shapes: nested array, string-coerceable id, string that
     * intvals to zero, null, boolean, plus real ints. sync() must
     * never see the non-scalars.
     */
    public function test_sync_coerces_non_scalar_group_ids()
    {
        [$groupA, $groupB] = Group::factory()->count(2)->create();

        $user = User::factory()->create();

        $user->syncGroupsWithLogging([
            $groupA->id,
            [$groupB->id, 999],
            (string) $groupB->id,
            'not-a-number',
            null,
            true,
            $groupA->id,
        ]);

        $this->assertEqualsCanonicalizing(
            [$groupA->id, $groupB->id],
            $user->groups()->pluck('permission_groups.id')->toArray(),
            'Only the scalar-coerceable real group ids should end up on the pivot'
        );
    }
}
