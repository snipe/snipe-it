<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

/**
 * Form / access surface of the checked-rows bulk-audit flow (Selected
 * Actions > Bulk Audit on the assets index). Route pair covered here:
 * `hardware.bulk-audit.show` and the dispatcher redirect on
 * `hardware.bulkedit.show`. Submission-side (POST /bulk-audit)
 * behavior lives in BulkAuditSelectedAssetsSubmissionTest to keep
 * either file under Codacy's per-class method-count threshold.
 *
 * Distinct from the existing BulkAuditAssetsTest which covers
 * /hardware/bulkaudit, the barcode-scanner quickscan workflow at
 * route `assets.bulkaudit`.
 */
#[Group('auditing')]
class BulkAuditSelectedAssetsTest extends TestCase
{
    public function test_permission_required_to_view_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('hardware.bulk-audit.show'))
            ->assertForbidden();
    }

    public function test_auditor_can_view_form(): void
    {
        $this->actingAs(User::factory()->auditAssets()->create())
            ->get(route('hardware.bulk-audit.show'))
            ->assertOk()
            ->assertViewIs('hardware.bulk-audit');
    }

    public function test_bulk_actions_dispatcher_redirects_to_show_with_selected_assets_flashed(): void
    {
        // BulkAssetsController::edit gates on view permission before
        // dispatching to any specific action, so the auditor also
        // needs view to reach the audit branch.
        $auditor = User::factory()->viewAssets()->auditAssets()->create();
        $assets = Asset::factory()->count(3)->create();

        $this->actingAs($auditor)
            ->post(route('hardware.bulkedit.show'), [
                'bulk_actions' => 'audit',
                'ids' => $assets->pluck('id')->toArray(),
            ])
            ->assertRedirect(route('hardware.bulk-audit.show'));
    }

    public function test_form_prefills_next_audit_date_from_audit_interval(): void
    {
        $this->settings->setAuditInterval(6);

        $this->actingAs(User::factory()->auditAssets()->create())
            ->get(route('hardware.bulk-audit.show'))
            ->assertOk()
            ->assertViewHas('next_audit_date', \Carbon\Carbon::now()->addMonths(6)->toDateString());
    }

    public function test_form_leaves_next_audit_date_blank_when_no_audit_interval_configured(): void
    {
        // With no audit_interval set, "today + 0 months" would prefill
        // as today, which reads as "audit again right now" and is
        // useless. The form should start empty and let the user pick
        // a date (or leave blank to skip updating next_audit_date).
        $this->settings->setAuditInterval(null);

        $this->actingAs(User::factory()->auditAssets()->create())
            ->get(route('hardware.bulk-audit.show'))
            ->assertOk()
            ->assertViewHas('next_audit_date', null);
    }

    public function test_location_controls_render_unscoped_when_location_scoping_is_off(): void
    {
        // FMCS location scoping disabled -> no company-based hiding
        // and no picker scoping regardless of selection distribution.
        $this->actingAs(User::factory()->auditAssets()->create())
            ->withSession(['_old_input' => ['selected_assets' => [1, 2, 3]]])
            ->get(route('hardware.bulk-audit.show'))
            ->assertOk()
            ->assertViewHas('hideLocationFields', false)
            ->assertViewHas('sharedCompanyId', null);
    }

    public function test_location_controls_scope_to_shared_company_when_selection_is_uniform(): void
    {
        // FMCS location scoping on + every selected asset in the same
        // company -> the picker is scoped so only that company's
        // locations are offered. Uses the real dispatch flow so
        // `old('selected_assets')` populates from the same session
        // mechanism prod uses. Create fixtures BEFORE enabling FMCS
        // so the Asset factory's fmcs_company validation rule doesn't
        // fail with no authenticated user during setUp.
        $company = Company::factory()->create();
        $assets = Asset::factory()->count(3)->create(['company_id' => $company->id]);
        $actor = User::factory()->viewAssets()->auditAssets()->forCompany($company)->create();

        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $response = $this->actingAs($actor)
            ->post(route('hardware.bulkedit.show'), [
                'bulk_actions' => 'audit',
                'ids' => $assets->pluck('id')->toArray(),
            ]);

        $this->followRedirects($response)
            ->assertOk()
            ->assertViewHas('hideLocationFields', false)
            ->assertViewHas('sharedCompanyId', $company->id);
    }

    public function test_location_controls_hide_when_selection_spans_multiple_companies(): void
    {
        // FMCS location scoping on + selected assets belong to more
        // than one company -> the picker is hidden entirely since no
        // shared location can legitimately fit all of them.
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $assetA = Asset::factory()->create(['company_id' => $companyA->id]);
        $assetB = Asset::factory()->create(['company_id' => $companyB->id]);
        $actor = User::factory()->superuser()->create();

        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $response = $this->actingAs($actor)
            ->post(route('hardware.bulkedit.show'), [
                'bulk_actions' => 'audit',
                'ids' => [$assetA->id, $assetB->id],
            ]);

        $this->followRedirects($response)
            ->assertOk()
            ->assertViewHas('hideLocationFields', true)
            ->assertViewHas('sharedCompanyId', null);
    }
}
