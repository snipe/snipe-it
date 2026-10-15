<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CheckoutTargetPanel;
use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Regression tests for the item-class authorization gate on
 * CheckoutTargetPanel. The component previously authorized only the selected
 * target instance (user, asset, location), so a caller with a legitimate
 * signed snapshot and view permission on the target could receive items of
 * a class the caller otherwise could not view. Every variant now requires
 * the per-type view permission on top of the per-target view permission.
 */
class CheckoutTargetPanelAuthzTest extends TestCase
{
    #[Test]
    public function user_target_licenses_variant_hides_license_name_from_actor_without_licenses_view(): void
    {
        $target = User::factory()->create();
        $license = License::factory()->create(['name' => 'CAND05-LIVEWIRE-LICENSE-SECRET', 'reassignable' => 1]);
        LicenseSeat::factory()
            ->assignedToUser($target)
            ->create(['license_id' => $license->id]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'licenses'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertDontSee('CAND05-LIVEWIRE-LICENSE-SECRET');
    }

    #[Test]
    public function user_target_licenses_variant_shows_license_name_to_actor_with_licenses_view(): void
    {
        $target = User::factory()->create();
        $license = License::factory()->create(['name' => 'CAND05-LIVEWIRE-LICENSE-VISIBLE', 'reassignable' => 1]);
        LicenseSeat::factory()
            ->assignedToUser($target)
            ->create(['license_id' => $license->id]);

        $actor = User::factory()
            ->viewUsers()
            ->viewLicenses()
            ->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'licenses'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertSee('CAND05-LIVEWIRE-LICENSE-VISIBLE');
    }

    #[Test]
    public function user_target_accessories_variant_hides_accessory_name_from_actor_without_accessories_view(): void
    {
        $target = User::factory()->create();
        $accessory = Accessory::factory()->create(['name' => 'CAND05-LIVEWIRE-ACCESSORY-SECRET']);
        AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
        ]);

        $actor = User::factory()
            ->viewUsers()
            ->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'accessories'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertDontSee('CAND05-LIVEWIRE-ACCESSORY-SECRET');
    }

    #[Test]
    public function user_target_consumables_variant_hides_consumable_name_from_actor_without_consumables_view(): void
    {
        $target = User::factory()->create();
        $consumable = Consumable::factory()->create(['name' => 'CAND05-LIVEWIRE-CONSUMABLE-SECRET']);
        $target->consumables()->attach($consumable, [
            'created_by' => User::factory()->superuser()->create()->id,
        ]);

        $actor = User::factory()
            ->viewUsers()
            ->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'consumables'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertDontSee('CAND05-LIVEWIRE-CONSUMABLE-SECRET');
    }

    #[Test]
    public function user_target_assets_variant_hides_asset_tag_from_actor_without_assets_view(): void
    {
        $target = User::factory()->create();
        Asset::factory()->create([
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
            'asset_tag' => 'CAND05-LIVEWIRE-ASSET-SECRET',
        ]);

        // viewUsers alone, no asset view permission.
        $actor = User::factory()->viewUsers()->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertDontSee('CAND05-LIVEWIRE-ASSET-SECRET');
    }

    #[Test]
    public function asset_target_components_variant_hides_component_name_from_actor_without_components_view(): void
    {
        $target = Asset::factory()->create();
        $component = Component::factory()->create(['name' => 'CAND05-LIVEWIRE-COMPONENT-SECRET']);
        $target->components()->attach($component, [
            'assigned_qty' => 1,
            'created_by' => User::factory()->superuser()->create()->id,
        ]);

        $actor = User::factory()->viewAssets()->create();

        Livewire::actingAs($actor)
            ->test(CheckoutTargetPanel::class, ['type' => 'components'])
            ->dispatch('checkout-target-selected', targetType: 'asset', targetId: (string) $target->id)
            ->assertDontSee('CAND05-LIVEWIRE-COMPONENT-SECRET');
    }
}
