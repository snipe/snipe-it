<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for GH #19548. The bulk-action dropdown on the
 * Locations index was rendering with a form/select id derived from
 * `name="location"` (singular, hardcoded in bulk-locations.blade.php)
 * while the surrounding x-box passed `name="locations"` (plural), so
 * the table ended up with `data-bulk-form-id="#locationsForm"` but the
 * actual form had `id="locationForm"`. The bs-table dynamic-actions JS
 * did `$('#locationsForm').find('select[data-dynamic-actions]')`, got
 * nothing, and returned early. Select2 fell back to "No results found"
 * on click.
 *
 * This test renders the index page and asserts the table's
 * data-bulk-form-id points at a form that actually exists in the DOM.
 * If the two names diverge again, this fails.
 */
class BulkActionDropdownRendersTest extends TestCase
{
    public function test_locations_index_bulk_form_id_matches_form_element_id(): void
    {
        // Seed one location so the table has at least one row and the
        // bulk-actions form renders. Delete-permitted actor so the
        // @can('delete', Location::class) gate in bulk-locations.blade.php
        // passes and the form actually reaches the DOM.
        Location::factory()->create();
        $actor = User::factory()->viewLocationHistory()->deleteLocations()->create();

        $html = $this->actingAs($actor)
            ->get(route('locations.index'))
            ->assertOk()
            ->getContent();

        // Extract the table's data-bulk-form-id.
        $matched = preg_match('/data-bulk-form-id="#([a-zA-Z0-9_-]+)"/', $html, $tableAttr);
        $this->assertSame(1, $matched, 'Locations index must render a data-bulk-form-id on its table.');
        $expectedFormId = $tableAttr[1];

        // Assert a form element with that exact id exists in the same
        // rendered HTML. This is the invariant the dynamic-actions JS
        // depends on: the table's data-bulk-form-id must resolve to a
        // real form. If bulk-locations.blade.php passes a mismatched
        // `name` again, the two IDs diverge and this assertion fails.
        $this->assertStringContainsString(
            'id="'.$expectedFormId.'"',
            $html,
            "Locations index rendered data-bulk-form-id=\"#{$expectedFormId}\" but no element in the page has that id. "
                .'The x-box name in locations/index.blade.php and the name passed to bulk-actions in '
                .'blade/table/bulk-locations.blade.php must match. See GH #19548.'
        );
    }
}
