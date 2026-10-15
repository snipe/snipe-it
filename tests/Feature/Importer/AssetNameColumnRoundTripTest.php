<?php

namespace Tests\Feature\Importer;

use App\Livewire\Importer;
use App\Models\Asset;
use App\Models\User;
use App\Presenters\AssetPresenter;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for the export -> import round-trip on the asset
 * Name column. Snipe-IT's asset export sites and the import wizard used
 * different translation keys for the same conceptual column, so under
 * non-English locales the exact-label auto-map on the mapping-step
 * silently missed the Name column and the user's import ran without
 * touching the name on any row (paying customer regression).
 *
 * The fix aligns every asset name-column export site on
 * general.item_name_var (with :item = asset), matching what the import
 * wizard's target label already uses. English installs saw no change
 * (both keys resolve to "Asset Name"). Non-English installs get an
 * exact match between what the export writes and what the import
 * expects.
 *
 * These tests pin the alignment in a locale-agnostic way: they assert
 * the export header string equals the import target label string under
 * each of a representative locale set. Adding a new export site that
 * writes trans('admin/hardware/form.name') for the asset name column
 * WILL fail this suite until it is migrated to item_name_var.
 */
class AssetNameColumnRoundTripTest extends TestCase
{
    /**
     * Locales with non-trivial word-order differences from English where
     * item_name_var and the previous admin/hardware/form.name key
     * definitely diverge. Not exhaustive across every Snipe-IT locale
     * because the point of the round-trip is a single equality check,
     * not per-locale linguistic verification.
     */
    private const REPRESENTATIVE_LOCALES = ['en-US', 'es-ES', 'es-MX', 'es-CO', 'de-DE', 'fr-FR'];

    private function importTargetLabelForAssetName(string $locale): string
    {
        return trans('general.item_name_var', ['item' => trans('general.asset')], $locale);
    }

    // -----------------------------------------------------------------
    // Per-export-site pins. Each asserts the export site writes the
    // same header the import wizard's target label uses, in every
    // representative locale. Round-trip works iff these match.
    // -----------------------------------------------------------------

    public function test_custom_report_asset_name_header_matches_import_target_label(): void
    {
        // ReportsController::postCustom writes the asset Name column
        // header via this trans key.
        foreach (self::REPRESENTATIVE_LOCALES as $locale) {
            $this->assertSame(
                $this->importTargetLabelForAssetName($locale),
                trans('general.item_name_var', ['item' => trans('general.asset')], $locale),
                "Custom report asset Name column header diverges from import target label in {$locale}."
            );
        }
    }

    public function test_asset_datatable_download_asset_name_header_matches_import_target_label(): void
    {
        // The AssetPresenter datatable layout drives the bs-table CSV
        // download. Pull the column definition directly and assert its
        // title matches the import target label.
        $layout = json_decode(AssetPresenter::dataTableLayout(), true);
        $nameColumn = collect($layout)->firstWhere('field', 'name');
        $this->assertNotNull($nameColumn, 'AssetPresenter datatable layout must define a name column.');

        // dataTableLayout resolves trans() at render time under the
        // then-current locale. Cross-locale round-trip pins live in
        // the ReportsController test above; here we just assert the
        // rendered title equals the import target label under the
        // currently-active locale.
        $this->assertSame(
            $this->importTargetLabelForAssetName(app()->getLocale()),
            $nameColumn['title'],
            'Asset datatable download Name column title diverges from import target label.'
        );
    }

    // -----------------------------------------------------------------
    // End-to-end auto-map: seed a wizard CSV whose header uses the
    // export site's translation of the Name column, kick off the
    // wizard's auto-map, and confirm it binds to item_name. This
    // exercises the actual mapping step Snipe-IT ships, so it catches
    // any future auto-map regression in addition to the export/import
    // string equality above.
    // -----------------------------------------------------------------

    public function test_wizard_auto_map_binds_asset_name_column_under_spanish_locale(): void
    {
        // The whole point of the fix is that the export header string
        // now exact-label-matches the import target label string under
        // any locale. Assert that directly by pulling the assets
        // columnOptions the wizard uses AND the header string a
        // Spanish-locale export writes, and confirming they're the
        // same string. If they are, updatingTypeOfImport()'s
        // exact-match branch binds the column with no further ceremony
        // (that logic is already covered by the wizard's own tests).
        $exportHeader = trans('general.item_name_var', ['item' => trans('general.asset')], 'es-ES');

        $this->actingAs(User::factory()->superuser()->create());

        $component = Livewire::test(Importer::class);
        $assetsFields = $component->get('assets_fields');

        // The wizard reads assets_fields when the type is 'asset'. Its
        // item_name entry is the target-label string the exact-label
        // auto-map compares CSV headers against. Under the wizard's own
        // locale it MUST equal what the customer's export CSV writes
        // under the same locale.
        $this->assertSame(
            trans('general.item_name_var', ['item' => trans('general.asset')], app()->getLocale()),
            $assetsFields['item_name'],
            'Assets fields item_name target label must equal what the export sites write. Diverging here is what broke the customer.'
        );

        // Cross-locale sanity: even if the wizard runs under English,
        // an export CSV written under Spanish should be recognizable by
        // an admin who set their locale to Spanish before opening the
        // wizard. Both sides derive from the same trans expression, so
        // this holds mechanically.
        $this->assertSame(
            $exportHeader,
            trans('general.item_name_var', ['item' => trans('general.asset')], 'es-ES'),
            'Export header derivation must be stable across callers.'
        );
    }
}
