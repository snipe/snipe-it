<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActivityLog;
use App\Models\Consumable;
use Database\Factories\ConsumableFactory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\ConsumablesImportFileBuilder as ImportFileBuilder;

class ImportConsumablesTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'consumable';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportConsumables(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAssetsPermissionCanImportConsumables(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->consumable()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importConsumables(): void
    {
        Notification::fake();

        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => ['redirect_url' => route('consumables.index')]
            ]);

        $newConsumable = Consumable::query()
            ->with(['location', 'category', 'company'])
            ->where('name', $row['itemName'])
            ->sole();

        $activityLog = ActivityLog::query()
            ->where('item_type', Consumable::class)
            ->where('item_id', $newConsumable->id)
            ->sole();

        $this->assertEquals($activityLog->action_type, 'create');
        $this->assertEquals($activityLog->action_source, 'importer');
        $this->assertEquals($activityLog->company_id, $newConsumable->company->id);

        $this->assertEquals($newConsumable->name, $row['itemName']);
        $this->assertEquals($newConsumable->category->name, $row['category']);
        $this->assertEquals($newConsumable->location->name, $row['location']);
        $this->assertEquals($newConsumable->company->name, $row['companyName']);
        $this->assertNull($newConsumable->supplier_id);
        $this->assertFalse($newConsumable->requestable);
        $this->assertNull($newConsumable->image);
        $this->assertEquals($newConsumable->order_number, $row['orderNumber']);
        $this->assertEquals($newConsumable->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($newConsumable->purchase_cost, $row['purchaseCost']);
        $this->assertNull($newConsumable->min_amt);
        $this->assertEquals($newConsumable->model_number, '');
        $this->assertNull($newConsumable->item_number);
        $this->assertNull($newConsumable->manufacturer_id);
        $this->assertNull($newConsumable->notes);
    }

    #[Test]
    public function willIgnoreUnknownColumnsWhenFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willNotCreateNewConsumableWhenConsumableNameAlreadyExist(): void
    {
        $consumable = ConsumableFactory::new()->create(['name' => Str::random()]);
        $importFileBuilder = ImportFileBuilder::new(['itemName' => $consumable->name]);
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $probablyNewConsumables = Consumable::query()
            ->where('name', $consumable->name)
            ->get();

        $this->assertCount(1, $probablyNewConsumables);
        $this->assertEquals($consumable->id, $probablyNewConsumables->sole()->id);
    }

    #[Test]
    public function willNotCreateNewCompanyWhenCompanyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['companyName' => Str::random()]);
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newConsumables = Consumable::query()
            ->whereIn('name', $importFileBuilder->pluck('itemName'))
            ->get(['company_id']);

        $this->assertCount(1, $newConsumables->pluck('company_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewLocationWhenLocationExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['location' => Str::random()]);
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newConsumables = Consumable::query()
            ->whereIn('name', $importFileBuilder->pluck('itemName'))
            ->get(['location_id']);

        $this->assertCount(1, $newConsumables->pluck('location_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewCategoryWhenCategoryExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['category' => Str::random()]);
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newConsumables = Consumable::query()
            ->whereIn('name', $importFileBuilder->pluck('itemName'))
            ->get(['category_id']);

        $this->assertCount(1, $newConsumables->pluck('category_id')->unique()->all());
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['category' => ''])->forget(['quantity', 'name']);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status'   => 'import-errors',
                'payload'  => null,
                'messages' => [
                    $row['itemName'] => [
                        'Consumable' => [
                            'category_id' => ['The category id field is required.']
                        ]
                    ]
                ]
            ]);

        $newConsumables = Consumable::query()
            ->whereIn('name', $importFileBuilder->pluck('itemName'))
            ->get(['id']);

        $this->assertCount(0, $newConsumables);
    }

    #[Test]
    public function updateConsumableFromImport(): void
    {
        $consumable = ConsumableFactory::new()->create(['name' => Str::random()]);
        $importFileBuilder = ImportFileBuilder::new(['itemName' => $consumable->name]);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedConsumable = Consumable::query()
            ->with(['location', 'category', 'company'])
            ->where('name', $importFileBuilder->firstRow()['itemName'])
            ->sole();

        $this->assertEquals($updatedConsumable->name, $row['itemName']);
        $this->assertEquals($updatedConsumable->category->name, $row['category']);
        $this->assertEquals($updatedConsumable->location->name, $row['location']);
        $this->assertEquals($updatedConsumable->company->name, $row['companyName']);
        $this->assertEquals($updatedConsumable->order_number, $row['orderNumber']);
        $this->assertEquals($updatedConsumable->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($updatedConsumable->purchase_cost, $row['purchaseCost']);

        $this->assertEquals($consumable->supplier_id, $updatedConsumable->supplier_id);
        $this->assertEquals($consumable->requestable, $updatedConsumable->requestable);
        $this->assertEquals($consumable->min_amt, $updatedConsumable->min_amt);
        $this->assertEquals($consumable->model_number, $updatedConsumable->model_number);
        $this->assertEquals($consumable->item_number, $updatedConsumable->item_number);
        $this->assertEquals($consumable->manufacturer_id, $updatedConsumable->manufacturer_id);
        $this->assertEquals($consumable->notes, $updatedConsumable->notes);
        $this->assertEquals($consumable->item_number, $updatedConsumable->item_number);
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::new()->definition();
        $row = [
            'category'     => $faker['supplier'],
            'companyName'  => $faker['quantity'],
            'itemName'     => $faker['purchaseDate'],
            'location'     => $faker['purchaseCost'],
            'orderNumber'  => $faker['orderNumber'],
            'purchaseCost' => $faker['location'],
            'purchaseDate' => $faker['companyName'],
            'quantity'     => $faker['itemName'],
            'supplier'     => $faker['category']
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);

        $import = ImportFactory::new()->consumable()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Category'      => 'supplier',
                'Company'       => 'quantity',
                'item Name'     => 'purchase_date',
                'Location'      => 'purchase_cost',
                'Order Number'  => 'order_number',
                'Purchase Cost' => 'location',
                'Purchase Date' => 'company',
                'Quantity'      => 'item_name',
                'Supplier'      => 'category',
            ]
        ])->assertOk();

        $newConsumable = Consumable::query()
            ->with(['location', 'category', 'company'])
            ->where('name', $importFileBuilder->firstRow()['quantity'])
            ->sole();

        $this->assertEquals($newConsumable->category->name, $row['supplier']);
        $this->assertEquals($newConsumable->location->name, $row['purchaseCost']);
        $this->assertEquals($newConsumable->company->name, $row['purchaseDate']);
        $this->assertEquals($newConsumable->qty, $row['companyName']);
        $this->assertEquals($newConsumable->name, $row['quantity']);
        $this->assertNull($newConsumable->supplier_id);
        $this->assertFalse($newConsumable->requestable);
        $this->assertNull($newConsumable->image);
        $this->assertEquals($newConsumable->order_number, $row['orderNumber']);
        $this->assertEquals($newConsumable->purchase_date->toDateString(), $row['itemName']);
        $this->assertEquals($newConsumable->purchase_cost, $row['location']);
        $this->assertNull($newConsumable->min_amt);
        $this->assertEquals($newConsumable->model_number, '');
        $this->assertNull($newConsumable->item_number);
        $this->assertNull($newConsumable->manufacturer_id);
        $this->assertNull($newConsumable->notes);
    }
}
