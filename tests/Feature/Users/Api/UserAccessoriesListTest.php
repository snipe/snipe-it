<?php

namespace Tests\Feature\Users\Api;

use App\Models\Accessory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserAccessoriesListTest extends TestCase
{
    public function test_endpoint_requires_view_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.users.accessorieslist', ['user' => $user->id]))
            ->assertForbidden();
    }

    public function test_endpoint_returns_one_row_per_pivot_entry(): void
    {
        $user = User::factory()->create();
        $keyboards = Accessory::factory()->create(['name' => 'Keyboards']);
        $mice = Accessory::factory()->create(['name' => 'Mice']);

        DB::table('accessories_checkout')->insert([
            ['accessory_id' => $keyboards->id, 'assigned_to' => $user->id, 'assigned_type' => User::class, 'created_at' => now(), 'note' => 'first'],
            ['accessory_id' => $keyboards->id, 'assigned_to' => $user->id, 'assigned_type' => User::class, 'created_at' => now(), 'note' => 'second'],
            ['accessory_id' => $mice->id, 'assigned_to' => $user->id, 'assigned_type' => User::class, 'created_at' => now(), 'note' => 'third'],
        ]);

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewAccessories()->create())
            ->getJson(route('api.users.accessorieslist', ['user' => $user->id]))
            ->assertOk()
            ->json();

        $this->assertSame(3, $response['total']);
        $this->assertCount(3, $response['rows']);
    }

    public function test_endpoint_paginates_and_reports_metadata(): void
    {
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $rows = array_fill(0, 5, [
            'accessory_id' => $accessory->id,
            'assigned_to' => $user->id,
            'assigned_type' => User::class,
            'created_at' => now(),
        ]);
        DB::table('accessories_checkout')->insert($rows);

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewAccessories()->create())
            ->getJson(route('api.users.accessorieslist', ['user' => $user->id, 'limit' => 2, 'page' => 2]))
            ->assertOk()
            ->json();

        $this->assertSame(5, $response['total']);
        $this->assertCount(2, $response['rows']);
        $this->assertSame(2, $response['per_page']);
        $this->assertSame(2, $response['current_page']);
        $this->assertSame(3, $response['total_pages']);
    }

    public function test_search_filters_by_accessory_name_and_pivot_note(): void
    {
        $user = User::factory()->create();
        $keyboards = Accessory::factory()->create(['name' => 'USB Keyboards']);
        $mice = Accessory::factory()->create(['name' => 'Wireless Mice']);

        DB::table('accessories_checkout')->insert([
            ['accessory_id' => $keyboards->id, 'assigned_to' => $user->id, 'assigned_type' => User::class, 'created_at' => now(), 'note' => 'onboarding'],
            ['accessory_id' => $mice->id, 'assigned_to' => $user->id, 'assigned_type' => User::class, 'created_at' => now(), 'note' => 'replacement'],
        ]);

        $caller = User::factory()->viewUsers()->viewAccessories()->create();

        $byName = $this->actingAsForApi($caller)
            ->getJson(route('api.users.accessorieslist', ['user' => $user->id, 'search' => 'Wireless']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byName['total']);

        $byNote = $this->actingAsForApi($caller)
            ->getJson(route('api.users.accessorieslist', ['user' => $user->id, 'search' => 'onboarding']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byNote['total']);
    }

    public function test_endpoint_resolves_last_unit_cost_in_one_grouped_query(): void
    {
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create(['default_purchase_cost' => '0.10']);
        $orderId = DB::table('orders')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'item_type' => Accessory::class,
            'item_id' => $accessory->id,
            'price' => '0.25',
            'qty' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rows = array_fill(0, 20, [
            'accessory_id' => $accessory->id,
            'assigned_to' => $user->id,
            'assigned_type' => User::class,
            'created_at' => now(),
        ]);
        DB::table('accessories_checkout')->insert($rows);

        DB::enableQueryLog();
        try {
            $response = $this->actingAsForApi(User::factory()->viewUsers()->viewAccessories()->create())
                ->getJson(route('api.users.accessorieslist', ['user' => $user->id]))
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

        $this->assertCount(20, $response['rows']);
        foreach ($response['rows'] as $row) {
            $this->assertNotNull($row['purchase_cost']);
            $this->assertSame((int) $accessory->id, $row['accessory']['id']);
        }
    }
}
