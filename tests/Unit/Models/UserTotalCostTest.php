<?php

namespace Tests\Unit\Models;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Pins User::getUserTotalCost() — the source of every value rendered in the
 * "user well" on the user detail page (assets/licenses/accessories costs +
 * maintenance cost + active-maintenance count + grand total). All five
 * fields are computed in one pass so the blade can call the method four
 * times in a row without paying for redundant relation queries.
 */
class UserTotalCostTest extends TestCase
{
    public function test_maintenance_cost_sums_complete_and_active_records(): void
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        // Mix of completed + active maintenances. The observer copies
        // checked_out_to_* from the asset's assigned_to/_type at insert
        // time, so all three of these will be tagged to $user.
        Maintenance::factory()->create(['asset_id' => $asset->id, 'cost' => 100.00, 'completed_at' => null]);
        Maintenance::factory()->create(['asset_id' => $asset->id, 'cost' => 50.50, 'completed_at' => now()]);
        Maintenance::factory()->create(['asset_id' => $asset->id, 'cost' => 25.00, 'completed_at' => null]);

        $totals = $user->getUserTotalCost();

        $this->assertEqualsWithDelta(175.50, (float) $totals->maintenance_cost, 0.001);
    }

    public function test_total_user_cost_now_rolls_maintenance_cost_into_the_grand_total(): void
    {
        // Previously total_user_cost = assets + licenses + accessories. After
        // the user-detail well started surfacing maintenance cost, the "total"
        // line needed to include it too so the rows still add up visually.
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create(['purchase_cost' => 200]);
        Maintenance::factory()->create(['asset_id' => $asset->id, 'cost' => 40.00]);

        $totals = $user->getUserTotalCost();

        $this->assertEqualsWithDelta(200, (float) $totals->asset_cost, 0.001);
        $this->assertEqualsWithDelta(40, (float) $totals->maintenance_cost, 0.001);
        $this->assertEqualsWithDelta(
            (float) $totals->asset_cost + (float) $totals->license_cost + (float) $totals->accessory_cost + (float) $totals->maintenance_cost,
            (float) $totals->total_user_cost,
            0.001,
            'total_user_cost must include maintenance_cost so the well rows add up',
        );
    }

    public function test_zero_state_when_user_has_no_records(): void
    {
        $user = User::factory()->create();

        $totals = $user->getUserTotalCost();

        $this->assertEqualsWithDelta(0, (float) $totals->maintenance_cost, 0.001);
        $this->assertEqualsWithDelta(0, (float) $totals->total_user_cost, 0.001);
    }

    public function test_consumable_cost_multiplies_unit_cost_by_pivot_row_count(): void
    {
        // Regression: the summary panel used to iterate the
        // belongsToMany collection which contains one row per
        // checkout event. A user handed 500 boxes of pens at $0.10
        // must total $50, not $0.10. The DB-aggregate path replaces
        // that foreach so we pin the pivot-count-times-unit-cost
        // math here.
        $user = User::factory()->create();
        $pens = Consumable::factory()->create(['default_purchase_cost' => '0.10']);
        $paper = Consumable::factory()->create(['default_purchase_cost' => '1.50']);

        $rows = [];
        for ($i = 0; $i < 500; $i++) {
            $rows[] = ['consumable_id' => $pens->id, 'assigned_to' => $user->id, 'created_at' => now()];
        }
        for ($i = 0; $i < 3; $i++) {
            $rows[] = ['consumable_id' => $paper->id, 'assigned_to' => $user->id, 'created_at' => now()];
        }
        DB::table('consumables_users')->insert($rows);

        $totals = $user->getUserTotalCost();

        // 500 * $0.10 + 3 * $1.50 = $54.50
        $this->assertEqualsWithDelta(54.50, (float) $totals->consumable_cost, 0.001);
    }

    public function test_summary_computes_without_hitting_order_items_per_pivot_row(): void
    {
        // Regression coverage for the 502-on-huge-user bug. The
        // aggregate must touch order_items at most twice regardless
        // of how many pivot rows the user has.
        $user = User::factory()->create();
        $consumable = Consumable::factory()->create(['default_purchase_cost' => '0.10']);

        $rows = array_fill(0, 100, [
            'consumable_id' => $consumable->id,
            'assigned_to' => $user->id,
            'created_at' => now(),
        ]);
        DB::table('consumables_users')->insert($rows);

        DB::enableQueryLog();
        try {
            $user->getUserTotalCost();
        } finally {
            $queries = DB::getQueryLog();
            DB::disableQueryLog();
        }

        $orderItemQueries = array_filter(
            $queries,
            fn ($q) => str_contains(strtolower($q['query']), 'order_items'),
        );
        $this->assertLessThanOrEqual(
            2,
            count($orderItemQueries),
            'getUserTotalCost must resolve unit costs in at most 2 grouped queries, not one per pivot row',
        );
    }

    public function test_repeated_calls_memoize_and_do_not_re_query(): void
    {
        // The Blade show-user page reads $user->getUserTotalCost()
        // seven times. Regression coverage for the memoization guard:
        // the second call must execute zero DB queries.
        $user = User::factory()->create();
        $consumable = Consumable::factory()->create();
        DB::table('consumables_users')->insert([
            ['consumable_id' => $consumable->id, 'assigned_to' => $user->id, 'created_at' => now()],
        ]);

        $user->getUserTotalCost();

        DB::enableQueryLog();
        try {
            $user->getUserTotalCost();
            $user->getUserTotalCost();
            $user->getUserTotalCost();
        } finally {
            $queries = DB::getQueryLog();
            DB::disableQueryLog();
        }

        $this->assertCount(0, $queries, 'Subsequent calls to getUserTotalCost must be memoized');
    }

    public function test_accessory_cost_ignores_pivot_rows_for_other_target_types(): void
    {
        // accessories_checkout is polymorphic (users, assets,
        // locations). The aggregate must filter to
        // assigned_type = User so a device checkout of the same
        // accessory doesn't inflate the user's summary.
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create(['default_purchase_cost' => '5.00']);

        DB::table('accessories_checkout')->insert([
            [
                'accessory_id' => $accessory->id,
                'assigned_to' => $user->id,
                'assigned_type' => User::class,
                'created_at' => now(),
            ],
            [
                'accessory_id' => $accessory->id,
                'assigned_to' => 99_999_999,
                'assigned_type' => Asset::class,
                'created_at' => now(),
            ],
        ]);

        $totals = $user->getUserTotalCost();

        // One user pivot row * $5.00. The Asset pivot row must not
        // contribute even though it points at the same accessory
        // and would inflate the sum without the assigned_type
        // filter.
        $this->assertEqualsWithDelta(5.00, (float) $totals->accessory_cost, 0.001);
    }
}
