<?php

namespace Tests\Feature\Categories\Ui;

use App\Models\Category;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class BulkUpdateCategoriesTest extends TestCase implements TestsPermissionsRequirement
{
    public function test_requires_permission(): void
    {
        $category = Category::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$category->id],
                'require_acceptance' => '1',
            ])
            ->assertForbidden();
    }

    public function test_updates_selected_boolean_fields_across_all_selected_categories(): void
    {
        $a = Category::factory()->create([
            'require_acceptance' => false,
            'use_default_eula' => false,
            'checkin_email' => false,
            'alert_on_response' => false,
        ]);
        $b = Category::factory()->create([
            'require_acceptance' => false,
            'use_default_eula' => false,
            'checkin_email' => false,
            'alert_on_response' => false,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$a->id, $b->id],
                'require_acceptance' => '1',
                'use_default_eula' => '1',
                'checkin_email' => '1',
                'alert_on_response' => '1',
            ])
            ->assertRedirect(route('categories.index'));

        foreach ([$a, $b] as $category) {
            $this->assertDatabaseHas('categories', [
                'id' => $category->id,
                'require_acceptance' => 1,
                'use_default_eula' => 1,
                'checkin_email' => 1,
                'alert_on_response' => 1,
            ]);
        }
    }

    public function test_no_change_sentinel_leaves_field_untouched(): void
    {
        $category = Category::factory()->create([
            'require_acceptance' => true,
            'use_default_eula' => true,
            'checkin_email' => true,
            'alert_on_response' => true,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$category->id],
                'require_acceptance' => '',
                'use_default_eula' => '',
                'checkin_email' => '',
                'alert_on_response' => '0',
            ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'require_acceptance' => 1,
            'use_default_eula' => 1,
            'checkin_email' => 1,
            'alert_on_response' => 0,
        ]);
    }

    public function test_tag_color_persists_when_filled(): void
    {
        $category = Category::factory()->create(['tag_color' => '#111111']);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$category->id],
                'tag_color' => '#abcdef',
            ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'tag_color' => '#abcdef',
        ]);
    }

    public function test_blank_tag_color_leaves_existing_value_untouched(): void
    {
        $category = Category::factory()->create(['tag_color' => '#111111']);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$category->id],
                'require_acceptance' => '1',
                'tag_color' => '',
            ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'tag_color' => '#111111',
        ]);
    }

    public function test_empty_ids_returns_warning(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [],
                'require_acceptance' => '1',
            ])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('error');
    }

    public function test_no_changed_fields_returns_warning(): void
    {
        $category = Category::factory()->create(['require_acceptance' => false]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.bulk.save'), [
                'ids' => [$category->id],
                'require_acceptance' => '',
                'use_default_eula' => '',
                'checkin_email' => '',
                'alert_on_response' => '',
                'tag_color' => '',
            ])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'require_acceptance' => 0,
        ]);
    }
}
