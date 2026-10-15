<?php

namespace Tests\Feature\Scim;

use App\Models\Department;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Regression for a Rollbar 500 on /scim/v2/Users/{id}:
 *
 *   TypeError Illuminate\Database\Grammar::parameterize():
 *   Argument #1 ($values) must be of type array, string given
 *   at MappedTable::replace (SnipeSCIMConfig.php:293)
 *
 * MappedTable is a leaf attribute for the User schema's `department`
 * and `location` fields — both scalar-mapped foreign relations.
 * SCIM clients (Entra, Okta in some configurations) send those as
 * complex objects: {"department": {"value": "Engineering"}} or
 * {"department": {"displayName": "Engineering"}}. The parent
 * SnipeRootComplex router also wraps sub-attribute values into an
 * array on the descent. Either way, MappedTable was receiving an
 * array in a code path that unconditionally passed it to
 * firstOrCreate() as a WHERE value — triggering the Grammar TypeError.
 *
 * The fix coerces array inputs to their SCIM-standard scalar leaf
 * (`value` / `displayName`, then any first scalar) before hitting
 * firstOrCreate.
 */
class MappedTableComplexValueTest extends TestCase
{
    public function test_put_with_department_as_complex_value_object_does_not_crash(): void
    {
        Passport::actingAs(User::factory()->superuser()->create());
        $target = User::factory()->create();

        $response = $this->putJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:User'],
            'userName' => $target->username,
            'department' => ['value' => 'Engineering'],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('departments', ['name' => 'Engineering']);
        $target->refresh();
        $this->assertSame('Engineering', $target->department->name);
    }

    public function test_put_with_department_as_display_name_object_does_not_crash(): void
    {
        Passport::actingAs(User::factory()->superuser()->create());
        $target = User::factory()->create();

        $response = $this->putJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:User'],
            'userName' => $target->username,
            'department' => ['displayName' => 'Product'],
        ]);

        $response->assertStatus(200);
        $target->refresh();
        $this->assertSame('Product', $target->department->name);
    }

    public function test_put_with_location_as_complex_value_object_does_not_crash(): void
    {
        Passport::actingAs(User::factory()->superuser()->create());
        $target = User::factory()->create();

        $response = $this->putJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:User'],
            'userName' => $target->username,
            'location' => ['value' => 'HQ'],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('locations', ['name' => 'HQ']);
        $target->refresh();
        $this->assertSame('HQ', $target->location->name);
    }

    public function test_put_with_scalar_department_still_works(): void
    {
        // Non-regression guard: the historical scalar shape must
        // continue to work unchanged.
        Passport::actingAs(User::factory()->superuser()->create());
        $target = User::factory()->create();

        $response = $this->putJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:User'],
            'userName' => $target->username,
            'department' => 'Support',
        ]);

        $response->assertStatus(200);
        $target->refresh();
        $this->assertSame('Support', $target->department->name);
    }

    public function test_patch_replace_with_complex_department_value_does_not_crash(): void
    {
        // PATCH shape from Entra / Okta: op=replace, no top-level
        // path, complex value under the attribute key.
        Passport::actingAs(User::factory()->superuser()->create());
        $target = User::factory()->create();

        $response = $this->patchJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                [
                    'op' => 'replace',
                    'value' => [
                        'department' => ['value' => 'Finance'],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(200);
        $target->refresh();
        $this->assertSame('Finance', $target->department->name);
    }

    public function test_put_with_empty_complex_department_object_nulls_relationship(): void
    {
        // Clients sometimes send {} to clear a relationship. The
        // coercion falls through to null, which the caller uses to
        // null the foreign-key column. No crash, no orphan row.
        Passport::actingAs(User::factory()->superuser()->create());
        $existingDepartment = Department::factory()->create();
        $target = User::factory()->create(['department_id' => $existingDepartment->id]);

        $response = $this->putJson('/scim/v2/Users/'.$target->id, [
            'schemas' => ['urn:ietf:params:scim:schemas:core:2.0:User'],
            'userName' => $target->username,
            'department' => new \stdClass, // empty object → [] on decode
        ]);

        $response->assertStatus(200);
        $target->refresh();
        $this->assertNull($target->department_id);
    }
}
