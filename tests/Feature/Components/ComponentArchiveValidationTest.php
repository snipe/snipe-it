<?php

namespace Tests\Feature\Components;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Component;
use Tests\TestCase;

/**
 * Exercises Watson's integration of the archive-related rules on the
 * Component model (the mutex plus the no-archive-with-active-checkouts
 * guard). These fire through getRules() so test the full save path
 * end-to-end rather than hitting the Rule classes in isolation.
 */
class ComponentArchiveValidationTest extends TestCase
{
    public function test_component_can_save_as_requestable_without_archived(): void
    {
        $component = Component::factory()->create();

        $component->requestable = 1;
        $component->archived = 0;

        $this->assertTrue($component->save());
    }

    public function test_component_can_save_as_archived_without_requestable(): void
    {
        $component = Component::factory()->create();

        $component->archived = 1;
        $component->requestable = 0;

        $this->assertTrue($component->save());
    }

    public function test_component_cannot_save_as_both_requestable_and_archived(): void
    {
        $component = Component::factory()->create();

        $component->requestable = 1;
        $component->archived = 1;

        $this->assertFalse($component->save());
        $this->assertArrayHasKey('archived', $component->getErrors()->toArray());
        $this->assertArrayHasKey('requestable', $component->getErrors()->toArray());
    }

    public function test_component_with_active_checkouts_cannot_be_archived(): void
    {
        $component = Component::factory()->create(['qty' => 10]);
        $asset = Asset::factory()->create();
        $component->assets()->attach($asset->id, [
            'assigned_qty' => 2,
            'created_at' => now(),
            'created_by' => 1,
        ]);

        $component->archived = 1;

        $this->assertFalse($component->save());
        $this->assertSame(
            trans('admin/components/message.archived_blocked_by_checkouts'),
            $component->getErrors()->get('archived')[0],
        );
    }

    public function test_component_without_active_checkouts_can_be_archived(): void
    {
        $component = Component::factory()->create(['qty' => 10]);

        $component->archived = 1;

        $this->assertTrue($component->save());
    }

    public function test_new_component_can_be_created_as_archived(): void
    {
        // Regression check: ComponentsController::store() was setting
        // every attribute by hand and skipping `archived`, so a form
        // POST with `archived=1` persisted as 0. Pin so a future refactor
        // can't silently drop the field again.
        $component = new Component([
            'name' => 'archived at birth',
            'qty' => 1,
            'category_id' => Category::factory()->create()->id,
        ]);
        $component->archived = 1;

        $this->assertTrue($component->save());
        $this->assertTrue((bool) $component->fresh()->archived);
    }
}
