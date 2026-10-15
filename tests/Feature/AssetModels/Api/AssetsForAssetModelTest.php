<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * Covers GET /api/v1/models/{id}/assets. The route was reintroduced
 * after landing inside a `models/` prefix group had accidentally
 * dropped the {id} path segment, which routed calls to the id-less
 * `models/assets` at the assets() controller method and blew up with
 * ArgumentCountError because the method requires the id.
 */
class AssetsForAssetModelTest extends TestCase
{
    public function test_viewing_assets_for_asset_model_requires_authentication()
    {
        $model = AssetModel::factory()->create();

        $this->getJson(route('api.models.assets', ['id' => $model->id]))
            ->assertUnauthorized();
    }

    public function test_viewing_assets_for_asset_model_requires_permission()
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.models.assets', ['id' => $model->id]))
            ->assertForbidden();
    }

    public function test_models_view_without_assets_view_cannot_read_the_assets_for_a_model()
    {
        // Regression test: pre-fix, the endpoint only authorized
        // view on AssetModel. A role holding models.view but not
        // assets.view therefore read full asset rows (serials, notes,
        // assignment, purchase, audit) through AssetsTransformer. The
        // canonical GET /api/v1/hardware correctly 403s the same role.
        $model = AssetModel::factory()->create();
        Asset::factory()->create([
            'model_id' => $model->id,
            'serial' => 'LEAK-SERIAL-ABC123',
            'notes' => 'LEAK-NOTES-sensitive',
        ]);

        $modelsViewer = User::factory()->viewAssetModels()->create();

        $this->actingAsForApi($modelsViewer)
            ->getJson(route('api.models.assets', ['id' => $model->id]))
            ->assertForbidden();
    }

    public function test_models_view_combined_with_assets_view_still_reaches_the_endpoint()
    {
        // Happy-path companion: fixing the authorization gap must not
        // over-restrict the roles that legitimately combine both
        // permissions.
        $model = AssetModel::factory()->create();
        Asset::factory()->count(2)->create(['model_id' => $model->id]);

        $viewer = User::factory()->viewAssetModels()->viewAssets()->create();

        $this->actingAsForApi($viewer)
            ->getJson(route('api.models.assets', ['id' => $model->id]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('total', 2)
                ->has('rows', 2)
                ->etc());
    }

    public function test_error_returned_if_asset_model_does_not_exist()
    {
        // Snipe-IT's exception handler returns 200 + status "error" for
        // ModelNotFoundException on API requests, matching what the
        // sibling AssetModel endpoints already do (see
        // RestoreAssetModelTest::test_error_returned_if_asset_model_does_not_exist).
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => 999999]))
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function test_returns_only_assets_belonging_to_the_named_model()
    {
        $targetModel = AssetModel::factory()->create();
        $otherModel = AssetModel::factory()->create();

        $targetAssets = Asset::factory()->count(3)->create(['model_id' => $targetModel->id]);
        Asset::factory()->count(2)->create(['model_id' => $otherModel->id]);

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => $targetModel->id]))
            ->assertOk()
            ->assertJsonStructure(['total', 'rows'])
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('total', 3)
                ->has('rows', 3)
                ->etc());

        $returnedIds = collect($response->json('rows'))->pluck('id')->sort()->values()->all();
        $expectedIds = $targetAssets->pluck('id')->sort()->values()->all();
        $this->assertSame($expectedIds, $returnedIds);
    }

    public function test_returns_empty_list_when_model_has_no_assets()
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => $model->id]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('total', 0)
                ->has('rows', 0)
                ->etc());
    }

    public function test_limit_query_parameter_bounds_the_returned_rows()
    {
        $model = AssetModel::factory()->create();
        Asset::factory()->count(5)->create(['model_id' => $model->id]);

        // total should reflect the full matching set. rows should
        // reflect the requested page size. Pagination is what makes
        // this endpoint safe against models with thousands of assets.
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => $model->id, 'limit' => 2]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('total', 5)
                ->has('rows', 2)
                ->etc());
    }

    public function test_offset_query_parameter_skips_earlier_rows()
    {
        $model = AssetModel::factory()->create();
        Asset::factory()->count(5)->create(['model_id' => $model->id]);

        $firstPage = $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => $model->id, 'limit' => 2, 'offset' => 0]))
            ->assertOk()
            ->json('rows');

        $secondPage = $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.assets', ['id' => $model->id, 'limit' => 2, 'offset' => 2]))
            ->assertOk()
            ->json('rows');

        $this->assertCount(2, $firstPage);
        $this->assertCount(2, $secondPage);
        $firstPageIds = collect($firstPage)->pluck('id')->all();
        $secondPageIds = collect($secondPage)->pluck('id')->all();
        $this->assertEmpty(array_intersect($firstPageIds, $secondPageIds), 'Offset pagination must not overlap between pages.');
    }
}
