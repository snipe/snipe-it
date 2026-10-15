<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Category;
use App\Models\Import;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\Importing\CategoriesImportFileBuilder as ImportFileBuilder;
use Tests\Support\Importing\CleansUpImportFiles;

class ImportCategoriesTest extends ImportDataTestCase implements TestsPermissionsRequirement
{
    use CleansUpImportFiles;
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'category';
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
    public function import_category(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->categories()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 0])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 1, 'updated' => 0, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('categories.index')],
            ]);

        $newCategory = Category::query()
            ->where('name', $row['name'])
            ->sole();

        $this->assertEquals($row['name'], $newCategory->name);

    }

    #[Test]
    public function will_ignore_unknown_columns_when_file_contains_unknown_columns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $import = Import::factory()->categories()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function when_required_columns_are_missing_in_import_file(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['name' => '']);
        $import = Import::factory()->categories()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => ['tally' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errored' => 1]],
                'messages' => [
                    '' => [
                        'Category ""' => [
                            'name' => ['The name field is required.'],
                        ],
                    ],

                ],
            ]);

        $newCategory = Category::query()
            ->where('name', $importFileBuilder->firstRow()['name'])
            ->get();

        $this->assertCount(0, $newCategory);
    }

    #[Test]
    public function update_category_from_import(): void
    {
        $category = Category::factory()->create()->refresh();
        $importFileBuilder = ImportFileBuilder::new(['name' => $category->name, 'category_type' => 'asset', 'notes' => $category->notes, 'use_default_eula' => 0, 'require_acceptance' => 0, 'checkin_email' => 0]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->categories()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedCategory = Category::query()->find($category->id);

        // Boolean flags (use_default_eula, require_acceptance, checkin_email)
        // are explicitly set to 0 in the CSV above. Under the new CSV-present
        // semantics, those values now propagate to the DB - the old importer's
        // sanitize reject-empty pass silently stripped 0 values on update.
        // Excluding them from the "unchanged" comparison because they are
        // intentionally overwritten by the CSV.
        $updatedAttributes = [
            'name',
            'use_default_eula',
            'require_acceptance',
            'checkin_email',
        ];

        $this->assertEquals($row['name'], $updatedCategory->name);
        $this->assertEquals(0, $updatedCategory->use_default_eula);
        $this->assertEquals(0, $updatedCategory->require_acceptance);
        $this->assertEquals(0, $updatedCategory->checkin_email);

        $this->assertEquals(
            Arr::except($category->attributesToArray(), array_merge($updatedAttributes, $category->getDates())),
            Arr::except($updatedCategory->attributesToArray(), array_merge($updatedAttributes, $category->getDates())),
        );
    }

    #[Test]
    public function update_mode_clears_field_when_csv_column_is_present_but_empty(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $category = Category::factory()->assetLaptopCategory()->create([
            'notes' => 'Some pre-existing notes',
            'eula_text' => 'Some EULA text',
        ])->refresh();

        $this->assertNotEmpty($category->notes);
        $this->assertNotEmpty($category->eula_text);

        $importFileBuilder = new ImportFileBuilder([[
            'name' => $category->name,
            'category_type' => $category->category_type,
            'notes' => '',
            'eula_text' => '',
        ]]);
        $import = Import::factory()->categories()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
        ])->assertOk();

        $category->refresh();
        $this->assertNull($category->notes);
        $this->assertNull($category->eula_text);
    }

    #[Test]
    public function import_sets_alert_on_response_flag(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $importFileBuilder = new ImportFileBuilder([[
            'name' => 'Alerting Laptops',
            'category_type' => 'asset',
            'alert_on_response' => 1,
        ]]);
        $import = Import::factory()->categories()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newCategory = Category::query()->where('name', 'Alerting Laptops')->sole();

        $this->assertEquals(1, $newCategory->alert_on_response);
    }

    #[Test]
    public function update_mode_updates_alert_on_response_flag(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $category = Category::factory()->assetLaptopCategory()->create([
            'alert_on_response' => 1,
        ])->refresh();

        $this->assertEquals(1, $category->alert_on_response);

        $importFileBuilder = new ImportFileBuilder([[
            'name' => $category->name,
            'category_type' => $category->category_type,
            'alert_on_response' => 0,
        ]]);
        $import = Import::factory()->categories()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
        ])->assertOk();

        $category->refresh();

        $this->assertEquals(0, $category->alert_on_response);
    }

    #[Test]
    public function update_mode_preserves_fields_when_csv_column_is_absent(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $category = Category::factory()->assetLaptopCategory()->create([
            'notes' => 'Do Not Lose This',
            'eula_text' => 'Preserved EULA',
            'tag_color' => '#123456',
        ])->refresh();

        $originalNotes = $category->notes;
        $originalEula = $category->eula_text;
        $originalTagColor = $category->tag_color;

        // Import a CSV that only has the identity fields (name + category_type)
        // and one updated column. All other Category fields are absent from
        // the CSV, so their DB values must be preserved on update.
        $partialFile = new ImportFileBuilder([[
            'name' => $category->name,
            'category_type' => $category->category_type,
            'require_acceptance' => 1,
        ]]);
        $partialImport = Import::factory()->categories()->create([
            'file_path' => $partialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $partialImport->id,
            'import-update' => true,
        ])->assertOk();

        $category->refresh();
        $this->assertEquals(1, $category->require_acceptance);
        $this->assertEquals($originalNotes, $category->notes);
        $this->assertEquals($originalEula, $category->eula_text);
        $this->assertEquals($originalTagColor, $category->tag_color);
    }
}
