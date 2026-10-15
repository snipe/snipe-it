<?php

namespace Tests\Feature\Accessories\Api;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the JS-visible flag that drives the bulk-delete checkbox on the
 * accessories index. The bootstrap-table `checkboxEnabledFormatter` reads
 * `available_actions.bulk_selectable.delete` and disables the row's checkbox
 * when every entry there is false. An accessory that has any active checkout
 * must therefore report `bulk_selectable.delete === false`; a clean accessory
 * must report `true`.
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_accessory_is_bulk_selectable()
    {
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.accessories.show', $accessory))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', true);
    }

    public function test_checked_out_accessory_is_not_bulk_selectable()
    {
        $accessory = Accessory::factory()->create();
        AccessoryCheckout::factory()->create(['accessory_id' => $accessory->id]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.accessories.show', $accessory))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false);
    }
}
