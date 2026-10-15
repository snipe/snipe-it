<?php

namespace Tests\Feature\Scim;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CreateGroupWithMembersTest extends TestCase
{
    public function test_post_group_with_members_in_initial_body_attaches_pivot_rows()
    {
        // Regression for the Rollbar 23000 crash: the SCIM library runs
        // attribute mappers before saving the parent resource, so a
        // POST /scim/v2/Groups body that carries `members` alongside
        // displayName used to write pivot rows with a NULL group_id
        // and blow up with an integrity-constraint violation. The
        // SnipeMutableCollection::add override saves the parent first.
        Passport::actingAs(User::factory()->superuser()->create());

        $memberOne = User::factory()->create();
        $memberTwo = User::factory()->create();

        $response = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'displayName' => 'SCIM Group With Members',
            'members' => [
                ['value' => $memberOne->id],
                ['value' => $memberTwo->id],
            ],
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('displayName', 'SCIM Group With Members');

        $group = Group::where('name', 'SCIM Group With Members')->firstOrFail();

        $this->assertDatabaseHas('users_groups', [
            'group_id' => $group->id,
            'user_id' => $memberOne->id,
        ]);
        $this->assertDatabaseHas('users_groups', [
            'group_id' => $group->id,
            'user_id' => $memberTwo->id,
        ]);
        $this->assertSame(0, DB::table('users_groups')
            ->where('group_id', $group->id)
            ->whereNull('user_id')
            ->count());
    }

    public function test_post_group_without_members_still_works()
    {
        // Sanity check that the save-if-unsaved shortcut doesn't break the
        // ordinary create path where no members are attached.
        Passport::actingAs(User::factory()->superuser()->create());

        $response = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'displayName' => 'SCIM Group No Members',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('permission_groups', ['name' => 'SCIM Group No Members']);
    }

    public function test_post_group_with_many_members_does_not_explode_validator()
    {
        // Regression for the SCIM group-sync OOM at
        // ValidationRuleParser::mergeRulesForAttribute:227. Previously the
        // per-member `required` rule on `value` caused Laravel to allocate
        // one rule stack per member entry in the flattened payload, so a
        // 101k-member group sync blew a 256MB PHP process before any code
        // ran. Rule was dropped from SnipeSCIMConfig::getGroupConfig and
        // the check moved into SnipeMutableCollection::add so the validator
        // does O(1) work on the members array regardless of size.
        //
        // 25 members here is a proxy for the customer's much larger sync.
        // If the O(N) rule explosion regresses, larger integration
        // environments would OOM again; a per-item explosion at N=25 is
        // fine on 256MB but any code path that reintroduces it is caught
        // by the mechanism-level assertion in
        // GroupMembersValidationShapeTest.
        Passport::actingAs(User::factory()->superuser()->create());

        $members = User::factory()->count(25)->create();

        $response = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'displayName' => 'SCIM Group Many Members',
            'members' => $members->map(fn ($u) => ['value' => $u->id])->all(),
        ]);

        $response->assertStatus(201);
        $group = Group::where('name', 'SCIM Group Many Members')->firstOrFail();
        $this->assertSame(25, DB::table('users_groups')->where('group_id', $group->id)->count());
    }

    public function test_post_group_with_member_missing_value_returns_400_with_indices()
    {
        // Regression for the parent library's 500 with an empty
        // "One or more members are unknown: " message when a members entry
        // arrives without its `value` field. SnipeMutableCollection::add
        // now catches this at attach time with a 400 that names the
        // offending indices, matching how bad request bodies are surfaced
        // elsewhere in the SCIM stack (SnipeRootComplex::add/replace also
        // route malformed keys through 400s).
        Passport::actingAs(User::factory()->superuser()->create());

        $goodMember = User::factory()->create();

        $response = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'displayName' => 'SCIM Group Bad Member',
            'members' => [
                ['value' => $goodMember->id],
                ['display' => 'no value key here'],
                ['value' => null],
            ],
        ]);

        $response->assertStatus(400);
        $body = $response->json();
        $this->assertStringContainsString('Every members entry must include', json_encode($body));
        // Both offending entries by their indices in the payload.
        $this->assertStringContainsString('1', json_encode($body));
        $this->assertStringContainsString('2', json_encode($body));
    }
}
