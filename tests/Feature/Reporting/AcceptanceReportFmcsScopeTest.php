<?php

namespace Tests\Feature\Reporting;

use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the FMCS scope gap reported by Arpit Jain
 * (arpitjain099) on 2026-08-02. Both getAssetAcceptanceReport (the page)
 * and postAssetAcceptanceReport (the CSV export) ran
 * CheckoutAcceptance::pending() with no company scope. CheckoutAcceptance
 * has no company_id column and does not use CompanyableTrait /
 * CompanyableChildTrait, so it is not covered by the CompanyableScope
 * global scope. Companion read-side bug to GHSA-p5wx-p3vv-g6p2, which
 * fixed the same scope gap on the mutating actions.
 *
 * Both read paths now filter their result set through
 * currentUserCanAccessAcceptance(), matching the pattern the mutating
 * actions on the same page use.
 */
class AcceptanceReportFmcsScopeTest extends TestCase
{
    private function seedPendingAcceptanceOwnedBy(Company $company): array
    {
        $asset = Asset::factory()->create(['company_id' => $company->id, 'name' => 'Asset-'.$company->id]);
        $acceptance = CheckoutAcceptance::factory()->pending()->for($asset, 'checkoutable')->create();

        return [$asset, $acceptance];
    }

    public function test_page_render_hides_other_company_pending_acceptances_under_fmcs()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$assetA] = $this->seedPendingAcceptanceOwnedBy($companyA);
        [$assetB] = $this->seedPendingAcceptanceOwnedBy($companyB);

        $reporterA = User::factory()->canViewReports()->forCompany($companyA)->create();

        $response = $this->actingAs($reporterA)
            ->get(route('reports/unaccepted_assets'))
            ->assertOk();

        $this->assertStringContainsString($assetA->name, $response->getContent());
        $this->assertStringNotContainsString($assetB->name, $response->getContent());
    }

    public function test_csv_export_hides_other_company_pending_acceptances_under_fmcs()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$assetA] = $this->seedPendingAcceptanceOwnedBy($companyA);
        [$assetB] = $this->seedPendingAcceptanceOwnedBy($companyB);

        $reporterA = User::factory()->canViewReports()->forCompany($companyA)->create();

        $response = $this->actingAs($reporterA)
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk();

        $body = $response->getContent();
        $this->assertStringContainsString($assetA->name, $body);
        $this->assertStringNotContainsString($assetB->name, $body);
    }

    public function test_superuser_sees_all_company_pending_acceptances_in_page()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$assetA] = $this->seedPendingAcceptanceOwnedBy($companyA);
        [$assetB] = $this->seedPendingAcceptanceOwnedBy($companyB);

        $superuser = User::factory()->superuser()->forCompany($companyA)->create();

        $response = $this->actingAs($superuser)
            ->get(route('reports/unaccepted_assets'))
            ->assertOk();

        $this->assertStringContainsString($assetA->name, $response->getContent());
        $this->assertStringContainsString($assetB->name, $response->getContent());
    }

    public function test_superuser_sees_all_company_pending_acceptances_in_csv()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$assetA] = $this->seedPendingAcceptanceOwnedBy($companyA);
        [$assetB] = $this->seedPendingAcceptanceOwnedBy($companyB);

        $superuser = User::factory()->superuser()->forCompany($companyA)->create();

        $response = $this->actingAs($superuser)
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk();

        $body = $response->getContent();
        $this->assertStringContainsString($assetA->name, $body);
        $this->assertStringContainsString($assetB->name, $body);
    }

    public function test_fmcs_disabled_leaves_report_unscoped()
    {
        // With FMCS off the helper short-circuits and every row passes.
        // Guard against future refactors that accidentally add scoping on
        // installs that do not have FMCS enabled.
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        [$assetA] = $this->seedPendingAcceptanceOwnedBy($companyA);
        [$assetB] = $this->seedPendingAcceptanceOwnedBy($companyB);

        $reporterA = User::factory()->canViewReports()->forCompany($companyA)->create();

        $response = $this->actingAs($reporterA)
            ->get(route('reports/unaccepted_assets'))
            ->assertOk();

        $this->assertStringContainsString($assetA->name, $response->getContent());
        $this->assertStringContainsString($assetB->name, $response->getContent());
    }
}
