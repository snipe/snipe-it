<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use Tests\TestCase;

class StoreAssetCheckoutPermissionTest extends TestCase
{
    public function test_create_with_assigned_user_without_checkout_permission_creates_asset_but_skips_checkout(): void
    {
        $creator = User::factory()->createAssets()->create();
        $victim = User::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CHECKOUT-GATE-U-'.uniqid();
        $response = $this->actingAsForApi($creator)
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tag' => $tag,
                'assigned_user' => $victim->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertMessagesAre(trans('admin/hardware/message.create.success_no_checkout'));

        // Asset persists.
        $this->assertDatabaseHas('assets', [
            'asset_tag' => $tag,
            'assigned_to' => null,
        ]);

        // No checkout event on the victim.
        $this->assertDatabaseMissing('action_logs', [
            'target_id' => $victim->id,
            'target_type' => User::class,
            'action_type' => 'checkout',
        ]);
    }

    public function test_create_with_assigned_asset_without_checkout_permission_creates_asset_but_skips_checkout(): void
    {
        $creator = User::factory()->createAssets()->create();
        $parentAsset = Asset::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CHECKOUT-GATE-A-'.uniqid();
        $this->actingAsForApi($creator)
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tag' => $tag,
                'assigned_asset' => $parentAsset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('assets', [
            'asset_tag' => $tag,
            'assigned_to' => null,
        ]);
    }

    public function test_create_with_assigned_location_without_checkout_permission_creates_asset_but_skips_checkout(): void
    {
        $creator = User::factory()->createAssets()->create();
        $location = Location::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CHECKOUT-GATE-L-'.uniqid();
        $this->actingAsForApi($creator)
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tag' => $tag,
                'assigned_location' => $location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('assets', [
            'asset_tag' => $tag,
            'assigned_to' => null,
        ]);
    }

    public function test_create_without_assignment_returns_default_success_message(): void
    {
        $creator = User::factory()->createAssets()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $this->actingAsForApi($creator)
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tag' => 'CREATE-ONLY',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertMessagesAre(trans('admin/hardware/message.create.success'));
    }

    public function test_create_with_assignment_succeeds_and_checks_out_when_checkout_permission_granted(): void
    {
        $creator = User::factory()->createAssets()->checkoutAssets()->create();
        $victim = User::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $this->actingAsForApi($creator)
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tag' => 'CHECKOUT-OK',
                'assigned_user' => $victim->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertMessagesAre(trans('admin/hardware/message.create.success'));

        $this->assertDatabaseHas('assets', [
            'asset_tag' => 'CHECKOUT-OK',
            'assigned_to' => $victim->id,
        ]);
    }
}
