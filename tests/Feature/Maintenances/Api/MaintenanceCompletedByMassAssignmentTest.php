<?php

namespace Tests\Feature\Maintenances\Api;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\User;
use Tests\TestCase;

/**
 * PATCH /api/v1/maintenances/{id} previously filled the model from
 * request input while excluding only asset_id, item_id, and item_type.
 * completed_by passed through, letting a user with assets.edit forge
 * the completion attribution on a maintenance they can update
 * (CWE-915). The fix adds completed_by to the exclusion list so the
 * attribution column can only be written by the dedicated complete()
 * action which sets it from the authenticated user.
 */
class MaintenanceCompletedByMassAssignmentTest extends TestCase
{
    public function test_patch_cannot_set_completed_by_to_another_user()
    {
        $editor = User::factory()->editAssets()->create();
        $otherAdmin = User::factory()->superuser()->create();

        $asset = Asset::factory()->create();
        $maintenance = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'completed_by' => null,
        ]);

        $this->actingAsForApi($editor)
            ->patchJson(route('api.maintenances.update', $maintenance->id), [
                'completed_by' => $otherAdmin->id,
            ]);

        $maintenance->refresh();

        $this->assertNull(
            $maintenance->completed_by,
            'completed_by must stay null when it was null before. The update endpoint must not accept a client-supplied value for this attribution column.'
        );
    }

    public function test_patch_does_not_overwrite_existing_completed_by()
    {
        $editor = User::factory()->editAssets()->create();
        $existingCompleter = User::factory()->superuser()->create();
        $otherAdmin = User::factory()->superuser()->create();

        $asset = Asset::factory()->create();
        $maintenance = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'completed_by' => $existingCompleter->id,
        ]);

        $this->actingAsForApi($editor)
            ->patchJson(route('api.maintenances.update', $maintenance->id), [
                'completed_by' => $otherAdmin->id,
                'notes' => 'editing other legitimate fields',
            ]);

        $maintenance->refresh();

        $this->assertSame(
            $existingCompleter->id,
            $maintenance->completed_by,
            'An existing completed_by must survive a PATCH that attempts to overwrite it. The dedicated complete() action is the only legitimate writer.'
        );
    }
}
