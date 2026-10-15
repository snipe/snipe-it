<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActionLog;
use App\Models\Import;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\Support\Importing\LocationsImportFileBuilder as ImportFileBuilder;

class ImportLocationsTest extends ImportDataTestCase implements TestsPermissionsRequirement
{
    use CleansUpImportFiles;
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'location';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    public function test_requires_permission()
    {
        $this->actingAsForApi(User::factory()->create());

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function import_location(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->locations()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 0])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 1, 'updated' => 0, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('locations.index')],
            ]);

        $newLocation = Location::query()
            ->where('name', $row['name'])
            ->sole();

        $this->assertEquals($row['name'], $newLocation->name);

    }

    #[Test]
    public function will_ignore_unknown_columns_when_file_contains_unknown_columns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $import = Import::factory()->locations()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function when_required_columns_are_missing_in_import_file(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['name' => '']);
        $import = Import::factory()->locations()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => ['tally' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errored' => 1]],
                'messages' => [
                    '' => [
                        'Location ""' => [
                            'name' => ['The name field is required.'],
                        ],
                    ],

                ],
            ]);

        $newLocation = Location::query()
            ->where('name', $importFileBuilder->firstRow()['name'])
            ->get();

        $this->assertCount(0, $newLocation);
    }

    #[Test]
    public function update_location_from_import(): void
    {
        $location = Location::factory()->create()->refresh();
        $importFileBuilder = ImportFileBuilder::new(['name' => $location->name, 'phone' => $location->phone]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->locations()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedLocation = Location::query()->find($location->id);
        $updatedAttributes = [
            'name',
            'phone',
        ];

        $this->assertEquals($row['name'], $updatedLocation->name);

        $this->assertEquals(
            Arr::except($location->attributesToArray(), array_merge($updatedAttributes, $location->getDates())),
            Arr::except($updatedLocation->attributesToArray(), array_merge($updatedAttributes, $location->getDates())),
        );
    }

    #[Test]
    public function update_mode_clears_field_when_csv_column_is_present_but_empty(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $location = Location::factory()->create([
            'address' => '123 Pre-existing Street',
            'city' => 'PreExistingCity',
        ])->refresh();

        $this->assertNotEmpty($location->address);
        $this->assertNotEmpty($location->city);

        // Construct directly (not via ::new()) so address + city land in the
        // row array. ::new() runs replace() which only overwrites keys the
        // default definition() already emits; the Location builder default
        // only has name + phone, so 'address' and 'city' would be dropped
        // and the CSV would not contain those columns at all.
        $importFileBuilder = new ImportFileBuilder([[
            'name' => $location->name,
            'address' => '',
            'city' => '',
        ]]);
        $import = Import::factory()->locations()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
        ])->assertOk();

        $location->refresh();
        $this->assertNull($location->address);
        $this->assertNull($location->city);
    }

    #[Test]
    public function update_mode_preserves_fields_when_csv_column_is_absent(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $location = Location::factory()->create([
            'address' => 'Do Not Lose This',
            'city' => 'PreservedCity',
        ])->refresh();

        $originalAddress = $location->address;
        $originalCity = $location->city;

        // Import a CSV that only has the identity field (name) plus one
        // updated column. All other Location fields are absent from the CSV,
        // so their DB values must be preserved on update.
        $partialFile = new ImportFileBuilder([[
            'name' => $location->name,
            'zip' => '99999',
        ]]);
        $partialImport = Import::factory()->locations()->create([
            'file_path' => $partialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $partialImport->id,
            'import-update' => true,
        ])->assertOk();

        $location->refresh();
        $this->assertEquals('99999', $location->zip);
        $this->assertEquals($originalAddress, $location->address);
        $this->assertEquals($originalCity, $location->city);
    }

    #[Test]
    public function update_mode_logs_location_update_in_actionlog(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $initialFile = ImportFileBuilder::new();
        $initialRow = $initialFile->firstRow();
        $initialImport = Import::factory()->locations()->create([
            'file_path' => $initialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse(['import' => $initialImport->id])->assertOk();

        $location = Location::query()->where('name', $initialRow['name'])->sole();

        $updatedRow = array_merge($initialRow, [
            'notes' => 'Importer update notes',
        ]);

        $updateFile = new ImportFileBuilder([$updatedRow]);
        $updateImport = Import::factory()->locations()->create([
            'file_path' => $updateFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $updateImport->id,
            'import-update' => true,
        ])->assertOk();

        $location->refresh();
        $this->assertEquals($updatedRow['notes'], $location->notes);

        $updateLog = ActionLog::query()
            ->where('item_type', Location::class)
            ->where('item_id', $location->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $this->assertNotNull($updateLog, 'Expected an update action log entry after location importer update mode.');
    }
}
