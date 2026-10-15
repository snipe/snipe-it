<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Import;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\Support\Importing\ManufacturersImportFileBuilder as ImportFileBuilder;

class ImportManufacturersTest extends ImportDataTestCase implements TestsPermissionsRequirement
{
    use CleansUpImportFiles;
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'manufacturer';
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
    public function import_manufacturer(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->manufacturers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 0])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 1, 'updated' => 0, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('manufacturers.index')],
            ]);

        $newManufacturer = Manufacturer::query()
            ->where('name', $row['name'])
            ->sole();

        $this->assertEquals($row['name'], $newManufacturer->name);

    }

    #[Test]
    public function will_ignore_unknown_columns_when_file_contains_unknown_columns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $import = Import::factory()->manufacturers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function when_required_columns_are_missing_in_import_file(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['name' => '']);
        $import = Import::factory()->manufacturers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => ['tally' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errored' => 1]],
                'messages' => [
                    '' => [
                        'Manufacturer ""' => [
                            'name' => ['The name field is required.'],
                        ],
                    ],

                ],
            ]);

        $newManufacturer = Manufacturer::query()
            ->where('name', $importFileBuilder->firstRow()['name'])
            ->get();

        $this->assertCount(0, $newManufacturer);
    }

    #[Test]
    public function update_manufacturer_from_import(): void
    {
        $manufacturer = Manufacturer::factory()->create()->refresh();
        $importFileBuilder = ImportFileBuilder::new(['name' => $manufacturer->name, 'support_url' => $manufacturer->support_url, 'support_phone' => $manufacturer->support_phone, 'support_email' => $manufacturer->support_email]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->manufacturers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedManufacturer = Manufacturer::query()->find($manufacturer->id);
        $updatedAttributes = [
            'name',
            'support_url',
            'support_phone',
            'support_email',
        ];

        $this->assertEquals($row['name'], $updatedManufacturer->name);

        $this->assertEquals(
            Arr::except($manufacturer->attributesToArray(), array_merge($updatedAttributes, $manufacturer->getDates())),
            Arr::except($updatedManufacturer->attributesToArray(), array_merge($updatedAttributes, $manufacturer->getDates())),
        );
    }

    #[Test]
    public function update_mode_clears_field_when_csv_column_is_present_but_empty(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $manufacturer = Manufacturer::factory()->create([
            'support_phone' => '555-1234',
            'support_url' => 'https://pre-existing.example.com',
        ])->refresh();

        $this->assertNotEmpty($manufacturer->support_phone);
        $this->assertNotEmpty($manufacturer->support_url);

        $importFileBuilder = ImportFileBuilder::new([
            'name' => $manufacturer->name,
            'support_phone' => '',
            'support_url' => '',
        ]);
        $import = Import::factory()->manufacturers()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        // Explicit column-mappings so the "Support Phone" CSV column resolves
        // to the 'support_phone' importer field. Matches what the wizard's
        // auto-map does in production; the default_field_map fallback used
        // by tests that omit column-mappings does not know about 'support_phone'.
        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
            'column-mappings' => [
                'name' => 'name',
                'Support Phone' => 'support_phone',
                'support_url' => 'support_url',
            ],
        ])->assertOk();

        $manufacturer->refresh();
        $this->assertNull($manufacturer->support_phone);
        $this->assertNull($manufacturer->support_url);
    }

    #[Test]
    public function update_mode_preserves_fields_when_csv_column_is_absent(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $manufacturer = Manufacturer::factory()->create([
            'support_phone' => '555-9876',
            'support_url' => 'https://do-not-lose.example.com',
        ])->refresh();

        $originalPhone = $manufacturer->support_phone;
        $originalUrl = $manufacturer->support_url;

        // Import a CSV that only has the identity field (name) plus one
        // updated column. All other Manufacturer fields are absent from the
        // CSV, so their DB values must be preserved on update.
        $partialFile = new ImportFileBuilder([[
            'name' => $manufacturer->name,
            'support_email' => 'new-email@example.com',
        ]]);
        $partialImport = Import::factory()->manufacturers()->create([
            'file_path' => $partialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $partialImport->id,
            'import-update' => true,
        ])->assertOk();

        $manufacturer->refresh();
        $this->assertEquals('new-email@example.com', $manufacturer->support_email);
        $this->assertEquals($originalPhone, $manufacturer->support_phone);
        $this->assertEquals($originalUrl, $manufacturer->support_url);
    }
}
