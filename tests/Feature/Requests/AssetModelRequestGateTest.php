<?php

namespace Tests\Feature\Requests;

use App\Models\Actionlog;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression for the AssetModel requestability bypass. Before the
 * fix, `POST /account/request/asset_model/{modelId}` skipped the
 * requestable-flag check that Asset and Accessory get on the same
 * endpoint. A normal user could hit that URL and create a request
 * record for a model whose admin had explicitly set
 * `requestable = 0`. Fix extends the gate at
 * ViewAssetsController::getRequestItem to also validate
 * AssetModel::Requestable().
 *
 * Also covers the adjacent hardening: the route parameter {itemType}
 * is now constrained to `asset|asset_model|accessory` at the route
 * level so arbitrary App\Models\* class names can no longer be
 * instantiated via user-controlled URL segments.
 */
class AssetModelRequestGateTest extends TestCase
{
    public function test_non_requestable_asset_model_cannot_be_requested_via_direct_post(): void
    {
        $user = User::factory()->create();
        $model = AssetModel::factory()->create(['requestable' => 0]);

        $response = $this->actingAs($user)
            ->post(route('account/request-item', ['itemType' => 'asset_model', 'itemId' => $model->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('error');

        // No request record should have been created.
        $this->assertDatabaseMissing('action_logs', [
            'item_id' => $model->id,
            'item_type' => AssetModel::class,
            'action_type' => 'requested',
        ]);
    }

    public function test_requestable_asset_model_can_still_be_requested(): void
    {
        // Non-regression: flipping the requestable flag ON must still
        // let the request go through.
        $user = User::factory()->create();
        $model = AssetModel::factory()->create(['requestable' => 1]);

        $response = $this->actingAs($user)
            ->post(route('account/request-item', ['itemType' => 'asset_model', 'itemId' => $model->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    public function test_arbitrary_item_type_is_rejected_by_route_constraint(): void
    {
        // Route now constrains {itemType} to asset|asset_model|accessory,
        // so arbitrary values like `user` no longer resolve to
        // App\Models\User via the studly_case concatenation inside
        // the controller. Anything else 404s at the router.
        $user = User::factory()->create();
        $victim = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/account/request/user/'.$victim->id);

        $response->assertNotFound();
    }

    public function test_ignored_item_types_do_not_reach_the_controller(): void
    {
        // Belt-and-suspenders check for a couple more shapes.
        // `component`, `consumable`, and `license` were removed from
        // this list as each became a first-class requestable (see the
        // matching ConsumableRequestTest / ComponentRequestTest /
        // LicenseRequestTest for the coverage that replaced their
        // slots here). `location` still route-rejects at the regex
        // level.
        $user = User::factory()->create();

        foreach (['location'] as $itemType) {
            $response = $this->actingAs($user)
                ->post('/account/request/'.$itemType.'/1');
            $response->assertNotFound();
        }

        // Make sure no stray Actionlog rows landed from the loop.
        $this->assertSame(0, Actionlog::where('action_type', 'requested')->count());
    }
}
