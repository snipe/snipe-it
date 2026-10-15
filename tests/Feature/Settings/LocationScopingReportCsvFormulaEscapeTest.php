<?php

namespace Tests\Feature\Settings;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the CSV formula injection reported by Arpit Jain
 * (arpitjain099) on 2026-08-01. downloadLocationScopingReport streamed every
 * row through fputcsv without formula escaping, so a low-privilege user who
 * could edit any of the free-text name fields (asset, location, company)
 * that appear in the mismatch report could plant a spreadsheet formula that
 * executes when a superuser opens the downloaded CSV in Excel /
 * LibreOffice / Google Sheets. The controller now uses League\Csv's
 * EscapeFormula with the same backtick prefix that ReportsController uses,
 * gated on the app.escape_formulas setting (default true).
 */
class LocationScopingReportCsvFormulaEscapeTest extends TestCase
{
    private function seedMismatchWithNamed(string $assetName, string $companyName, string $locationName): Asset
    {
        $itemCompany = Company::factory()->create(['name' => $companyName]);
        $locationCompany = Company::factory()->create();
        $location = Location::factory()->for($locationCompany)->create(['name' => $locationName]);

        return Asset::factory()->create([
            'name' => $assetName,
            'company_id' => $itemCompany->id,
            'location_id' => $location->id,
            'rtd_location_id' => $location->id,
        ]);
    }

    public function test_data_rows_with_formula_prefix_are_escaped_by_default()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $this->seedMismatchWithNamed(
            assetName: '=HYPERLINK("http://attacker.test","click")',
            companyName: '+cmd|/c calc',
            locationName: '@sum(A1:A9)',
        );

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.general.location_scoping_report'))
            ->assertOk()
            ->streamedContent();

        $this->assertStringNotContainsString('=HYPERLINK("http://attacker.test","click")', $body);
        $this->assertStringNotContainsString(',+cmd|/c calc,', $body);
        $this->assertStringNotContainsString(',@sum(A1:A9),', $body);
        $this->assertStringContainsString('`=HYPERLINK', $body);
        $this->assertStringContainsString('`+cmd|', $body);
        $this->assertStringContainsString('`@sum(', $body);
    }

    public function test_data_rows_are_not_escaped_when_setting_disabled()
    {
        // Mirrors the escape_formulas=false branch in ReportsController.
        // Users who intentionally disable the setting expect raw output.
        config(['app.escape_formulas' => false]);

        $this->settings->enableMultipleFullCompanySupport();

        $this->seedMismatchWithNamed(
            assetName: '=SUM(A1:A9)',
            companyName: 'Acme',
            locationName: 'HQ',
        );

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.general.location_scoping_report'))
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString('=SUM(A1:A9)', $body);
        $this->assertStringNotContainsString('`=SUM(A1:A9)', $body);
    }

    public function test_header_row_is_emitted_unescaped()
    {
        // Header cells are hardcoded strings, not user-controlled, so we
        // intentionally do not run them through EscapeFormula (matches the
        // pattern in ReportsController's exports). Assert the header lands
        // as plain text so the exported file remains parseable as CSV with
        // the labels users expect.
        $this->settings->enableMultipleFullCompanySupport();

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.general.location_scoping_report'))
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString('Type,ID,Name', $body);
    }
}
