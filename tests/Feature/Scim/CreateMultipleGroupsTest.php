<?php

namespace Tests\Feature\Scim;

use App\Models\Group;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Regression coverage for #19493. Reporter (sajax) traced the SCIM group
 * bug to the upstream library's create path in
 * vendor/arietimmerman/laravel-scim-server/src/Http/Controllers/ResourceController.php:71,
 * which does:
 *
 *   $resourceObject = $class::firstOrNew(
 *       $request->has('userName') ? ['username' => $input['userName']] : []
 *   );
 *
 * For User POSTs that's fine. For Group POSTs the ternary always lands
 * on the empty-array branch, and Laravel's Model::firstOrNew([]) returns
 * the first existing row of the table. So the second and every
 * subsequent group POST resolved to the same row (id=1), and the
 * attribute mappers overwrote its name / externalId in place instead
 * of creating a new group. Fix routes SCIM group operations through
 * a SCIMGroup subclass whose firstOrNew always returns a fresh instance
 * on empty-conditions calls.
 */
class CreateMultipleGroupsTest extends TestCase
{
    public function test_two_consecutive_group_posts_create_two_distinct_groups()
    {
        Passport::actingAs(User::factory()->superuser()->create());

        $first = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'externalId' => 'test-group-a',
            'displayName' => 'SCIM Test Group A',
            'members' => [],
            'meta' => ['resourceType' => 'Group'],
        ]);

        $second = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'externalId' => 'test-group-b',
            'displayName' => 'SCIM Test Group B',
            'members' => [],
            'meta' => ['resourceType' => 'Group'],
        ]);

        $first->assertStatus(201);
        $second->assertStatus(201);

        $groupA = Group::where('name', 'SCIM Test Group A')->firstOrFail();
        $groupB = Group::where('name', 'SCIM Test Group B')->firstOrFail();

        $this->assertNotSame(
            $groupA->id,
            $groupB->id,
            'Two consecutive SCIM group POSTs must create two distinct rows, not overwrite the first row.',
        );
    }

    public function test_second_group_post_does_not_overwrite_a_pre_existing_group()
    {
        // Angl0r's scenario. If an admin group existed BEFORE SCIM sync
        // was enabled, the first SCIM group POST used to resolve to that
        // pre-existing row via firstOrNew([]), rewrite its name to the
        // synced group's name, and then every subsequently synced user
        // landed in what was originally the Admins row, silently
        // inheriting the pre-existing group's permission bits.
        $preexisting = Group::factory()->create(['name' => 'Preexisting Admins']);
        $preexistingId = $preexisting->id;

        Passport::actingAs(User::factory()->superuser()->create());

        $response = $this->postJson('/scim/v2/Groups', [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:Group'],
            'externalId' => 'entra-staff-group',
            'displayName' => 'Staff From Entra',
            'members' => [],
            'meta' => ['resourceType' => 'Group'],
        ]);

        $response->assertStatus(201);

        $preexisting->refresh();
        $this->assertSame('Preexisting Admins', $preexisting->name, 'The pre-existing group name must not be overwritten by a SCIM group create.');

        $newGroup = Group::where('name', 'Staff From Entra')->firstOrFail();
        $this->assertNotSame(
            $preexistingId,
            $newGroup->id,
            'The new group must be a new row, not the pre-existing row rewritten.',
        );
    }
}
