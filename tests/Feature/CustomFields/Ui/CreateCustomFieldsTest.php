<?php

namespace Tests\Feature\CustomFields\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateCustomFieldsTest extends TestCase
{
    public function test_user_without_create_permission_cannot_reach_create_page()
    {
        // fields.create routes directly to the CustomFieldEditor Livewire
        // component; mount() checks the 'create' policy. A user with only
        // 'view' can't reach the authoring form.
        $this->actingAs(User::factory()->viewCustomFields()->create())
            ->get(route('fields.create'))
            ->assertForbidden();
    }

    public function test_user_with_create_can_reach_create_page()
    {
        // Route no longer requires view permission separately — create is
        // the authoring gate for the authoring form.
        $this->actingAs(User::factory()->createCustomFields()->create())
            ->get(route('fields.create'))
            ->assertOk();
    }

    public function test_superuser_can_reach_create_page()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('fields.create'))
            ->assertOk();
    }
}
