<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

/**
 * Coverage for POST /api/v1/hardware/audit/bulk. `ids` in the request body
 * names which assets to audit; other body fields (note, next_audit_date,
 * update_location, image, ...) apply to every one of them. Response is
 * always the per-row envelope.
 *
 * Backward-compat coverage for the singular endpoint (POST
 * /hardware/{asset}/audit) and the legacy body-based route (POST
 * /hardware/audit) lives in AuditAssetTest.
 */
#[Group('auditing')]
class BulkAuditAssetsTest extends TestCase
{
    private function bulkUrl(): string
    {
        return route('api.asset.bulk-audit');
    }

    public function test_audits_all_assets_and_returns_per_row_envelope()
    {
        [$a, $b, $c] = Asset::factory()->count(3)->create();
        $future = now()->addMonths(4)->toDateString();

        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [$a->id, $b->id, $c->id],
                'next_audit_date' => $future,
                'note' => 'bulk audit',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $results = $response->json('results');
        $this->assertCount(3, $results);

        foreach ([$a, $b, $c] as $original) {
            $fresh = $original->fresh();
            $this->assertEquals($future, $fresh->next_audit_date, "next_audit_date not applied to asset {$original->id}");
            $this->assertNotNull($fresh->last_audit_date, "last_audit_date not stamped on asset {$original->id}");
        }

        $this->assertArrayHasKey('id', $results[0]);
        $this->assertArrayHasKey('status', $results[0]);
        $this->assertArrayHasKey('messages', $results[0]);
        $this->assertArrayHasKey('payload', $results[0]);
        $this->assertSame('success', $results[0]['status']);
        // asset_tag is HTML-escaped through e() in the payload; compare as strings.
        $this->assertSame((string) $a->asset_tag, (string) $results[0]['payload']['asset_tag']);
    }

    public function test_input_order_is_preserved_in_results()
    {
        [$a, $b, $c] = Asset::factory()->count(3)->create();

        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [$c->id, $a->id, $b->id],
                'note' => 'order check',
            ])
            ->assertOk();

        $ids = array_column($response->json('results'), 'id');
        $this->assertSame([$c->id, $a->id, $b->id], $ids);
    }

    public function test_nonexistent_id_is_reported_as_row_error()
    {
        $a = Asset::factory()->create();

        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [$a->id, 999999],
                'note' => 'partial',
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
        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [999998, 999999],
                'note' => 'nothing exists',
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

        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [$a->id, $a->id, $a->id],
                'note' => 'once please',
            ])
            ->assertOk();

        $this->assertCount(1, $response->json('results'));
        $this->assertSame($a->id, $response->json('results.0.id'));
    }

    public function test_missing_ids_field_is_a_request_level_validation_error()
    {
        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->postJson($this->bulkUrl(), [
                'note' => 'no ids provided',
            ])
            ->assertJsonPath('status', 'error');

        $this->assertArrayHasKey('ids', $response->json('messages'));
        $this->assertSame([], $response->json('results'));
    }

    public function test_attaches_uploaded_image_to_every_row_audit_log()
    {
        // A single `image` on a bulk audit should be stored once per asset
        // and each asset's audit log entry should reference its own copy —
        // mirroring the web audit form which associates the uploaded image
        // with the individual audit.
        Storage::fake();

        [$a, $b] = Asset::factory()->count(2)->create();

        $response = $this->actingAsForApi(User::factory()->auditAssets()->create())
            ->post($this->bulkUrl(), [
                'ids' => [$a->id, $b->id],
                'note' => 'batch w/ photo',
                'file' => [UploadedFile::fake()->image('audit.jpg')],
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $rows = collect($response->json('results'))->keyBy('id');
        foreach ([$a, $b] as $asset) {
            $filename = $rows[$asset->id]['payload']['image'] ?? null;
            $this->assertNotNull($filename, "no image filename for asset {$asset->id}");
            $this->assertStringStartsWith('audit-'.$asset->id.'-', $filename);
            Storage::assertExists('private_uploads/audits/'.$filename);

            $log = Actionlog::where('item_id', $asset->id)->where('action_type', 'audit')->first();
            $this->assertSame($filename, $log->filename);
        }
    }

    public function test_superuser_bypasses_fmcs_and_audits_assets_in_any_company()
    {
        // FMCS on, but a superuser is exempt from CompanyableScope — they can
        // see and audit assets in every company. A bulk request touching
        // assets in two different companies should succeed on both rows.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $assetA = Asset::factory()->create(['company_id' => $companyA->id]);
        $assetB = Asset::factory()->create(['company_id' => $companyB->id]);

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson($this->bulkUrl(), [
                'ids' => [$assetA->id, $assetB->id],
                'note' => 'superuser bulk audit',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$assetA->id]['status']);
        $this->assertSame('success', $rows[$assetB->id]['status']);

        $this->assertNotNull($assetA->fresh()->last_audit_date);
        $this->assertNotNull($assetB->fresh()->last_audit_date);
    }

    public function test_respects_fmcs_scoping_for_non_superuser()
    {
        // FMCS on, caller in company A tries to audit both an A-owned asset
        // and a B-owned asset. B is hidden by the CompanyableScope on the
        // Asset::whereIn(...) fetch, so it reports as `does_not_exist` in
        // the per-row envelope. Then the per-row Gate::allows('audit', $asset)
        // check inside bulkAudit() acts as belt-and-braces if a future scope
        // change lets the query see it — the row would surface as
        // `unauthorized` instead.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $userA = User::factory()->auditAssets()->forCompany($companyA->id)->create();
        $assetA = Asset::factory()->create(['company_id' => $companyA->id, 'created_by' => $userA->id]);
        $assetB = Asset::factory()->create(['company_id' => $companyB->id]);

        $response = $this->actingAsForApi($userA)
            ->postJson($this->bulkUrl(), [
                'ids' => [$assetA->id, $assetB->id],
                'note' => 'fmcs check',
            ])
            ->assertOk();

        $this->assertSame('partial', $response->json('status'));

        $rows = collect($response->json('results'))->keyBy('id');
        $this->assertSame('success', $rows[$assetA->id]['status']);
        $this->assertSame('error', $rows[$assetB->id]['status']);

        $this->assertNotNull($assetA->fresh()->last_audit_date);
        $this->assertNull($assetB->fresh()->last_audit_date);
    }
}
