<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Import;
use App\Models\Location;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\Importing\AssetsImportFileBuilder as ImportFileBuilder;
use Tests\Support\Importing\CleansUpImportFiles;

class ImportAssetsFmcsIsolationTest extends ImportDataTestCase
{
    use CleansUpImportFiles;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'asset';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    public function scoped_importer_cannot_inject_asset_into_another_tenants_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$attackerCo, $victimCo] = Company::factory()->count(2)->create();
        $attacker = User::factory()->canImport()->forCompany($attackerCo)->create();

        $builder = ImportFileBuilder::new(['companyName' => $victimCo->name]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $attacker->id,
        ]);

        $this->actingAsForApi($attacker);
        $this->importFileResponse(['import' => $import->id]);

        $this->assertDatabaseMissing('assets', [
            'serial' => $builder->firstRow()['serialNumber'],
        ]);
    }

    #[Test]
    public function importer_pinning_to_their_own_company_still_works(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $ownCompany = Company::factory()->create();
        $user = User::factory()->canImport()->forCompany($ownCompany)->create();

        $builder = ImportFileBuilder::new(['companyName' => $ownCompany->name]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $user->id,
        ]);

        $this->actingAsForApi($user);
        $this->importFileResponse(['import' => $import->id]);

        $asset = Asset::query()->where('serial', $builder->firstRow()['serialNumber'])->first();

        $this->assertNotNull($asset, 'Legit same-tenant import should still succeed.');
        $this->assertSame($ownCompany->id, $asset->company_id);
    }

    #[Test]
    public function empty_pivot_user_gets_floater_pass_when_floater_mode_is_on(): void
    {
        $this->settings->enableMultipleFullCompanySupport()->enableFloaterMode();

        $existingCo = Company::factory()->create();
        $floater = User::factory()->canImport()->withoutCompany()->create();

        $builder = ImportFileBuilder::new(['companyName' => $existingCo->name]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $floater->id,
        ]);

        $this->actingAsForApi($floater);
        $this->importFileResponse(['import' => $import->id]);

        $asset = Asset::query()->where('serial', $builder->firstRow()['serialNumber'])->first();

        $this->assertNotNull($asset, 'Empty-pivot floater should be able to import.');
        $this->assertSame($existingCo->id, $asset->company_id, 'Floater should be able to pin to any company.');
    }

    #[Test]
    public function empty_pivot_user_is_rejected_when_floater_mode_is_off(): void
    {
        $this->settings->enableMultipleFullCompanySupport()->disableFloaterMode();

        $existingCo = Company::factory()->create();
        $attacker = User::factory()->canImport()->withoutCompany()->create();

        $builder = ImportFileBuilder::new(['companyName' => $existingCo->name]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $attacker->id,
        ]);

        $this->actingAsForApi($attacker);
        $this->importFileResponse(['import' => $import->id]);

        $this->assertDatabaseMissing('assets', [
            'serial' => $builder->firstRow()['serialNumber'],
        ]);
    }

    #[Test]
    public function superuser_can_still_pin_to_any_company_and_auto_create(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $existingCo = Company::factory()->create();
        $superuser = User::factory()->superuser()->create();

        $builder = ImportFileBuilder::new(['companyName' => $existingCo->name]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $superuser->id,
        ]);

        $this->actingAsForApi($superuser);
        $this->importFileResponse(['import' => $import->id]);

        $asset = Asset::query()->where('serial', $builder->firstRow()['serialNumber'])->firstOrFail();
        $this->assertSame($existingCo->id, $asset->company_id);
    }

    #[Test]
    public function scoped_importer_cannot_update_another_tenants_asset_by_id(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$attackerCo, $victimCo] = Company::factory()->count(2)->create();
        $attacker = User::factory()->canImport()->forCompany($attackerCo)->create();

        $victimAsset = Asset::factory()->create([
            'company_id' => $victimCo->id,
            'name' => 'ORIGINAL_VICTIM_NAME',
        ]);

        $csv = "ID,Asset Tag,item Name\n";
        $csv .= "{$victimAsset->id},{$victimAsset->asset_tag},HIJACKED_BY_ATTACKER\n";
        $filename = 'attack-'.uniqid().'.csv';
        file_put_contents(config('app.private_uploads')."/imports/{$filename}", $csv);

        $import = Import::factory()->asset()->create([
            'file_path' => $filename,
            'created_by' => $attacker->id,
        ]);

        $this->actingAsForApi($attacker);
        $this->importFileResponse(['import' => $import->id]);

        $this->assertSame(
            'ORIGINAL_VICTIM_NAME',
            $victimAsset->fresh()->name,
            'Attacker must not update another tenants asset by id.',
        );
    }

    #[Test]
    public function scoped_importer_cannot_pin_asset_to_foreign_company_location_when_locations_are_fmcs_scoped(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        [$attackerCo, $victimCo] = Company::factory()->count(2)->create();
        $attacker = User::factory()->canImport()->forCompany($attackerCo)->create();

        $victimLocation = Location::factory()->create(['company_id' => $victimCo->id]);

        $builder = ImportFileBuilder::new([
            'companyName' => $attackerCo->name,
            'location' => $victimLocation->name,
        ]);
        $import = Import::factory()->asset()->create([
            'file_path' => $builder->saveToImportsDirectory(),
            'created_by' => $attacker->id,
        ]);

        $this->actingAsForApi($attacker);
        $this->importFileResponse(['import' => $import->id]);

        $this->assertDatabaseMissing('assets', [
            'serial' => $builder->firstRow()['serialNumber'],
        ]);
    }
}
