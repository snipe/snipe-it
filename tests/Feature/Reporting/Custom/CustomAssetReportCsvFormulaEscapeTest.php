<?php

namespace Tests\Feature\Reporting\Custom;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\User;
use League\Csv\Reader;
use Tests\TestCase;

/**
 * Regression coverage for the GHSA-r7wf-qq4r-q98w CSV formula
 * injection reported by zx (@manus-pi). postCustom() was appending
 * `$customfield->name` verbatim to the CSV header array and writing
 * that with `fputcsv($handle, $header)` unescaped, so a user with
 * the `customfields` permission could name a field with a leading
 * `=` / `+` / `-` / `@` and have it evaluated as a formula on a
 * `reports.view` operator's workstation when they open the CSV.
 * The data rows in the same handler DID run through EscapeFormula.
 *
 * Fix mirrors the data-row treatment on the header row, run
 * unconditionally rather than gated on `escape_formulas` because
 * header protection is not optional.
 */
class CustomAssetReportCsvFormulaEscapeTest extends TestCase
{
    private function fieldsetWithPoisonedCustomField(string $name): CustomField
    {
        $customField = CustomField::factory()->create(['name' => $name]);

        $fieldset = CustomFieldset::factory()->create();
        $fieldset->fields()->attach($customField, ['order' => 1, 'required' => false]);
        $model = AssetModel::factory()->create(['fieldset_id' => $fieldset->id]);

        Asset::factory()->for($model, 'model')->create(['name' => 'header-escape-test-asset']);

        return $customField;
    }

    public function test_custom_field_header_with_formula_prefix_is_escaped(): void
    {
        $poisoned = $this->fieldsetWithPoisonedCustomField('=cmd|\'/c calc.exe\'!A1');

        $response = $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                $poisoned->db_column_name() => '1',
            ])
            ->assertOk();

        $header = Reader::createFromString($response->streamedContent())->fetchOne(0);

        $this->assertNotContains($poisoned->name, $header, 'Unescaped attacker-controlled header cell leaked into the CSV.');
        $this->assertContains('`'.$poisoned->name, $header, 'Header cell must be prefixed with the EscapeFormula neutralizer.');
    }

    public function test_custom_field_header_with_plus_and_at_prefixes_are_escaped(): void
    {
        $plusField = $this->fieldsetWithPoisonedCustomField('+cmd|/c calc');
        $atField = $this->fieldsetWithPoisonedCustomField('@SUM(A1:A9)');

        $response = $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                $plusField->db_column_name() => '1',
                $atField->db_column_name() => '1',
            ])
            ->assertOk();

        $header = Reader::createFromString($response->streamedContent())->fetchOne(0);

        $this->assertContains('`+cmd|/c calc', $header, 'Plus-prefixed header must be neutralized.');
        $this->assertContains('`@SUM(A1:A9)', $header, 'At-prefixed header must be neutralized.');
    }

    public function test_header_escape_is_unconditional_even_when_data_row_escaping_is_disabled(): void
    {
        // Data rows respect config('app.escape_formulas'), but the
        // header is unconditional because a header cell derived from
        // a user-editable custom field name is always attacker-
        // controlled.
        config(['app.escape_formulas' => false]);

        $poisoned = $this->fieldsetWithPoisonedCustomField('=HYPERLINK("http://attacker.test","x")');

        $response = $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                $poisoned->db_column_name() => '1',
            ])
            ->assertOk();

        $header = Reader::createFromString($response->streamedContent())->fetchOne(0);

        $this->assertNotContains($poisoned->name, $header, 'Header cell must be neutralized even when data-row escaping is disabled.');
        $this->assertContains('`'.$poisoned->name, $header);
    }
}
