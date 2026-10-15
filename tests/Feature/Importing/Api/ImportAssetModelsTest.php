<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActionLog;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Import;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\Importing\AssetModelsImportFileBuilder as ImportFileBuilder;
use Tests\Support\Importing\CleansUpImportFiles;

class ImportAssetModelsTest extends ImportDataTestCase implements TestsPermissionsRequirement
{
    use CleansUpImportFiles;
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'assetModel';
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
    public function import_asset_models(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->assetmodel()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 0])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 1, 'updated' => 0, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('models.index')],
            ]);

        $newAssetModel = AssetModel::query()
            ->with(['category'])
            ->where('name', $row['name'])
            ->sole();

        $this->assertEquals($row['name'], $newAssetModel->name);
        $this->assertEquals($row['model_number'], $newAssetModel->model_number);

    }

    #[Test]
    public function will_ignore_unknown_columns_when_file_contains_unknown_columns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $import = Import::factory()->assetmodel()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function when_required_columns_are_missing_in_import_file(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['name' => '']);
        $import = Import::factory()->assetmodel()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => ['tally' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errored' => 1]],
                'messages' => [
                    '' => [
                        'name' => [
                            'name' => ['The name must be a string.'],
                        ],
                    ],
                ],
            ]);

        $newAssetModels = AssetModel::query()
            ->where('name', $importFileBuilder->firstRow()['name'])
            ->get();

        $this->assertCount(0, $newAssetModels);
    }

    #[Test]
    public function update_asset_model_from_import(): void
    {
        $assetmodel = AssetModel::factory()->create();
        $category = Category::find($assetmodel->category_id);
        $importFileBuilder = ImportFileBuilder::new(['name' => $assetmodel->name, 'model_number' => Str::random(), 'category' => $category->name]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->assetmodel()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])
            ->assertOk()
            ->assertExactJson([
                'payload' => ['tally' => ['created' => 0, 'updated' => 1, 'skipped' => 0, 'errored' => 0]],
                'status' => 'success',
                'messages' => ['redirect_url' => route('models.index')],
            ]);

        $updatedAssetmodel = AssetModel::query()->find($assetmodel->id);

        $this->assertEquals($row['model_number'], $updatedAssetmodel->model_number);
        $this->assertEquals($row['name'], $updatedAssetmodel->name);

    }

    #[Test]
    public function update_mode_clears_field_when_csv_column_is_present_but_empty(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $assetmodel = AssetModel::factory()->create([
            'notes' => 'Some pre-existing notes',
            'eol' => 24,
        ])->refresh();

        $this->assertNotEmpty($assetmodel->notes);
        $this->assertNotNull($assetmodel->eol);

        $importFileBuilder = new ImportFileBuilder([[
            'name' => $assetmodel->name,
            'model_number' => $assetmodel->model_number,
            'notes' => '',
            'eol' => '',
        ]]);
        $import = Import::factory()->assetmodel()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $import->id,
            'import-update' => true,
        ])->assertOk();

        $assetmodel->refresh();
        $this->assertNull($assetmodel->notes);
        $this->assertNull($assetmodel->eol);
    }

    #[Test]
    public function update_mode_preserves_fields_when_csv_column_is_absent(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $assetmodel = AssetModel::factory()->create([
            'notes' => 'Do Not Lose This',
            'eol' => 48,
        ])->refresh();

        $originalNotes = $assetmodel->notes;
        $originalEol = $assetmodel->eol;
        $originalModelNumber = $assetmodel->model_number;

        // Import a CSV that only has the identity field (name) plus one
        // updated column. All other AssetModel fields are absent from the
        // CSV, so their DB values must be preserved on update.
        $partialFile = new ImportFileBuilder([[
            'name' => $assetmodel->name,
            'min_amt' => 5,
        ]]);
        $partialImport = Import::factory()->assetmodel()->create([
            'file_path' => $partialFile->saveToImportsDirectory(),
        ]);

        // Explicit column-mappings so "Min Amount" resolves to 'min_amt'.
        // Matches what the wizard's auto-map does in production; the
        // default_field_map fallback used by tests that omit column-mappings
        // does not know how to reduce "Min Amount" to 'min_amt'.
        $this->importFileResponse([
            'import' => $partialImport->id,
            'import-update' => true,
            'column-mappings' => [
                'Name' => 'name',
                'Min Amount' => 'min_amt',
            ],
        ])->assertOk();

        $assetmodel->refresh();
        $this->assertEquals(5, $assetmodel->min_amt);
        $this->assertEquals($originalNotes, $assetmodel->notes);
        $this->assertEquals($originalEol, $assetmodel->eol);
        $this->assertEquals($originalModelNumber, $assetmodel->model_number);
    }

    #[Test]
    public function update_mode_logs_asset_model_update_in_actionlog(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create());

        $initialFile = ImportFileBuilder::new();
        $initialRow = $initialFile->firstRow();
        $initialImport = Import::factory()->assetmodel()->create([
            'file_path' => $initialFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse(['import' => $initialImport->id])->assertOk();

        $assetModel = AssetModel::query()->where('name', $initialRow['name'])->sole();

        $updatedRow = array_merge($initialRow, [
            'model_number' => Str::random(),
        ]);

        $updateFile = new ImportFileBuilder([$updatedRow]);
        $updateImport = Import::factory()->assetmodel()->create([
            'file_path' => $updateFile->saveToImportsDirectory(),
        ]);

        $this->importFileResponse([
            'import' => $updateImport->id,
            'import-update' => true,
        ])->assertOk();

        $assetModel->refresh();
        $this->assertEquals($updatedRow['model_number'], $assetModel->model_number);

        $updateLog = ActionLog::query()
            ->where('item_type', AssetModel::class)
            ->where('item_id', $assetModel->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $this->assertNotNull($updateLog, 'Expected an update action log entry after asset model importer update mode.');
    }
}
