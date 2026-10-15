<?php

namespace Tests\Feature\Licenses\Api;

use App\Models\Asset;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the per-row eligibility flags that drive the licenses index bulk-actions
 * dropdown. `available_actions.bulk_selectable.delete` gates the plain delete action
 * (only clean licenses); `available_actions.bulk_selectable.delete_with_checkin`
 * gates the check-in-and-delete action (any license the user can delete, regardless
 * of assigned seats). The dropdown intersects these keys across all selected rows.
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_license_supports_both_delete_actions()
    {
        $license = License::factory()->create(['seats' => 5]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.licenses.show', $license))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete_with_checkin', true);
    }

    public function test_license_with_assigned_user_seat_only_supports_delete_with_checkin()
    {
        $license = License::factory()->create(['seats' => 5]);
        $license->licenseseats->first()->update(['assigned_to' => User::factory()->create()->id]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.licenses.show', $license))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.delete_with_checkin', true);
    }

    public function test_license_with_assigned_asset_seat_only_supports_delete_with_checkin()
    {
        $license = License::factory()->create(['seats' => 5]);
        $asset = Asset::factory()->create();
        $license->licenseseats->first()->update(['asset_id' => $asset->id]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.licenses.show', $license))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.delete_with_checkin', true);
    }

    public function test_user_with_delete_but_not_checkin_permission_cannot_delete_with_checkin()
    {
        $license = License::factory()->create(['seats' => 5]);

        $this->actingAsForApi(User::factory()->viewLicenses()->deleteLicenses()->create())
            ->getJson(route('api.licenses.show', $license))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete_with_checkin', false);
    }

    public function test_user_without_delete_permission_gets_false_for_both()
    {
        $license = License::factory()->create(['seats' => 5]);

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.show', $license))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.delete_with_checkin', false);
    }
}
