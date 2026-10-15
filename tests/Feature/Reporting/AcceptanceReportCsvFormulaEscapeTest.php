<?php

namespace Tests\Feature\Reporting;

use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the CSV formula injection reported by Arpit Jain
 * (arpitjain099) on 2026-08-02. postAssetAcceptanceReport built its CSV
 * by hand and str_replace(',', '', ...) each cell before joining with
 * implode(','). Stripping commas kept the manual join from breaking but
 * did nothing about formulas. Every other CSV export in
 * ReportsController used League\Csv\EscapeFormula gated on
 * config('app.escape_formulas'); this one did not.
 *
 * The fix adds the same EscapeFormula pass in the loop with the same
 * gating, so a low-privilege user who plants a formula in one of the
 * asset / company / user free-text fields no longer sees the payload
 * execute when a reports.view user opens the CSV in Excel / LibreOffice
 * / Google Sheets.
 */
class AcceptanceReportCsvFormulaEscapeTest extends TestCase
{
    private function seedPendingAcceptanceWithAssetNamed(string $assetName): CheckoutAcceptance
    {
        // Company + asset are wired so the resulting row surfaces the
        // poisoned name in the report's Name column.
        $company = Company::factory()->create();
        $asset = Asset::factory()->create(['name' => $assetName, 'company_id' => $company->id]);

        return CheckoutAcceptance::factory()->pending()->for($asset, 'checkoutable')->create();
    }

    public function test_data_rows_with_formula_prefix_are_escaped_by_default()
    {
        $this->seedPendingAcceptanceWithAssetNamed('=HYPERLINK("http://attacker.test","click")');

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString('=HYPERLINK("http://attacker.test","click")', $body);
        $this->assertStringContainsString('`=HYPERLINK', $body);
    }

    public function test_data_rows_with_plus_and_at_prefixes_are_escaped()
    {
        $this->seedPendingAcceptanceWithAssetNamed('+cmd|/c calc');
        $this->seedPendingAcceptanceWithAssetNamed('@SUM(A1:A9)');

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('`+cmd|', $body);
        $this->assertStringContainsString('`@SUM(', $body);
    }

    public function test_data_rows_are_not_escaped_when_setting_disabled()
    {
        // Matches how the sibling exports in ReportsController behave when
        // operators intentionally disable escaping.
        config(['app.escape_formulas' => false]);

        $this->seedPendingAcceptanceWithAssetNamed('=SUM(A1:A9)');

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('=SUM(A1:A9)', $body);
        $this->assertStringNotContainsString('`=SUM(A1:A9)', $body);
    }

    public function test_embedded_newline_in_cell_does_not_break_out_into_a_new_record()
    {
        // Reported by doanmanhducz as a bypass of the prior fix. Naming an
        // asset "ordinary label\n=1+1" passed the EscapeFormula check (cell
        // begins with 'o', not a formula prefix) and the manual
        // implode("\n", $rows) join then split the cell in half, dropping
        // "=1+1" onto its own line as the first field of a new record.
        $this->seedPendingAcceptanceWithAssetNamed("ordinary label\n=1+1");

        $body = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('reports/export/unaccepted_assets'))
            ->assertOk()
            ->getContent();

        // Parse the response with fgetcsv (respects RFC 4180 quoting) and
        // walk every record. No first cell may be an unescaped formula.
        $handle = fopen('php://memory', 'r+');
        fwrite($handle, $body);
        rewind($handle);

        while (($record = fgetcsv($handle)) !== false) {
            $this->assertNotSame('=1+1', $record[0] ?? null, 'Formula leaked into a new record via embedded newline');
        }
        fclose($handle);
    }
}
