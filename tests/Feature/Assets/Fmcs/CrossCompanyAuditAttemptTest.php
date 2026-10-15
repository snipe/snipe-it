<?php

namespace Tests\Feature\Assets\Fmcs;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

/**
 * Verifies the FMCS enforcement on every asset-audit surface.
 *
 * A non-admin, non-superuser user with the `assets.audit` role
 * permission should never be able to audit an asset that belongs to
 * a company they can't see under FMCS, even if they know the asset's
 * id / tag and craft a request body directly. Covers:
 *
 *   - New UI bulk audit (POST /hardware/bulk-audit)
 *   - Legacy web single audit (POST /hardware/{id}/audit)
 *   - API single audit (POST /api/v1/hardware/{id}/audit and the
 *     legacy body-lookup variant that reads asset_tag from the body)
 *   - API bulk audit (POST /api/v1/hardware/audit/bulk)
 *
 * If any of these tests fail, the audit path in question is writing
 * an audit_log entry for an asset the actor doesn't have FMCS
 * visibility to and needs an explicit per-instance authorize() call.
 */
#[Group('auditing')]
#[Group('fmcs')]
class CrossCompanyAuditAttemptTest extends TestCase
{
    private Company $companyA;

    private Company $companyB;

    private User $auditor;

    private Asset $forbiddenAsset;

    protected function setUp(): void
    {
        parent::setUp();

        $this->settings->enableMultipleFullCompanySupport();

        [$this->companyA, $this->companyB] = Company::factory()->count(2)->create();

        $this->auditor = User::factory()
            ->auditAssets()
            ->viewAssets()
            ->forCompany($this->companyA)
            ->create();

        $this->forbiddenAsset = Asset::factory()->create([
            'company_id' => $this->companyB->id,
        ]);
    }

    public function test_ui_bulk_audit_does_not_audit_asset_in_forbidden_company(): void
    {
        $this->actingAs($this->auditor)
            ->post(route('hardware.bulk-audit.store'), [
                'selected_assets' => [$this->forbiddenAsset->id],
                'note' => 'cross-company probe',
            ]);

        $this->assertSame(
            0,
            Actionlog::where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->where('item_id', $this->forbiddenAsset->id)
                ->count(),
            'UI bulk audit must not write an audit log for a cross-company asset.',
        );
    }

    public function test_web_single_audit_store_does_not_write_audit_for_forbidden_asset(): void
    {
        // Assertion is on the side-effect (no audit log entry), not
        // the HTTP status code. Whichever layer catches the
        // cross-company attempt (route-model binding + scope, policy,
        // or model validation) is fine as long as no audit lands.
        $this->actingAs($this->auditor)
            ->post(route('asset.audit.store', $this->forbiddenAsset), [
                'note' => 'cross-company probe',
            ]);

        $this->assertSame(
            0,
            Actionlog::where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->where('item_id', $this->forbiddenAsset->id)
                ->count(),
            'Web single-audit POST must not write an audit log for a cross-company asset.',
        );
    }

    public function test_api_single_audit_does_not_write_audit_for_forbidden_asset(): void
    {
        $this->actingAsForApi($this->auditor)
            ->postJson(route('api.asset.audit', $this->forbiddenAsset), [
                'note' => 'cross-company probe',
            ]);

        $this->assertSame(
            0,
            Actionlog::where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->where('item_id', $this->forbiddenAsset->id)
                ->count(),
            'API single-audit POST must not write an audit log for a cross-company asset.',
        );
    }

    public function test_api_legacy_body_lookup_audit_does_not_resolve_forbidden_asset(): void
    {
        // The legacy body-lookup path in Api\AssetsController::audit()
        // reads asset_tag from the request body and calls
        // Asset::where('asset_tag', ...)->first(). CompanyableScope
        // must fire on that lookup so cross-company tags don't
        // resolve to an audit-writable Asset for a non-admin actor.
        $this->actingAsForApi($this->auditor)
            ->postJson(route('api.asset.audit.legacy'), [
                'asset_tag' => $this->forbiddenAsset->asset_tag,
                'note' => 'cross-company probe',
            ]);

        $this->assertSame(
            0,
            Actionlog::where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->where('item_id', $this->forbiddenAsset->id)
                ->count(),
            'API body-lookup audit must not resolve or audit a cross-company asset.',
        );
    }

    public function test_api_bulk_audit_does_not_audit_forbidden_asset(): void
    {
        $this->actingAsForApi($this->auditor)
            ->postJson(route('api.asset.bulk-audit'), [
                'ids' => [$this->forbiddenAsset->id],
                'note' => 'cross-company probe',
            ]);

        $this->assertSame(
            0,
            Actionlog::where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->where('item_id', $this->forbiddenAsset->id)
                ->count(),
            'API bulk audit must not write an audit log for a cross-company asset.',
        );
    }
}
