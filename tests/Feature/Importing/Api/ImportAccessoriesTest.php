<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Company;
use Database\Factories\AccessoryFactory;
use Database\Factories\CompanyFactory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\AccessoriesImportFileBuilder as ImportFileBuilder;

class ImportAccessoriesTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'accessory';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportAccessories(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAccessoryPermissionCanImportAccessories(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->accessory()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importAccessory(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => [
                    'redirect_url' => route('accessories.index')
                ]
            ]);

        $newAccessory = Accessory::query()
            ->with(['location', 'category', 'manufacturer', 'supplier', 'company'])
            ->where('name', $row['itemName'])
            ->sole();

        $activityLog = Actionlog::query()
            ->where('item_type', Accessory::class)
            ->where('item_id', $newAccessory->id)
            ->sole();

        $this->assertEquals($activityLog->action_type, 'create');
        $this->assertEquals($activityLog->action_source, 'importer');
        $this->assertEquals($activityLog->company_id, $newAccessory->company->id);

        $this->assertEquals($newAccessory->name, $row['itemName']);
        $this->assertEquals($newAccessory->qty, $row['quantity']);
        $this->assertEquals($newAccessory->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($newAccessory->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($newAccessory->order_number, $row['orderNumber']);
        $this->assertEquals($newAccessory->notes, $row['notes']);
        $this->assertEquals($newAccessory->category->name, $row['category']);
        $this->assertEquals($newAccessory->category->category_type, 'accessory');
        $this->assertEquals($newAccessory->manufacturer->name, $row['manufacturerName']);
        $this->assertEquals($newAccessory->supplier->name, $row['supplierName']);
        $this->assertEquals($newAccessory->location->name, $row['location']);
        $this->assertEquals($newAccessory->company->name, $row['companyName']);
        $this->assertEquals($newAccessory->model_number, $row['modelNumber']);
        $this->assertFalse($newAccessory->requestable);
        $this->assertNull($newAccessory->min_amt);
        $this->assertNull($newAccessory->user_id);
    }

    #[Test]
    public function whenImportFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumn'] = $this->faker->word;

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willFormatDate(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['purchaseDate' => '2022/10/10']);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $accessory = Accessory::query()
            ->where('name', $importFileBuilder->firstRow()['itemName'])
            ->sole(['purchase_date']);

        $this->assertEquals($accessory->purchase_date->toDateString(), '2022-10-10');
    }

    #[Test]
    public function willNotCreateNewCategoryWhenCategoryExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['category' => Str::random()]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessories = Accessory::query()
            ->whereIn('name', $importFileBuilder->pluck('itemName'))
            ->get();

        $this->assertCount(1, $newAccessories->pluck('category_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewAccessoryWhenAccessoryWithNameExists(): void
    {
        $accessory = AccessoryFactory::new()->create(['name' => Str::random()]);
        $importFileBuilder = ImportFileBuilder::times(2)->replace(['itemName' => $accessory->name]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $probablyNewAccessories = Accessory::query()
            ->where('name', $importFileBuilder->pluck('itemName'))
            ->get(['name']);

        $this->assertCount(1, $probablyNewAccessories);
        $this->assertEquals($probablyNewAccessories->first()->name, $accessory->name);
    }

    #[Test]
    public function willNotCreateNewCompanyWhenCompanyAlreadyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['companyName' => Str::random()]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessories = Accessory::query()
            ->where('name', $importFileBuilder->pluck('itemName'))
            ->get(['company_id']);

        $this->assertCount(1, $newAccessories->pluck('company_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewLocationWhenLocationAlreadyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['location' => Str::random()]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessories = Accessory::query()
            ->where('name', $importFileBuilder->pluck('itemName'))
            ->get(['location_id']);

        $this->assertCount(1, $newAccessories->pluck('location_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewManufacturerWhenManufacturerAlreadyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['manufacturerName' => $this->faker->company]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessories = Accessory::query()
            ->where('name', $importFileBuilder->pluck('itemName'))
            ->get(['manufacturer_id']);

        $this->assertCount(1, $newAccessories->pluck('manufacturer_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewSupplierWhenSupplierAlreadyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['supplierName' => $this->faker->company]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessories = Accessory::query()
            ->where('name', $importFileBuilder->pluck('itemName'))
            ->get(['supplier_id']);

        $this->assertCount(1, $newAccessories->pluck('supplier_id')->unique()->all());
    }

    #[Test]
    public function whenColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::new()->forget(['minimumAmount', 'purchaseCost', 'purchaseDate']);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAccessory = Accessory::query()
            ->where('name', $importFileBuilder->firstRow()['itemName'])
            ->sole();

        $this->assertNull($newAccessory->min_amt);
        $this->assertNull($newAccessory->purchase_date);
        $this->assertNull($newAccessory->purchase_cost);
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::new()->forget(['itemName', 'quantity', 'category']);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => null,
                'messages' => [
                    '' => [
                        'Accessory' => [
                            'name' => ['The name field is required.'],
                            'qty' => ['The qty field must be at least 1.'],
                            'category_id' => ['The category id field is required.']
                        ]
                    ]
                ]
            ]);
    }

    #[Test]
    public function updateAccessoryFromImport(): void
    {
        $accessory = AccessoryFactory::new()->create(['name' => Str::random()])->refresh();
        $importFileBuilder = ImportFileBuilder::new(['itemName' => $accessory->name]);
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedAccessory = Accessory::query()->find($accessory->id);
        $updatedAttributes = [
            'name', 'company_id', 'qty', 'purchase_date', 'purchase_cost',
            'order_number', 'notes', 'category_id', 'manufacturer_id', 'supplier_id',
            'location_id', 'model_number', 'updated_at'
        ];

        $this->assertEquals($updatedAccessory->name, $row['itemName']);
        $this->assertEquals($row['companyName'], $updatedAccessory->company->name);
        $this->assertEquals($updatedAccessory->qty, $row['quantity']);
        $this->assertEquals($updatedAccessory->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($updatedAccessory->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($updatedAccessory->order_number, $row['orderNumber']);
        $this->assertEquals($updatedAccessory->notes, $row['notes']);
        $this->assertEquals($updatedAccessory->category->name, $row['category']);
        $this->assertEquals($updatedAccessory->category->category_type, 'accessory');
        $this->assertEquals($updatedAccessory->manufacturer->name, $row['manufacturerName']);
        $this->assertEquals($updatedAccessory->supplier->name, $row['supplierName']);
        $this->assertEquals($updatedAccessory->location->name, $row['location']);
        $this->assertEquals($updatedAccessory->model_number, $row['modelNumber']);

        $this->assertEquals(
            Arr::except($updatedAccessory->attributesToArray(), $updatedAttributes),
            Arr::except($accessory->attributesToArray(), $updatedAttributes),
        );
    }

    #[Test]
    public function whenImportFileContainsEmptyValues(): void
    {
        $accessory = AccessoryFactory::new()->create(['name' => Str::random()]);
        $accessory->refresh();

        $importFileBuilder = ImportFileBuilder::new([
            'companyName'      => ' ',
            'purchaseDate'     => '  ',
            'purchaseCost'     => '',
            'location'         => '',
            'companyName'      => '',
            'orderNumber'      => '',
            'category'         => '',
            'quantity'         => '',
            'manufacturerName' => '',
            'supplierName'     => '',
            'notes'            => '',
            'requestAble'      => '',
            'minimumAmount'    => '',
            'modelNumber'      => ''
        ]);

        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => null,
                'messages' => [
                    $importFileBuilder->firstRow()['itemName'] => [
                        'Accessory' => [
                            'qty' => ['The qty field must be at least 1.'],
                            'category_id' => ['The category id field is required.']
                        ]
                    ]
                ]
            ]);

        $importFileBuilder->replace(['itemName' => $accessory->name]);

        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedAccessory = clone $accessory;
        $updatedAccessory->refresh();

        $this->assertEquals($updatedAccessory->toArray(), $accessory->toArray());
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::new()->definition();
        $row = [
            'itemName'         => $faker['modelNumber'],
            'purchaseDate'     => $faker['notes'],
            'purchaseCost'     => $faker['location'],
            'location'         => $faker['purchaseCost'],
            'companyName'      => $faker['orderNumber'],
            'orderNumber'      => $faker['companyName'],
            'category'         => $faker['manufacturerName'],
            'manufacturerName' => $faker['category'],
            'notes'            => $faker['purchaseDate'],
            'minimumAmount'    => $faker['supplierName'],
            'modelNumber'      => $faker['itemName'],
            'quantity'         => $faker['quantity']
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);
        $import = ImportFactory::new()->accessory()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Item Name'     => 'model_number',
                'Purchase Date' => 'notes',
                'Purchase Cost' => 'location',
                'Location'      => 'purchase_cost',
                'Company'       => 'order_number',
                'Order Number'  => 'company',
                'Category'      => 'manufacturer',
                'Manufacturer'  => 'category',
                'Supplier'      => 'min_amt',
                'Notes'         => 'purchase_date',
                'Min QTY'       => 'supplier',
                'Model Number'  => 'item_name',
                'Quantity'      => 'quantity'
            ]
        ])->assertOk();

        $newAccessory = Accessory::query()
            ->with(['location', 'category', 'manufacturer', 'supplier'])
            ->where('name', $row['modelNumber'])
            ->sole();

        $this->assertEquals($newAccessory->name, $row['modelNumber']);
        $this->assertEquals($newAccessory->model_number, $row['itemName']);
        $this->assertEquals($newAccessory->qty, $row['quantity']);
        $this->assertEquals($newAccessory->purchase_date->toDateString(), $row['notes']);
        $this->assertEquals($newAccessory->purchase_cost, $row['location']);
        $this->assertEquals($newAccessory->order_number, $row['companyName']);
        $this->assertEquals($newAccessory->notes, $row['purchaseDate']);
        $this->assertEquals($newAccessory->category->name, $row['manufacturerName']);
        $this->assertEquals($newAccessory->manufacturer->name, $row['category']);
        $this->assertEquals($newAccessory->location->name, $row['purchaseCost']);
    }
}
