<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the JS-visible flag that drives the bulk-actions dropdown on
 * the locations index. bootstrap-table.blade.php intersects each selected
 * row's `available_actions.bulk_selectable` with the dropdown's static
 * action list, so an action only surfaces when every selected row
 * reports it. Locations must report both `edit` and `delete` under
 * bulk_selectable, gated on the acting user's edit permission and the
 * row's deletability respectively.
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_location_reports_edit_and_delete_as_bulk_selectable(): void
    {
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.locations.show', $location))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true);
    }

    public function test_location_with_assets_reports_delete_as_not_bulk_selectable(): void
    {
        // Per-row bulk_selectable is truthful: delete gates on
        // isDeletable() so a location with dependents reports false.
        // bootstrap-table's index-page auto-uncheck picks up that
        // signal and clears the row's checkbox when the operator picks
        // "delete" from the bulk-actions dropdown. Edit stays true
        // because deletability blockers don't affect edit eligibility.
        $location = Location::factory()->create();
        Asset::factory()->for($location, 'location')->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.locations.show', $location))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', false);
    }

    public function test_user_without_edit_permission_reports_edit_as_false(): void
    {
        $location = Location::factory()->create();

        // locations.view grants the show endpoint but not locations.edit,
        // so the row's bulk_selectable.edit must report false.
        $this->actingAsForApi(User::factory()->viewLocationHistory()->create())
            ->getJson(route('api.locations.show', $location))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', false);
    }
}
