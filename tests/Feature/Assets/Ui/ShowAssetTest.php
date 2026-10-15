<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\OrderItem;
use App\Models\User;
use Tests\TestCase;

class ShowAssetTest extends TestCase
{
    public function test_permission_required_to_view_asset()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('hardware.show', Asset::factory()->create()))
            ->assertForbidden();
    }

    public function test_can_view_asset()
    {
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('hardware.show', $asset))
            ->assertSeeText($asset->asset_tag)
            ->assertOk();
    }

    public function test_page_renders_when_journal_note_has_no_author()
    {
        $asset = Asset::factory()->create();

        Actionlog::factory()->for($asset, 'item')->create([
            'action_type' => 'note added',
            'item_type' => Asset::class,
            'note' => 'A note with no author',
            'created_by' => null,
        ]);

        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk();
    }

    public function test_maintenance_tab_ships_complete_button_infrastructure()
    {
        // Regression guard for #issue: the mark-complete button previously
        // rendered only on the maintenances index page because the custom
        // maintenancesActionsFormatter override lived in that page's inline
        // <script>. It now lives in partials/bootstrap-table.blade.php and
        // the confirmation modal in x-modals.maintenance-complete, so any
        // page rendering the maintenances table (including the asset view)
        // must ship both.
        $asset = Asset::factory()->create();

        $response = $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk();

        $response->assertSee('id="completeMaintenanceModal"', false);
        $response->assertSee('maintenancesActionsFormatter', false);
        $response->assertSee('complete-maintenance', false);
    }

    public function test_info_panel_purchase_date_reflects_the_edited_asset_value_not_the_snapshot_from_create()
    {
        // GH #19572: the observer writes an Order + OrderItem at create
        // and does not sync purchase_date back on subsequent asset
        // edits (multiple assets can share one Order row, so
        // per-asset writes there would drag siblings along). Before
        // the fix, the info-panel preferred Order.purchase_date via
        // lastOrderDefaults() using ?:, so once the initial snapshot
        // carried any date the asset's own purchase_date was never
        // rendered again. Now the parent's canonical value wins.
        $asset = Asset::factory()->create([
            'purchase_date' => '2020-01-07',
        ]);

        $asset->purchase_date = '2028-07-01';
        $asset->save();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk()
            ->assertSee('2028-07-01')
            ->assertDontSee('2020-01-07');
    }

    public function test_info_panel_unit_cost_reflects_the_edited_asset_value_when_the_order_item_is_out_of_sync()
    {
        // GH #19572, unit cost row. The AssetObserver::updated hook syncs
        // purchase_cost onto the OrderItem for edits made post-#19564,
        // but assets edited before that hook landed still carry
        // divergent OrderItem.price values. This test simulates that
        // legacy drift by writing straight to the OrderItem row and
        // confirms the info-panel reads the asset's own purchase_cost
        // in preference to the stale line-item price.
        $asset = Asset::factory()->create([
            'purchase_cost' => 199.99,
        ]);

        // Simulate historic drift: OrderItem.price stuck at the
        // original create-time snapshot, asset.purchase_cost has since
        // been corrected in-place. We reach past the observer here to
        // reproduce the pre-#19564 state on purpose.
        OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->update(['price' => 199.99]);

        $asset->purchase_cost = 42.00;
        $asset->saveQuietly();

        OrderItem::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->update(['price' => 199.99]);

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk()
            ->assertSee('42.00')
            ->assertDontSee('199.99');
    }

    public function test_page_for_asset_with_missing_model_still_renders()
    {
        $asset = Asset::factory()->create();

        $asset->model_id = null;
        $asset->forceSave();

        $asset->refresh();

        $this->assertNull($asset->fresh()->model_id, 'This test needs model_id to be null to be helpful.');

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk();
    }
}
