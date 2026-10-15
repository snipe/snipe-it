<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CheckoutTargetPanel;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutTargetPanelTest extends TestCase
{
    public function test_mount_rejects_unknown_type(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        // Laravel wraps our InvalidArgumentException in ViewException at the
        // point mount() is invoked during blade rendering — match the raw
        // message rather than the outer wrapper class so the assertion stays
        // valid if the wrapping ever changes.
        $this->expectExceptionMessage('Unknown checkout-target-panel type: widgets');

        Livewire::test(CheckoutTargetPanel::class, ['type' => 'widgets']);
    }

    public function test_mount_rejects_unknown_target_type_dispatch(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'sinister', targetId: '1')
            ->assertSet('targetType', null)
            ->assertSet('targetId', 1);
    }

    public function test_type_prop_is_locked_against_client_mutation(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        // Livewire's #[Locked] attribute throws CannotUpdateLockedPropertyException
        // from the test client itself when the caller tries to mutate the
        // property — the exception surfaces directly in the test process,
        // not as a rendered 500 response.
        $this->expectException(\Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException::class);

        Livewire::test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->set('type', 'licenses');
    }

    public function test_initial_render_shows_empty_message_with_no_target(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->assertSet('targetType', null)
            ->assertSet('targetId', null)
            ->assertSee(trans('admin/users/message.nothing_currently_assigned'));
    }

    public function test_user_target_lists_user_assets(): void
    {
        $admin = User::factory()->superuser()->create();
        $target = User::factory()->create();
        $asset = Asset::factory()->create([
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
            'asset_tag' => 'PANEL-TEST-USER-ASSETS',
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertSet('targetType', 'user')
            ->assertSet('targetId', $target->id)
            ->assertSee($asset->asset_tag);
    }

    public function test_asset_target_lists_child_assets(): void
    {
        $admin = User::factory()->superuser()->create();
        $parent = Asset::factory()->create();
        $child = Asset::factory()->create([
            'assigned_to' => $parent->id,
            'assigned_type' => Asset::class,
            'asset_tag' => 'PANEL-TEST-CHILD-ASSET',
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'asset', targetId: (string) $parent->id)
            ->assertSee($child->asset_tag);
    }

    public function test_location_target_lists_assets_checked_out_to_that_location(): void
    {
        $admin = User::factory()->superuser()->create();
        $location = Location::factory()->create();
        // "Checked out to a location" = polymorphic assigned_to / assigned_type
        // pair. We deliberately do NOT set location_id here so this asserts
        // the panel is using Location::assignedAssets (checkout target),
        // not Location::assets (physical/default location).
        $asset = Asset::factory()->create([
            'assigned_to' => $location->id,
            'assigned_type' => Location::class,
            'asset_tag' => 'PANEL-TEST-LOCATION-ASSET',
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'location', targetId: (string) $location->id)
            ->assertSee($asset->asset_tag);
    }

    public function test_location_target_does_not_list_assets_merely_assigned_to_that_location_id(): void
    {
        // Regression: earlier version used Location::assets() (location_id-
        // based) which pulls in assets that just happen to have this as their
        // physical/default location but were never CHECKED OUT to it. That's
        // wrong for a "current checkouts" sidebar.
        $admin = User::factory()->superuser()->create();
        $location = Location::factory()->create();
        Asset::factory()->create([
            'location_id' => $location->id,
            // no assigned_to / assigned_type — asset is at this location
            // physically but not checked out to it.
            'asset_tag' => 'PANEL-TEST-PHYSICAL-ONLY',
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'location', targetId: (string) $location->id)
            ->assertDontSee('PANEL-TEST-PHYSICAL-ONLY');
    }

    public function test_impossible_combo_consumables_to_asset_returns_empty(): void
    {
        // Consumables can only be checked out to users; picking an asset target
        // on the consumables panel must not accidentally return the asset's
        // accessories or something equally wrong.
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'consumables'])
            ->dispatch('checkout-target-selected', targetType: 'asset', targetId: (string) $asset->id)
            ->assertSee(trans('admin/users/message.nothing_currently_assigned'));
    }

    public function test_impossible_combo_licenses_to_location_returns_empty(): void
    {
        $admin = User::factory()->superuser()->create();
        $location = Location::factory()->create();

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'licenses'])
            ->dispatch('checkout-target-selected', targetType: 'location', targetId: (string) $location->id)
            ->assertSee(trans('admin/users/message.nothing_currently_assigned'));
    }

    public function test_authorization_gate_hides_target_items_from_unauthorized_viewer(): void
    {
        // Someone who can reach a checkout page for an item they're permitted
        // to see, but a target user they aren't (FMCS cross-company etc.),
        // must not have that target's other checkouts leaked through the
        // sidebar. Simulate by acting as a plain user without view-users.
        $viewer = User::factory()->create();
        $target = User::factory()->create();
        Asset::factory()->create([
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
            'asset_tag' => 'PANEL-TEST-SHOULD-NOT-SHOW',
        ]);

        Livewire::actingAs($viewer)
            ->test(CheckoutTargetPanel::class, ['type' => 'assets'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertDontSee('PANEL-TEST-SHOULD-NOT-SHOW')
            ->assertSee(trans('admin/users/message.nothing_currently_assigned'));
    }

    public function test_user_target_lists_user_accessories(): void
    {
        $admin = User::factory()->superuser()->create();
        $target = User::factory()->create();
        $accessory = Accessory::factory()->create(['name' => 'PANEL_ACCESSORY_TEST']);
        $target->accessories()->attach($accessory->id, [
            'assigned_type' => User::class,
            'created_at' => now(),
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'accessories'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertSee('PANEL_ACCESSORY_TEST');
    }

    public function test_user_target_lists_user_licenses(): void
    {
        $admin = User::factory()->superuser()->create();
        $target = User::factory()->create();
        $seat = LicenseSeat::factory()->create(['assigned_to' => $target->id]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'licenses'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertSee($seat->license->name);
    }

    public function test_asset_target_lists_target_components(): void
    {
        $admin = User::factory()->superuser()->create();
        $target = Asset::factory()->create();
        $component = Component::factory()->create(['name' => 'PANEL_COMPONENT_TEST']);
        $target->components()->attach($component->id, [
            'assigned_qty' => 2,
            'created_by' => $admin->id,
            'created_at' => now(),
        ]);

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'components'])
            ->dispatch('checkout-target-selected', targetType: 'asset', targetId: (string) $target->id)
            ->assertSee('PANEL_COMPONENT_TEST');
    }

    public function test_impossible_combo_components_to_user_returns_empty(): void
    {
        // Components can only be checked out to assets; picking a user target
        // on the components panel must fall through to the empty state rather
        // than surfacing anything the user happens to have.
        $admin = User::factory()->superuser()->create();
        $target = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(CheckoutTargetPanel::class, ['type' => 'components'])
            ->dispatch('checkout-target-selected', targetType: 'user', targetId: (string) $target->id)
            ->assertSee(trans('admin/users/message.nothing_currently_assigned'));
    }

    public function test_mount_rejects_unknown_default_target_type(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        $this->expectExceptionMessage('Unknown checkout-target-panel defaultTargetType: martian');

        Livewire::test(CheckoutTargetPanel::class, [
            'type' => 'components',
            'defaultTargetType' => 'martian',
        ]);
    }

    public function test_default_target_type_prop_is_locked_against_client_mutation(): void
    {
        $this->actingAs(User::factory()->superuser()->create());

        $this->expectException(\Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException::class);

        Livewire::test(CheckoutTargetPanel::class, [
            'type' => 'components',
            'defaultTargetType' => 'asset',
        ])->set('defaultTargetType', 'user');
    }
}
