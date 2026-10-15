<?php

namespace Tests\Feature\Reporting;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Component;
use App\Models\User;
use Tests\TestCase;

/**
 * CSV export path of the activity report page. Split from
 * ActivityReportPageAuthTest so each file stays under PHPMD's
 * per-class method threshold. Covers the export button surfacing
 * for reports.view holders and scoped viewers, the endpoint's
 * auth gate, and the per-viewable-type row filter applied to the
 * streamed CSV output.
 */
class ActivityReportCsvExportTest extends TestCase
{
    public function test_reports_view_holder_sees_csv_export_button()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->get(route('reports.activity'))
            ->assertOk()
            ->assertSee(route('reports.activity.post'));
    }

    public function test_scoped_viewer_also_sees_csv_export_button()
    {
        // Scoped viewers get an export gated to the same viewable
        // types they see on the page. Filtering happens inside
        // postActivityReport.
        $this->actingAs(User::factory()->viewComponents()->create())
            ->get(route('reports.activity'))
            ->assertOk()
            ->assertSee(route('reports.activity.post'));
    }

    public function test_permissionless_user_cannot_hit_csv_export_endpoint()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('reports.activity.post'))
            ->assertForbidden();
    }

    public function test_scoped_viewer_csv_export_only_contains_rows_for_viewable_types()
    {
        // A components-only viewer's CSV must contain rows for
        // Component actionlogs and omit rows for Asset / License /
        // Consumable / Accessory actionlogs. Same viewable-type
        // filter the on-page endpoint applies.
        $component = Component::factory()->create();
        $asset = Asset::factory()->create();

        Actionlog::factory()->create([
            'item_type' => Component::class,
            'item_id' => $component->id,
            'action_type' => 'checkout',
            'note' => 'COMPONENT_ROW_SENTINEL',
        ]);
        Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_type' => 'checkout',
            'note' => 'ASSET_ROW_SENTINEL',
        ]);

        $body = $this->actingAs(User::factory()->viewComponents()->create())
            ->post(route('reports.activity.post'))
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString('COMPONENT_ROW_SENTINEL', $body);
        $this->assertStringNotContainsString('ASSET_ROW_SENTINEL', $body);
    }

    public function test_reports_view_holder_csv_export_contains_every_type()
    {
        // reports.view holders keep the full unfiltered CSV. Guard
        // against a future refactor that accidentally applies the
        // scoped-viewer filter to admin exports.
        $component = Component::factory()->create();
        $asset = Asset::factory()->create();

        Actionlog::factory()->create([
            'item_type' => Component::class,
            'item_id' => $component->id,
            'action_type' => 'checkout',
            'note' => 'COMPONENT_ROW_SENTINEL',
        ]);
        Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_type' => 'checkout',
            'note' => 'ASSET_ROW_SENTINEL',
        ]);

        $body = $this->actingAs(User::factory()->canViewReports()->create())
            ->post(route('reports.activity.post'))
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString('COMPONENT_ROW_SENTINEL', $body);
        $this->assertStringContainsString('ASSET_ROW_SENTINEL', $body);
    }
}
