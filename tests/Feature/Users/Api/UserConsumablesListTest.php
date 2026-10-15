<?php

namespace Tests\Feature\Users\Api;

use App\Models\Consumable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Coverage for the new api.users.consumableslist endpoint that
 * replaces the server-side @foreach block on users.show. The tab
 * used to render every pivot row inline and call lastOrderDefaults()
 * per row, which N+1'd into a 502 on users with tens of thousands
 * of consumable checkouts. The endpoint paginates + resolves last
 * unit costs in one grouped query.
 */
class UserConsumablesListTest extends TestCase
{
    public function test_endpoint_requires_view_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.users.consumableslist', ['user' => $user->id]))
            ->assertForbidden();
    }

    public function test_endpoint_returns_one_row_per_pivot_entry(): void
    {
        // Two distinct consumables. First one checked out to the
        // user three separate times so the response has three rows
        // pointing at the same underlying consumable.
        $user = User::factory()->create();
        $pens = Consumable::factory()->create(['name' => 'Pens']);
        $paper = Consumable::factory()->create(['name' => 'Paper']);

        DB::table('consumables_users')->insert([
            ['consumable_id' => $pens->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'first'],
            ['consumable_id' => $pens->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'second'],
            ['consumable_id' => $pens->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'third'],
            ['consumable_id' => $paper->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'reams'],
        ]);

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewConsumables()->create())
            ->getJson(route('api.users.consumableslist', ['user' => $user->id]))
            ->assertOk()
            ->json();

        $this->assertSame(4, $response['total']);
        $this->assertCount(4, $response['rows']);
    }

    public function test_endpoint_paginates_and_reports_metadata(): void
    {
        $user = User::factory()->create();
        $consumable = Consumable::factory()->create();
        $rows = array_fill(0, 5, [
            'consumable_id' => $consumable->id,
            'assigned_to' => $user->id,
            'created_at' => now(),
        ]);
        DB::table('consumables_users')->insert($rows);

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewConsumables()->create())
            ->getJson(route('api.users.consumableslist', ['user' => $user->id, 'limit' => 2, 'page' => 2]))
            ->assertOk()
            ->json();

        $this->assertSame(5, $response['total']);
        $this->assertCount(2, $response['rows']);
        $this->assertSame(2, $response['per_page']);
        $this->assertSame(2, $response['current_page']);
        $this->assertSame(3, $response['total_pages']);
        $this->assertNotNull($response['next_page_url']);
        $this->assertNotNull($response['prev_page_url']);
    }

    public function test_search_filters_by_consumable_name_and_pivot_note(): void
    {
        $user = User::factory()->create();
        $pens = Consumable::factory()->create(['name' => 'Ballpoint Pens']);
        $paper = Consumable::factory()->create(['name' => 'Copier Paper']);

        DB::table('consumables_users')->insert([
            ['consumable_id' => $pens->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'urgent'],
            ['consumable_id' => $paper->id, 'assigned_to' => $user->id, 'created_at' => now(), 'note' => 'routine'],
        ]);

        $caller = User::factory()->viewUsers()->viewConsumables()->create();

        $byName = $this->actingAsForApi($caller)
            ->getJson(route('api.users.consumableslist', ['user' => $user->id, 'search' => 'Ballpoint']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byName['total']);

        $byNote = $this->actingAsForApi($caller)
            ->getJson(route('api.users.consumableslist', ['user' => $user->id, 'search' => 'urgent']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byNote['total']);

        $miss = $this->actingAsForApi($caller)
            ->getJson(route('api.users.consumableslist', ['user' => $user->id, 'search' => 'zzz-nomatch']))
            ->assertOk()
            ->json();
        $this->assertSame(0, $miss['total']);
    }

    public function test_endpoint_resolves_last_unit_cost_in_one_grouped_query(): void
    {
        // Regression test for the reason this endpoint exists at all.
        // A user with N pivot rows would previously issue N per-row
        // queries against order_items to resolve unit_cost. Now
        // OrderItem is touched at most twice regardless of pivot
        // count: once for the MAX(id) GROUP BY, once for the price
        // lookup. lastUnitCostsFor early-returns before the second
        // query when there are no order-item ids on hit, so the
        // "no order history at all" path can even land at once.
        $user = User::factory()->create();
        $consumable = Consumable::factory()->create(['default_purchase_cost' => '0.10']);
        $orderId = DB::table('orders')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'item_type' => Consumable::class,
            'item_id' => $consumable->id,
            'price' => '0.25',
            'qty' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 20 pivot rows pointing at the one consumable.
        $rows = array_fill(0, 20, [
            'consumable_id' => $consumable->id,
            'assigned_to' => $user->id,
            'created_at' => now(),
        ]);
        DB::table('consumables_users')->insert($rows);

        DB::enableQueryLog();
        try {
            $response = $this->actingAsForApi(User::factory()->viewUsers()->viewConsumables()->create())
                ->getJson(route('api.users.consumableslist', ['user' => $user->id]))
                ->assertOk()
                ->json();
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
            'lastUnitCostsFor must hit order_items at most twice regardless of pivot count',
        );

        // Sanity-check the row shape too: 20 rows, all with the
        // resolved price (formatCurrencyOutput of 0.25).
        $this->assertCount(20, $response['rows']);
        foreach ($response['rows'] as $row) {
            $this->assertNotNull($row['purchase_cost']);
            $this->assertSame((int) $consumable->id, $row['consumable']['id']);
        }
    }
}
