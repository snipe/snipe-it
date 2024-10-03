<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActivityLog;
use App\Models\License;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use Database\Factories\LicenseFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\LicensesImportFileBuilder as ImportFileBuilder;

class ImportLicenseTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'license';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportLicenses(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAssetsPermissionCanImportLicenses(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->license()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importLicenses(): void
    {
        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => ['redirect_url' => route('licenses.index')]
            ]);

        $newLicense = License::query()
            ->withCasts(['reassignable' => 'bool'])
            ->with(['category', 'company', 'manufacturer', 'supplier'])
            ->where('serial', $row['serialNumber'])
            ->sole();

        $activityLogs = ActivityLog::query()
            ->where('item_type', License::class)
            ->where('item_id', $newLicense->id)
            ->get();

        $this->assertCount(2, $activityLogs);

        $this->assertEquals($newLicense->name, $row['licenseName']);
        $this->assertEquals($newLicense->serial, $row['serialNumber']);
        $this->assertEquals($newLicense->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($newLicense->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($newLicense->order_number, $row['orderNumber']);
        $this->assertEquals($newLicense->seats, $row['seats']);
        $this->assertEquals($newLicense->notes, $row['notes']);
        $this->assertEquals($newLicense->license_name, $row['licensedToName']);
        $this->assertEquals($newLicense->license_email, $row['licensedToEmail']);
        $this->assertEquals($newLicense->supplier->name, $row['supplierName']);
        $this->assertEquals($newLicense->company->name, $row['companyName']);
        $this->assertEquals($newLicense->category->name, $row['category']);
        $this->assertEquals($newLicense->expiration_date->toDateString(), $row['expirationDate']);
        $this->assertEquals($newLicense->maintained, $row['isMaintained'] === 'TRUE');
        $this->assertEquals($newLicense->reassignable, $row['isReassignAble'] === 'TRUE');
        $this->assertEquals($newLicense->purchase_order, '');
        $this->assertNull($newLicense->depreciation_id);
        $this->assertNull($newLicense->termination_date);
        $this->assertNull($newLicense->deprecate);
        $this->assertNull($newLicense->min_amt);
    }

    #[Test]
    public function willIgnoreUnknownColumnsWhenFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willNotCreateNewLicenseWhenNameAndSerialNumberAlreadyExist(): void
    {
        $license = LicenseFactory::new()->create();

        $importFileBuilder = ImportFileBuilder::times(4)->replace([
            'itemName'     => $license->name,
            'serialNumber' => $license->serial
        ]);

        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $probablyNewLicenses = License::query()
            ->where('name', $license->name)
            ->where('serial', $license->serial)
            ->get();

        $this->assertCount(1, $probablyNewLicenses);
    }

    #[Test]
    public function formatAttributes(): void
    {
        $importFileBuilder = ImportFileBuilder::new([
            'expirationDate' => '2022/10/10'
        ]);

        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newLicense = License::query()
            ->where('serial', $importFileBuilder->firstRow()['serialNumber'])
            ->sole();

        $this->assertEquals($newLicense->expiration_date->toDateString(), '2022-10-10');
    }

    #[Test]
    public function willNotCreateNewCompanyWhenCompanyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['companyName' => Str::random()]);
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newLicenses = License::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['company_id']);

        $this->assertCount(1, $newLicenses->pluck('company_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewManufacturerWhenManufacturerExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['manufacturerName' => Str::random()]);
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newLicenses = License::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['manufacturer_id']);

        $this->assertCount(1, $newLicenses->pluck('manufacturer_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewCategoryWhenCategoryExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['category' => $this->faker->company]);
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newLicenses = License::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['category_id']);

        $this->assertCount(1, $newLicenses->pluck('category_id')->unique()->all());
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::times()
            ->replace(['name' => ''])
            ->forget(['seats']);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status'   => 'import-errors',
                'payload'  => null,
                'messages' => [
                    $row['licenseName'] => [
                        "License \"{$row['licenseName']}\"" => [
                            'seats' => ['The seats field is required.'],
                        ]
                    ]
                ]
            ]);

        $newLicenses = License::query()
            ->where('serial', $row['serialNumber'])
            ->get();

        $this->assertCount(0, $newLicenses);
    }

    #[Test]
    public function updateLicenseFromImport(): void
    {
        $license = LicenseFactory::new()->create();
        $importFileBuilder = ImportFileBuilder::new([
            'licenseName'  => $license->name,
            'serialNumber' => $license->serial
        ]);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedLicense = License::query()
            ->with(['manufacturer', 'category', 'supplier'])
            ->where('serial', $row['serialNumber'])
            ->sole();

        $this->assertEquals($updatedLicense->name, $row['licenseName']);
        $this->assertEquals($updatedLicense->serial, $row['serialNumber']);
        $this->assertEquals($updatedLicense->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($updatedLicense->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($updatedLicense->order_number, $row['orderNumber']);
        $this->assertEquals($updatedLicense->seats, $row['seats']);
        $this->assertEquals($updatedLicense->notes, $row['notes']);
        $this->assertEquals($updatedLicense->license_name, $row['licensedToName']);
        $this->assertEquals($updatedLicense->license_email, $row['licensedToEmail']);
        $this->assertEquals($updatedLicense->supplier->name, $row['supplierName']);
        $this->assertEquals($updatedLicense->company->name, $row['companyName']);
        $this->assertEquals($updatedLicense->category->name, $row['category']);
        $this->assertEquals($updatedLicense->expiration_date->toDateString(), $row['expirationDate']);
        $this->assertEquals($updatedLicense->maintained, $row['isMaintained'] === 'TRUE');
        $this->assertEquals($updatedLicense->reassignable, $row['isReassignAble'] === 'TRUE');
        $this->assertEquals($updatedLicense->purchase_order, $license->purchase_order);
        $this->assertEquals($updatedLicense->depreciation_id, $license->depreciation_id);
        $this->assertEquals($updatedLicense->termination_date, $license->termination_date);
        $this->assertEquals($updatedLicense->deprecate, $license->deprecate);
        $this->assertEquals($updatedLicense->min_amt, $license->min_amt);
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::times()->definition();
        $row = [
            'category'         => $faker['supplierName'],
            'companyName'      => $faker['serialNumber'],
            'expirationDate'   => $faker['seats'],
            'isMaintained'     => $faker['purchaseDate'],
            'isReassignAble'   => $faker['purchaseCost'],
            'licensedToName'   => $faker['orderNumber'],
            'licensedToEmail'  => $faker['notes'],
            'licenseName'      => $faker['licenseName'],
            'manufacturerName' => $faker['category'],
            'notes'            => $faker['companyName'],
            'orderNumber'      => $faker['expirationDate'],
            'purchaseCost'     => $faker['isMaintained'],
            'purchaseDate'     => $faker['isReassignAble'],
            'seats'            => $faker['licensedToName'],
            'serialNumber'     => $faker['licensedToEmail'],
            'supplierName'     => $faker['manufacturerName']
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);
        $import = ImportFactory::new()->license()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Category'         => 'supplier',
                'Company'          => 'serial',
                'expiration date'  => 'seats',
                'maintained'       => 'purchase_date',
                'reassignable'     => 'purchase_cost',
                'Licensed To Name' => 'order_number',
                'Licensed To Email' => 'notes',
                'licenseName'      => 'name',
                'manufacturer'     => 'category',
                'Notes'            => 'company',
                'Serial number'    => 'license_email',
                'Order Number'     => 'expiration_date',
                'purchase Cost'    => 'maintained',
                'purchase Date'    => 'reassignable',
                'seats'            => 'license_name',
                'supplier'         => 'manufacturer'
            ]
        ])->assertOk();

        $newLicense = License::query()
            ->with(['category', 'company', 'manufacturer', 'supplier'])
            ->where('serial', $row['companyName'])
            ->sole();

        $this->assertEquals($newLicense->name, $row['licenseName']);
        $this->assertEquals($newLicense->serial, $row['companyName']);
        $this->assertEquals($newLicense->purchase_date->toDateString(), $row['isMaintained']);
        $this->assertEquals($newLicense->purchase_cost, $row['isReassignAble']);
        $this->assertEquals($newLicense->order_number, $row['licensedToName']);
        $this->assertEquals($newLicense->seats, $row['expirationDate']);
        $this->assertEquals($newLicense->notes, $row['licensedToEmail']);
        $this->assertEquals($newLicense->license_name, $row['seats']);
        $this->assertEquals($newLicense->license_email, $row['serialNumber']);
        $this->assertEquals($newLicense->supplier->name, $row['category']);
        $this->assertEquals($newLicense->company->name, $row['notes']);
        $this->assertEquals($newLicense->category->name, $row['manufacturerName']);
        $this->assertEquals($newLicense->expiration_date->toDateString(), $row['orderNumber']);
        $this->assertEquals($newLicense->maintained, $row['purchaseCost'] === 'TRUE');
        $this->assertEquals($newLicense->reassignable, $row['purchaseDate'] === 'TRUE');
        $this->assertEquals($newLicense->purchase_order, '');
        $this->assertNull($newLicense->depreciation_id);
        $this->assertNull($newLicense->termination_date);
        $this->assertNull($newLicense->deprecate);
        $this->assertNull($newLicense->min_amt);
    }
}
