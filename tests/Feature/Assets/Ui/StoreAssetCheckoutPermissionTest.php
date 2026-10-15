<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\User;
use Tests\TestCase;

class StoreAssetCheckoutPermissionTest extends TestCase
{
    public function test_web_create_with_assigned_user_without_checkout_permission_creates_asset_and_flags_skipped_checkout(): void
    {
        $creator = User::factory()->createAssets()->create();
        $victim = User::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CHECKOUT-GATE-UI-U-'.uniqid();
        $this->actingAs($creator)
            ->post(route('hardware.store'), [
                'asset_tags' => [1 => $tag],
                'model_id' => $model->id,
                'status_id' => $status->id,
                'assigned_user' => $victim->id,
            ])
            ->assertRedirect()
            ->assertSessionHas('warning', trans('admin/hardware/message.create.checkout_skipped_no_permission'));

        $this->assertDatabaseHas('assets', [
            'asset_tag' => $tag,
            'assigned_to' => null,
        ]);
        $this->assertDatabaseMissing('action_logs', [
            'target_id' => $victim->id,
            'target_type' => User::class,
            'action_type' => 'checkout',
        ]);
    }

    public function test_web_create_without_assignment_does_not_flag_skipped_checkout(): void
    {
        $creator = User::factory()->createAssets()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CREATE-ONLY-UI-'.uniqid();
        $response = $this->actingAs($creator)
            ->post(route('hardware.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tags' => [1 => $tag],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('assets', ['asset_tag' => $tag]);
        $this->assertNotSame(
            trans('admin/hardware/message.create.checkout_skipped_no_permission'),
            session('warning')
        );
    }

    public function test_web_create_with_assignment_succeeds_when_checkout_permission_granted(): void
    {
        $creator = User::factory()->createAssets()->checkoutAssets()->create();
        $victim = User::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $tag = 'CHECKOUT-OK-UI-'.uniqid();
        $this->actingAs($creator)
            ->post(route('hardware.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'asset_tags' => [1 => $tag],
                'assigned_user' => $victim->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('assets', [
            'asset_tag' => $tag,
            'assigned_to' => $victim->id,
        ]);
    }
}
