<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the per-row eligibility flags that drive the hardware index and every
 * assets-tab embed's bulk-actions dropdown. `available_actions.bulk_selectable`
 * exposes 8 keys (edit, maintenance, checkout, checkin, audit, delete, labels,
 * restore); the dropdown intersects them across selected rows. Status filtering
 * that the pre-refactor hand-rolled widget did via a `status_type` prop now falls
 * out of these per-row flags: deleted rows only surface `restore`, assigned rows
 * hide `checkout`/`delete`, unassigned rows hide `checkin`, etc.
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_unassigned_asset_supports_edit_maintenance_checkout_audit_delete_labels()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.maintenance', true)
            ->assertJsonPath('available_actions.bulk_selectable.checkout', true)
            ->assertJsonPath('available_actions.bulk_selectable.checkin', false)
            ->assertJsonPath('available_actions.bulk_selectable.audit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true)
            ->assertJsonPath('available_actions.bulk_selectable.labels', true)
            ->assertJsonPath('available_actions.bulk_selectable.restore', false);
    }

    public function test_assigned_asset_hides_checkout_and_delete_and_shows_checkin()
    {
        $assignee = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignee)->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.checkout', false)
            ->assertJsonPath('available_actions.bulk_selectable.checkin', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.labels', true)
            ->assertJsonPath('available_actions.bulk_selectable.restore', false);
    }

    public function test_soft_deleted_asset_surfaces_only_restore()
    {
        $asset = Asset::factory()->create();
        $asset->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('available_actions.bulk_selectable.maintenance', false)
            ->assertJsonPath('available_actions.bulk_selectable.checkout', false)
            ->assertJsonPath('available_actions.bulk_selectable.checkin', false)
            ->assertJsonPath('available_actions.bulk_selectable.audit', false)
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.labels', false)
            ->assertJsonPath('available_actions.bulk_selectable.restore', true);
    }

    public function test_user_without_edit_permission_gets_edit_and_maintenance_false()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('available_actions.bulk_selectable.maintenance', false);
    }

    public function test_user_without_checkout_permission_gets_checkout_false()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.checkout', false);
    }

    public function test_user_without_checkin_permission_gets_checkin_false()
    {
        $assignee = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignee)->create();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.checkin', false);
    }

    public function test_user_without_audit_permission_gets_audit_false()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.audit', false);
    }

    public function test_user_without_delete_permission_gets_delete_false()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false);
    }

    public function test_user_without_create_permission_gets_restore_false()
    {
        $asset = Asset::factory()->create();
        $asset->delete();

        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.assets.show', $asset))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.restore', false);
    }
}
