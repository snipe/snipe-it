<?php

namespace Tests\Feature\Reporting;

use App\Models\User;
use Tests\TestCase;

class UnacceptedAssetReportTest extends TestCase
{
    public function test_permission_required_to_view_unaccepted_asset_report()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('reports/unaccepted_assets'))
            ->assertForbidden();
    }

    public function test_user_can_list_unaccepted_assets()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('reports/unaccepted_assets'))
            ->assertOk();
    }

    public function test_checkoutable_viewer_can_reach_report_without_reports_view_permission()
    {
        // Dashboard's Needs Attention widget links every checkoutable
        // viewer to this report. Without the widened gate the link
        // 403s for scoped viewers, which is what this test guards
        // against. See getAssetAcceptanceReport() in ReportsController.
        $this->actingAs(User::factory()->viewComponents()->create())
            ->get(route('reports/unaccepted_assets'))
            ->assertOk();
    }

    public function test_mutating_endpoints_still_require_reports_view_for_scoped_viewer()
    {
        // The GET report page was widened to accept checkoutable
        // viewers, but the CSV export (postAssetAcceptanceReport),
        // sent-reminder, and delete-acceptance endpoints all still
        // authorize reports.view directly. A scoped viewer arriving
        // via the Needs Attention widget sees a read-only list. The
        // blade hides the mutating buttons because
        // $canManageAcceptances is false, but the underlying route
        // gates are what actually enforce it and are pinned here.
        $viewer = User::factory()->viewComponents()->create();

        $this->actingAs($viewer)
            ->post(route('reports/export/unaccepted_assets'))
            ->assertForbidden();
    }
}
