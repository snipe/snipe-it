<?php

namespace Tests\Feature\Users;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class TransferUserItemsPermissionScopingTest extends TestCase
{
    public function test_transfer_with_accessory_ids_requires_accessory_permissions(): void
    {
        $source = User::factory()->create();
        $target = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $checkout = AccessoryCheckout::create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
            'created_by' => User::factory()->create()->id,
        ]);

        $assetOnlyActor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        $this->actingAs($assetOnlyActor)
            ->post(route('users.transfer.store', $source), [
                'target_user_id' => $target->id,
                'accessory_checkout_ids' => [$checkout->id],
                'note' => 'test',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('accessories_checkout', [
            'id' => $checkout->id,
            'assigned_to' => $source->id,
        ]);
    }

    public function test_transfer_with_license_seat_ids_requires_license_permissions(): void
    {
        $source = User::factory()->create();
        $target = User::factory()->create();
        $license = License::factory()->create();
        $seat = LicenseSeat::factory()->for($license)->create([
            'assigned_to' => $source->id,
        ]);

        $assetOnlyActor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        $this->actingAs($assetOnlyActor)
            ->post(route('users.transfer.store', $source), [
                'target_user_id' => $target->id,
                'license_seat_ids' => [$seat->id],
                'note' => 'test',
            ])
            ->assertForbidden();

        $seat->refresh();
        $this->assertSame($source->id, $seat->assigned_to);
    }

    public function test_transfer_with_accessory_ids_succeeds_when_accessory_perms_granted(): void
    {
        $source = User::factory()->create();
        $target = User::factory()->create();
        $accessory = Accessory::factory()->create();
        $checkout = AccessoryCheckout::create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
            'created_by' => User::factory()->create()->id,
        ]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->checkinAccessories()
            ->checkoutAccessories()
            ->create();

        $this->actingAs($actor)
            ->post(route('users.transfer.store', $source), [
                'target_user_id' => $target->id,
                'accessory_checkout_ids' => [$checkout->id],
                'note' => 'test',
            ])
            ->assertRedirect(route('users.show', $target));

        $this->assertDatabaseHas('accessories_checkout', [
            'accessory_id' => $accessory->id,
            'assigned_to' => $target->id,
        ]);
    }

    public function test_asset_only_transfer_still_works_with_only_asset_perms(): void
    {
        $source = User::factory()->create();
        $target = User::factory()->create();
        $asset = \App\Models\Asset::factory()->create([
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
        ]);

        $assetOnlyActor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        $this->actingAs($assetOnlyActor)
            ->post(route('users.transfer.store', $source), [
                'target_user_id' => $target->id,
                'asset_ids' => [$asset->id],
                'note' => 'test',
            ])
            ->assertRedirect(route('users.show', $target));

        $asset->refresh();
        $this->assertSame($target->id, $asset->assigned_to);
    }
}
