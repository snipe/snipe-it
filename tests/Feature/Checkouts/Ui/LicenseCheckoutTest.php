<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseCheckoutTest extends TestCase
{
    public function testNotesAreStoredInActionLogOnCheckoutToAsset()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();
        $licenseSeat = LicenseSeat::factory()->create();

        $this->actingAs($admin)
            ->post("/licenses/{$licenseSeat->license->id}/checkout", [
                'checkout_to_type' => 'asset',
                'assigned_to' => null,
                'asset_id' => $asset->id,
                'notes' => 'oh hi there',
            ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $asset->id,
            'target_type' => Asset::class,
            'item_id' => $licenseSeat->license->id,
            'item_type' => License::class,
            'note' => 'oh hi there',
        ]);
    }

    public function testNotesAreStoredInActionLogOnCheckoutToUser()
    {
        $admin = User::factory()->superuser()->create();
        $licenseSeat = LicenseSeat::factory()->create();

        $this->actingAs($admin)
            ->post("/licenses/{$licenseSeat->license->id}/checkout", [
                'checkout_to_type' => 'user',
                'assigned_to' => $admin->id,
                'asset_id' => null,
                'notes' => 'oh hi there',
            ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $admin->id,
            'target_type' => User::class,
            'item_id' => $licenseSeat->license->id,
            'item_type' => License::class,
            'note' => 'oh hi there',
        ]);
    }
}
