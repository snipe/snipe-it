<?php

namespace Tests\Feature;

use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * The dashboard's Low Stock widget hits /api/v1/low-stock. Before
 * this filter, the endpoint returned rows for every source model
 * (consumable / accessory / component / model / license) to any
 * viewer who could see at least one of them. A viewer with only
 * accessories.view would see consumable + component + license rows
 * they can't otherwise reach through the app.
 *
 * The controller now filters rows by per-type view permission before
 * pagination, so the widget's contents match what the caller could
 * see if they clicked through to the underlying index.
 */
class LowStockApiVisibilityTest extends TestCase
{
    public function test_accessory_only_viewer_does_not_see_consumable_low_stock_rows(): void
    {
        // A low-stock accessory the caller CAN see.
        Accessory::factory()->create([
            'name' => 'Low Accessory',
            'qty' => 1,
            'min_amt' => 5,
        ]);

        // A low-stock consumable the caller CANNOT see.
        Consumable::factory()->create([
            'name' => 'Low Consumable',
            'qty' => 1,
            'min_amt' => 5,
        ]);

        Passport::actingAs(User::factory()->viewAccessories()->create());

        $response = $this->getJson(route('api.low-stock.index'))
            ->assertOk();

        $rows = $response->json('rows');
        $names = collect($rows)->pluck('item.name')->all();

        $this->assertContains('Low Accessory', $names);
        $this->assertNotContains('Low Consumable', $names);
    }

    public function test_viewer_with_no_source_permissions_is_forbidden(): void
    {
        Passport::actingAs(User::factory()->create());

        $this->getJson(route('api.low-stock.index'))
            ->assertForbidden();
    }
}
