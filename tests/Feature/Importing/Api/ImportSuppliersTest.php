<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Import;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\Support\Importing\SuppliersImportFileBuilder as ImportFileBuilder;

class ImportSuppliersTest extends ImportDataTestCase implements TestsPermissionsRequirement
{
    use CleansUpImportFiles;
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'supplier';
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
    public function import_supplier(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->suppliers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 0])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 1, 'updated' => 0, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('suppliers.index')],
            ]);

        $newSupplier = Supplier::query()
            ->where('name', $row['name'])
            ->sole();

        $this->assertEquals($row['name'], $newSupplier->name);

    }

    #[Test]
    public function will_ignore_unknown_columns_when_file_contains_unknown_columns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $import = Import::factory()->suppliers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function when_required_columns_are_missing_in_import_file(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['name' => '']);
        $import = Import::factory()->suppliers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => ['tally' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errored' => 1]],
                'messages' => [
                    '' => [
                        'Supplier ""' => [
                            'name' => ['The name field is required.'],
                        ],
                    ],

                ],
            ]);

        $newSupplier = Supplier::query()
            ->where('name', $importFileBuilder->firstRow()['name'])
            ->get();

        $this->assertCount(0, $newSupplier);
    }

    #[Test]
    public function update_supplier_from_import(): void
    {
        $supplier = Supplier::factory()->create()->refresh();
        $importFileBuilder = ImportFileBuilder::new(['name' => $supplier->name, 'url' => $supplier->url, 'phone' => $supplier->phone, 'fax' => $supplier->fax, 'contact' => $supplier->contact, 'email' => $supplier->email]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->suppliers()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedSupplier = Supplier::query()->find($supplier->id);
        $updatedAttributes = [
            'name',
            'url',
            'phone',
            'fax',
            'contact',
            'email',
        ];

        $this->assertEquals($row['name'], $updatedSupplier->name);

        $this->assertEquals(
            Arr::except($supplier->attributesToArray(), array_merge($updatedAttributes, $supplier->getDates())),
            Arr::except($updatedSupplier->attributesToArray(), array_merge($updatedAttributes, $supplier->getDates())),
        );
    }

    #[Test]
    public function update_mode_clears_field_when_csv_column_is_present_but_empty(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $supplier = Supplier::factory()->create([
            'phone' => '555-1234',
            'url' => 'https://pre-existing.example.com',
        ])->refresh();

        $this->assertNotEmpty($supplier->phone);
        $this->assertNotEmpty($supplier->url);

        $importFileBuilder = ImportFileBuilder::new([
            'name' => $supplier->name,
            'phone' => '',
            'url' => '',
        ]);
        $import = Import::factory()->suppliers()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
        ])->assertOk();

        $supplier->refresh();
        $this->assertNull($supplier->phone);
        $this->assertNull($supplier->url);
    }

    #[Test]
    public function update_mode_preserves_fields_when_csv_column_is_absent(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $supplier = Supplier::factory()->create([
            'phone' => '555-9876',
            'url' => 'https://do-not-lose.example.com',
        ])->refresh();

        $originalPhone = $supplier->phone;
        $originalUrl = $supplier->url;

        // Import a CSV that only has the identity field (name) plus one
        // updated column. All other Supplier fields are absent from the CSV,
        // so their DB values must be preserved on update.
        $partialFile = new ImportFileBuilder([[
            'name' => $supplier->name,
            'city' => 'RenamedCity',
        ]]);
        $partialImport = Import::factory()->suppliers()->create([
            'file_path' => $partialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $partialImport->id,
            'import-update' => true,
        ])->assertOk();

        $supplier->refresh();
        $this->assertEquals('RenamedCity', $supplier->city);
        $this->assertEquals($originalPhone, $supplier->phone);
        $this->assertEquals($originalUrl, $supplier->url);
    }
}
