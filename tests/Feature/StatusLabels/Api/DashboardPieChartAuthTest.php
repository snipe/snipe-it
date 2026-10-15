<?php

namespace Tests\Feature\StatusLabels\Api;

use App\Models\User;
use Tests\TestCase;

/**
 * The dashboard's Assets-by-Status pie chart fetches its data from
 * api.statuslabels.assets.byname and api.statuslabels.assets.bytype.
 * Both endpoints used to require statuslabels.view, which broke the
 * chart for asset viewers who don't also have status-label admin
 * permission. The chart payload is aggregate asset counts bucketed
 * by status, so an asset viewer already has read on the underlying
 * data. These tests pin the widened gate so a future refactor
 * doesn't quietly re-narrow it and break the dashboard again.
 */
class DashboardPieChartAuthTest extends TestCase
{
    public function test_asset_viewer_can_reach_pie_chart_by_name_endpoint()
    {
        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.statuslabels.assets.byname'))
            ->assertOk();
    }

    public function test_asset_viewer_can_reach_pie_chart_by_meta_status_endpoint()
    {
        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.statuslabels.assets.bytype'))
            ->assertOk();
    }

    public function test_status_label_viewer_without_asset_view_can_still_reach_pie_chart_by_name()
    {
        $this->actingAsForApi(User::factory()->create([
            'permissions' => json_encode(['statuslabels.view' => '1']),
        ]))
            ->getJson(route('api.statuslabels.assets.byname'))
            ->assertOk();
    }

    public function test_status_label_viewer_without_asset_view_can_still_reach_pie_chart_by_meta_status()
    {
        $this->actingAsForApi(User::factory()->create([
            'permissions' => json_encode(['statuslabels.view' => '1']),
        ]))
            ->getJson(route('api.statuslabels.assets.bytype'))
            ->assertOk();
    }

    public function test_user_with_no_relevant_permissions_is_forbidden_from_pie_chart_by_name()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.statuslabels.assets.byname'))
            ->assertForbidden();
    }

    public function test_user_with_no_relevant_permissions_is_forbidden_from_pie_chart_by_meta_status()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.statuslabels.assets.bytype'))
            ->assertForbidden();
    }
}
