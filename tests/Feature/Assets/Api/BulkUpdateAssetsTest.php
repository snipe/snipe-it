<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Statuslabel;
use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for PATCH /api/v1/hardware/bulk. `ids` in the request body names
 * which assets to touch; every other body field is the shared update payload
 * applied to each. Response is always the per-row envelope:
 * `{status, messages, results: [ {id, status, messages, payload} ]}`.
 *
 * Backward-compat coverage for the singular endpoint (PATCH /hardware/{asset},
 * legacy `{status, messages, payload}` shape) lives in UpdateAssetTest.
 */
class BulkUpdateAssetsTest extends TestCase
{
    private function bulkUrl(): string
    {
        return route('api.assets.bulk-update');
    }

    public function test_requires_permission()
    {
        $a = Asset::factory()->create();
        $b = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id],
                'name' => 'nope',
            ])
            ->assertForbidden();
    }

    public function test_updates_all_assets_and_returns_per_row_envelope()
    {
        [$a, $b, $c] = Asset::factory()->count(3)->create();
        $status = Statuslabel::factory()->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id, $c->id],
                'status_id' => $status->id,
                'notes' => 'bulk updated',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $results = $response->json('results');
        $this->assertCount(3, $results);

        foreach ([$a, $b, $c] as $original) {
            $fresh = $original->fresh();
            $this->assertEquals($status->id, $fresh->status_id, "status_id not applied to asset {$original->id}");
            $this->assertEquals('bulk updated', $fresh->notes, "notes not applied to asset {$original->id}");
        }

        $this->assertArrayHasKey('id', $results[0]);
        $this->assertArrayHasKey('status', $results[0]);
        $this->assertArrayHasKey('messages', $results[0]);
        $this->assertArrayHasKey('payload', $results[0]);
        $this->assertSame('success', $results[0]['status']);
        $this->assertNotNull($results[0]['payload']);
    }

    public function test_input_order_is_preserved_in_results()
    {
        [$a, $b, $c] = Asset::factory()->count(3)->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$c->id, $a->id, $b->id],
                'notes' => 'order check',
            ])
            ->assertOk();

        $ids = array_column($response->json('results'), 'id');
        $this->assertSame([$c->id, $a->id, $b->id], $ids);
    }

    public function test_nonexistent_id_is_reported_as_row_error()
    {
        $a = Asset::factory()->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, 999999],
                'notes' => 'partial',
            ])
            ->assertOk();

        $this->assertSame('partial', $response->json('status'));

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$a->id]['status']);
        $this->assertSame('error', $rows[999999]['status']);
        $this->assertNull($rows[999999]['payload']);
    }

    public function test_all_failures_produce_overall_error_status()
    {
        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [999998, 999999],
                'notes' => 'nothing exists',
            ])
            ->assertOk();

        $this->assertSame('error', $response->json('status'));
        $this->assertCount(2, $response->json('results'));

        foreach ($response->json('results') as $row) {
            $this->assertSame('error', $row['status']);
        }
    }

    public function test_duplicate_ids_are_only_processed_once()
    {
        $a = Asset::factory()->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $a->id, $a->id],
                'notes' => 'once please',
            ])
            ->assertOk();

        $this->assertCount(1, $response->json('results'));
        $this->assertSame($a->id, $response->json('results.0.id'));
    }

    public function test_invalid_field_fans_the_validation_error_out_to_every_row()
    {
        // A status_id that references a non-existent status_label fails
        // request-level validation before any row is attempted, so the
        // response can't distinguish which ids succeeded vs failed. The
        // failedValidation() hook on BulkUpdateAssetsRequest emits the
        // per-row envelope though, with the same error copied onto each id.
        [$a, $b] = Asset::factory()->count(2)->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id],
                'status_id' => 999999,
            ])
            ->assertJsonPath('status', 'error')
            ->assertJsonCount(2, 'results');

        $rows = collect($response->json('results'))->keyBy('id');
        foreach ([$a->id, $b->id] as $id) {
            $this->assertSame('error', $rows[$id]['status']);
            $this->assertArrayHasKey('status_id', $rows[$id]['messages']);
        }
    }

    public function test_missing_ids_field_is_a_request_level_validation_error()
    {
        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'notes' => 'no ids provided',
            ])
            ->assertJsonPath('status', 'error');

        // With no `ids`, there are no rows to fan errors onto — messages
        // carries the raw validator error bag.
        $this->assertArrayHasKey('ids', $response->json('messages'));
        $this->assertSame([], $response->json('results'));
    }

    public function test_custom_field_can_be_updated_across_assets_sharing_a_model()
    {
        // Regression: pre-fix, MayContainCustomFields on the bulk path set
        // $asset_model = null and flagged EVERY _snipeit_* field as not-on-model,
        // failing request-level validation. Fix: on bulk, skip the per-model
        // membership check and defer to per-row save behavior.
        $this->markIncompleteIfMySQL('Custom Field Tests do not work in MySQL');

        $customField = CustomField::factory()->create();
        [$a, $b] = Asset::factory()->hasMultipleCustomFields([$customField])->count(2)->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id],
                $customField->db_column_name() => 'bulk custom',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        foreach ([$a, $b] as $asset) {
            $this->assertSame('bulk custom', $asset->fresh()->{$customField->db_column_name()});
        }

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$a->id]['status']);
        $this->assertSame('success', $rows[$b->id]['status']);
    }

    public function test_custom_field_absent_from_some_models_is_silently_ignored_on_those_rows()
    {
        // Half the batch carries the field, half doesn't. Rows whose model
        // doesn't carry the field still succeed (their row is a no-op for
        // that field); rows whose model does carry it get the write.
        // Matches the per-row apply loop's "iterate the asset's own fieldset"
        // behavior — a field the model doesn't know is never touched.
        $this->markIncompleteIfMySQL('Custom Field Tests do not work in MySQL');

        $customField = CustomField::factory()->create();
        $withField = Asset::factory()->hasMultipleCustomFields([$customField])->create();
        $withoutField = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$withField->id, $withoutField->id],
                $customField->db_column_name() => 'partial write',
                'notes' => 'both should update notes',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertSame('partial write', $withField->fresh()->{$customField->db_column_name()});
        // Notes still applied on the row that didn't carry the custom field.
        $this->assertSame('both should update notes', $withoutField->fresh()->notes);
    }

    public function test_unknown_custom_field_column_is_still_a_request_level_validation_error()
    {
        // We drop the per-model membership check on bulk, but we still catch
        // truly nonexistent custom-field columns (typo protection). Every
        // targeted row gets the same error via the failedValidation reshape.
        $this->markIncompleteIfMySQL('Custom Field Tests do not work in MySQL');

        [$a, $b] = Asset::factory()->count(2)->create();

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id],
                '_snipeit_totally_bogus_9999' => 'nope',
            ])
            ->assertJsonPath('status', 'error');

        $rows = collect($response->json('results'))->keyBy('id');
        foreach ([$a->id, $b->id] as $id) {
            $this->assertSame('error', $rows[$id]['status']);
            $this->assertArrayHasKey('_snipeit_totally_bogus_9999', $rows[$id]['messages']);
        }
    }

    public function test_superuser_bypasses_fmcs_and_updates_assets_in_any_company()
    {
        // FMCS on, but a superuser is exempt from CompanyableScope — they can
        // see and update assets in every company. A bulk request touching
        // assets in two different companies should succeed on both rows.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $assetA = Asset::factory()->create(['company_id' => $companyA->id]);
        $assetB = Asset::factory()->create(['company_id' => $companyB->id]);

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson($this->bulkUrl(), [
                'ids' => [$assetA->id, $assetB->id],
                'notes' => 'superuser bulk touch',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$assetA->id]['status']);
        $this->assertSame('success', $rows[$assetB->id]['status']);

        $this->assertSame('superuser bulk touch', $assetA->fresh()->notes);
        $this->assertSame('superuser bulk touch', $assetB->fresh()->notes);
    }

    public function test_respects_fmcs_scoping_for_non_superuser()
    {
        // Caller scoped to company A asking to update assets [A-owned, B-owned]
        // should see the B-owned row surface as `does_not_exist` — the query-level
        // CompanyableScope hides it from `Asset::whereIn(...)`, so the row falls
        // into the "no such asset" branch. The A-owned row goes through as normal.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $userA = User::factory()->editAssets()->forCompany($companyA->id)->create();
        $assetA = Asset::factory()->create(['company_id' => $companyA->id, 'created_by' => $userA->id]);
        $assetB = Asset::factory()->create(['company_id' => $companyB->id]);

        $response = $this->actingAsForApi($userA)
            ->patchJson($this->bulkUrl(), [
                'ids' => [$assetA->id, $assetB->id],
                'notes' => 'fmcs check',
            ])
            ->assertOk();

        $this->assertSame('partial', $response->json('status'));

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$assetA->id]['status']);
        $this->assertSame('error', $rows[$assetB->id]['status']);

        $this->assertSame('fmcs check', $assetA->fresh()->notes);
        $this->assertNotSame('fmcs check', $assetB->fresh()->notes);
    }
}
