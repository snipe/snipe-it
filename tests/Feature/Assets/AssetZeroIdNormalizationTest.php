<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * location_id and company_id should never surface as `0` at the model
 * boundary. Old data and previous bugs occasionally stored `0` where
 * NULL was intended (empty select2 → '' → integer-cast → 0). Reads on
 * those rows would then break `exists:` validation, FMCS company
 * scoping, and any code that checks `$asset->company_id === null`.
 *
 * The mutator normalizes on write (Asset::setLocationIdAttribute /
 * setCompanyIdAttribute) and the accessor normalizes on read for
 * legacy rows already storing 0.
 */
class AssetZeroIdNormalizationTest extends TestCase
{
    public function test_setting_location_id_to_zero_normalizes_to_null(): void
    {
        $asset = Asset::factory()->create();

        $asset->location_id = 0;
        $this->assertNull($asset->location_id);

        $asset->location_id = '0';
        $this->assertNull($asset->location_id);

        $asset->location_id = '';
        $this->assertNull($asset->location_id);
    }

    public function test_setting_company_id_to_zero_normalizes_to_null(): void
    {
        $asset = Asset::factory()->create();

        $asset->company_id = 0;
        $this->assertNull($asset->company_id);

        $asset->company_id = '0';
        $this->assertNull($asset->company_id);

        $asset->company_id = '';
        $this->assertNull($asset->company_id);
    }

    public function test_legacy_zero_stored_in_db_reads_as_null(): void
    {
        // Simulate a row from the pre-mutator era where 0 slipped in.
        // DB::update bypasses model events so we can write the invalid
        // value directly.
        $asset = Asset::factory()->create();
        DB::table('assets')->where('id', $asset->id)->update([
            'location_id' => 0,
            'company_id' => 0,
        ]);

        $reloaded = Asset::find($asset->id);

        $this->assertNull($reloaded->location_id);
        $this->assertNull($reloaded->company_id);
    }

    public function test_real_ids_still_persist_and_read_normally(): void
    {
        // Non-regression: normalization must not touch valid ids.
        $company = Company::factory()->create();
        $location = Location::factory()->create();
        $asset = Asset::factory()->create();

        $asset->company_id = $company->id;
        $asset->location_id = $location->id;
        $asset->save();

        $reloaded = Asset::find($asset->id);

        $this->assertSame($company->id, $reloaded->company_id);
        $this->assertSame($location->id, $reloaded->location_id);
    }
}
