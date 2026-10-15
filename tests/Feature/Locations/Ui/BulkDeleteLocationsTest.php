<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class BulkDeleteLocationsTest extends TestCase
{
    public function test_shows_confirmation_when_at_least_one_location_is_deletable()
    {
        // One location has assets (not deletable), one is clean.
        $locationWithAssets = Location::factory()->create();
        Asset::factory()->for($locationWithAssets, 'location')->create();
        $cleanLocation = Location::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkdelete.show'), [
                'ids' => [$locationWithAssets->id, $cleanLocation->id],
            ])
            ->assertStatus(200)
            ->assertSee($locationWithAssets->name)
            ->assertSee($cleanLocation->name);
    }

    public function test_redirects_to_index_with_error_when_no_selected_locations_are_deletable()
    {
        // Both locations have assets, so neither is deletable.
        $locationA = Location::factory()->create();
        Asset::factory()->for($locationA, 'location')->create();
        $locationB = Location::factory()->create();
        Asset::factory()->for($locationB, 'location')->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.index'))
            ->post(route('locations.bulkdelete.show'), [
                'ids' => [$locationA->id, $locationB->id],
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('error');
    }

    public function test_redirects_to_index_when_no_locations_selected()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.index'))
            ->post(route('locations.bulkdelete.show'), [
                'ids' => null,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('error');
    }

    public function test_confirmation_view_shows_blocking_dependency_counts_for_undeletable_rows()
    {
        // Populate several dependent-relations on the undeletable row
        // so the confirm view can render the per-icon counts for each.
        // Uses the icon-column layout mirroring users/confirm-bulk-delete:
        // each dependency type gets its own column with a header icon
        // and a per-row numeric count that is text-danger when >0.
        $undeletable = Location::factory()->create();
        Asset::factory()->count(2)->for($undeletable, 'location')->create();
        Location::factory()->count(3)->create(['parent_id' => $undeletable->id]);
        $deletable = Location::factory()->create();

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkdelete.show'), [
                'ids' => [$undeletable->id, $deletable->id],
            ])
            ->assertStatus(200);

        // Column icons in the table header. Icons match the tabs on the
        // location view page so the two surfaces read consistently.
        $response->assertSee('fa-barcode', false);
        $response->assertSee('fa-city', false);

        // Per-row counts on the undeletable row. 2 assets (assets_count
        // column) + 3 children (children_count column) each render in
        // their own cell as `text-danger">N</td>` when non-zero.
        $response->assertSee('text-danger">2</td>', false);
        $response->assertSee('text-danger">3</td>', false);
    }

    public function test_confirmation_view_shows_partial_selection_warning_when_some_rows_are_undeletable()
    {
        $undeletable = Location::factory()->create();
        Asset::factory()->for($undeletable, 'location')->create();
        $deletable = Location::factory()->create();

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkdelete.show'), [
                'ids' => [$undeletable->id, $deletable->id],
            ])
            ->assertStatus(200);

        // The partial-selection copy names both the selected count and
        // the smaller deletable count so the operator sees the batch
        // isn't going to fire against every row.
        $response->assertSeeText('You selected 2');
        $response->assertSeeText('1 will be deleted');
    }
}
