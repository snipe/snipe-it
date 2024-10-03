<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActionLog;
use App\Models\Component;
use Database\Factories\ComponentFactory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\ComponentsImportFileBuilder as ImportFileBuilder;

class ImportComponentsTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'component';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportComponents(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAssetsPermissionCanImportComponents(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->component()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importComponents(): void
    {
        Notification::fake();

        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => ['redirect_url' => route('components.index')]
            ]);

        $newComponent = Component::query()
            ->with(['location', 'category', 'company'])
            ->where('name', $row['itemName'])
            ->sole();

        $activityLog = ActionLog::query()
            ->where('item_type', Component::class)
            ->where('item_id', $newComponent->id)
            ->sole();

        $this->assertEquals($activityLog->action_type, 'create');
        $this->assertEquals($activityLog->action_source, 'importer');
        $this->assertEquals($activityLog->company_id, $newComponent->company->id);

        $this->assertEquals($newComponent->name, $row['itemName']);
        $this->assertEquals($newComponent->company->name, $row['companyName']);
        $this->assertEquals($newComponent->category->name, $row['category']);
        $this->assertEquals($newComponent->location->name, $row['location']);
        $this->assertNull($newComponent->supplier_id);
        $this->assertEquals($newComponent->qty, $row['quantity']);
        $this->assertEquals($newComponent->order_number, $row['orderNumber']);
        $this->assertEquals($newComponent->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($newComponent->purchase_cost, $row['purchaseCost']);
        $this->assertNull($newComponent->min_amt);
        $this->assertEquals($newComponent->serial, $row['serialNumber']);
        $this->assertNull($newComponent->image);
        $this->assertNull($newComponent->notes);
    }

    #[Test]
    public function willIgnoreUnknownColumnsWhenFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->firstRow();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willNotCreateNewComponentWhenComponentWithNameAndSerialNumberExists(): void
    {
        $component = ComponentFactory::new()->create();

        $importFileBuilder = ImportFileBuilder::times(4)->replace([
            'itemName'     => $component->name,
            'serialNumber' => $component->serial
        ]);

        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $probablyNewComponents = Component::query()
            ->where('name', $component->name)
            ->where('serial', $component->serial)
            ->get(['id']);

        $this->assertCount(1, $probablyNewComponents);
        $this->assertEquals($component->id, $probablyNewComponents->sole()->id);
    }

    #[Test]
    public function willNotCreateNewCompanyWhenCompanyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['companyName' => Str::random()]);
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newComponents = Component::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['company_id']);

        $this->assertCount(1, $newComponents->pluck('company_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewLocationWhenLocationExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['location' => Str::random()]);
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newComponents = Component::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['location_id']);

        $this->assertCount(1, $newComponents->pluck('location_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewCategoryWhenCategoryExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['category' => $this->faker->company]);
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newComponents = Component::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['category_id']);

        $this->assertCount(1, $newComponents->pluck('category_id')->unique()->all());
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::new()
            ->replace(['category' => ''])
            ->forget(['quantity']);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status'   => 'import-errors',
                'payload'  => null,
                'messages' => [
                    $row['itemName'] => [
                        'Component' => [
                            'qty' => ['The qty field must be at least 1.'],
                            'category_id' => ['The category id field is required.']
                        ]
                    ]
                ]
            ]);

        $newComponents = Component::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(0, $newComponents);
    }

    #[Test]
    public function updateComponentFromImport(): void
    {
        $component = ComponentFactory::new()->create();
        $importFileBuilder = ImportFileBuilder::new([
            'itemName'     => $component->name,
            'serialNumber' => $component->serial
        ]);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedComponent = Component::query()
            ->with(['location', 'category'])
            ->where('serial', $row['serialNumber'])
            ->sole();

        $this->assertEquals($updatedComponent->name, $row['itemName']);
        $this->assertEquals($updatedComponent->category->name, $row['category']);
        $this->assertEquals($updatedComponent->location->name, $row['location']);
        $this->assertEquals($updatedComponent->supplier_id, $component->supplier_id);
        $this->assertEquals($updatedComponent->qty, $row['quantity']);
        $this->assertEquals($updatedComponent->order_number, $row['orderNumber']);
        $this->assertEquals($updatedComponent->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($updatedComponent->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($updatedComponent->min_amt, $component->min_amt);
        $this->assertEquals($updatedComponent->serial, $row['serialNumber']);
        $this->assertEquals($updatedComponent->image, $component->image);
        $this->assertEquals($updatedComponent->notes, $component->notes);
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::new()->definition();
        $row = [
            'category'     => $faker['serialNumber'],
            'companyName'  => $faker['quantity'],
            'itemName'     => $faker['purchaseDate'],
            'location'     => $faker['purchaseCost'],
            'orderNumber'  => $faker['orderNumber'],
            'purchaseCost' => $faker['category'],
            'purchaseDate' => $faker['companyName'],
            'quantity'     => $faker['itemName'],
            'serialNumber' => $faker['location']
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);
        $import = ImportFactory::new()->component()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Category'      => 'serial',
                'Company'       => 'quantity',
                'item Name'     => 'purchase_date',
                'Location'      => 'purchase_cost',
                'Order Number'  => 'order_number',
                'Purchase Cost' => 'category',
                'Purchase Date' => 'company',
                'Quantity'      => 'item_name',
                'Serial number' => 'location',
            ]
        ])->assertOk();

        $newComponent = Component::query()
            ->with(['location', 'category'])
            ->where('serial', $importFileBuilder->firstRow()['category'])
            ->sole();

        $this->assertEquals($newComponent->name, $row['quantity']);
        $this->assertEquals($newComponent->category->name, $row['purchaseCost']);
        $this->assertEquals($newComponent->location->name, $row['serialNumber']);
        $this->assertNull($newComponent->supplier_id);
        $this->assertEquals($newComponent->qty, $row['companyName']);
        $this->assertEquals($newComponent->order_number, $row['orderNumber']);
        $this->assertEquals($newComponent->purchase_date->toDateString(), $row['itemName']);
        $this->assertEquals($newComponent->purchase_cost, $row['location']);
        $this->assertNull($newComponent->min_amt);
        $this->assertNull($newComponent->image);
        $this->assertNull($newComponent->notes);
    }
}
