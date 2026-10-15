<?php

namespace Tests\Feature\CalendarEvents;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CalendarEvent;
use App\Models\Category;
use App\Models\License;
use App\Models\Maintenance;
use App\Models\Traits\HasCalendarEvents;
use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for CalendarEvent::sourceModels() - the single source of
 * truth for "which models publish calendar events." Consumed by:
 *
 *   - Api\CalendarEventsController's base "can view any source" gate
 *   - Console\Commands\ReconcileCalendarEvents
 *   - The two calendar_events backfill migrations
 *
 * A regression here would silently break any of those - a model
 * dropping out of the returned list would stop syncing to
 * calendar_events, wouldn't get reconciled, and its view permission
 * wouldn't count toward the base calendar-page gate. Worth locking
 * down.
 */
class CalendarEventSourceDiscoveryTest extends TestCase
{
    public function test_returns_array_of_class_strings(): void
    {
        $sources = CalendarEvent::sourceModels();

        $this->assertIsArray($sources);
        $this->assertNotEmpty($sources, 'sourceModels() should discover at least one HasCalendarEvents adopter.');

        foreach ($sources as $source) {
            $this->assertIsString($source);
            $this->assertTrue(class_exists($source), "Discovered source {$source} should be a real class.");
        }
    }

    public function test_includes_every_current_hascalendarevents_adopter(): void
    {
        $sources = CalendarEvent::sourceModels();

        // Every model currently using the trait should show up.
        // If any of these fail, either the model dropped the trait
        // (and the failing assertion should update to match) or the
        // discovery logic broke and needs a fix.
        $this->assertContains(Asset::class, $sources);
        $this->assertContains(License::class, $sources);
        $this->assertContains(User::class, $sources);
        $this->assertContains(Maintenance::class, $sources);
    }

    public function test_excludes_models_that_do_not_use_the_trait(): void
    {
        $sources = CalendarEvent::sourceModels();

        // Sanity: models that don't declare calendar events should
        // NOT appear in the source list. Prevents the discovery from
        // regressing to "every model in app/Models" via, e.g., a
        // misplaced use statement on a parent class.
        $this->assertNotContains(Accessory::class, $sources);
        $this->assertNotContains(Category::class, $sources);
        // CalendarEvent itself doesn't publish events; it stores them.
        $this->assertNotContains(CalendarEvent::class, $sources);
    }

    public function test_every_returned_source_actually_uses_the_trait(): void
    {
        foreach (CalendarEvent::sourceModels() as $source) {
            $this->assertContains(
                HasCalendarEvents::class,
                class_uses_recursive($source),
                "{$source} was discovered but doesn't use HasCalendarEvents.",
            );
        }
    }

    public function test_result_is_cached_across_calls(): void
    {
        // Two back-to-back calls should return the exact same array
        // (identity-equal via ===) because the second call is served
        // from the static cache without re-globbing app/Models.
        $first = CalendarEvent::sourceModels();
        $second = CalendarEvent::sourceModels();

        $this->assertSame($first, $second);
    }
}
