<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Actionlog as ActionLog;
use App\Models\Asset;
use App\Models\CustomField;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Carbon\Carbon;
use Database\Factories\AssetFactory;
use Database\Factories\CustomFieldFactory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\AssetsImportFileBuilder as ImportFileBuilder;

class ImportAssetsTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'asset';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportAssets(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAssetsPermissionCanImportAssets(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->asset()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importAsset(): void
    {
        Notification::fake();

        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => ['redirect_url' => route('hardware.index')]
            ]);

        $newAsset = Asset::query()
            ->with(['location', 'supplier', 'company', 'assignedAssets', 'defaultLoc', 'assetStatus', 'model.category', 'model.manufacturer'])
            ->where('serial', $row['serialNumber'])
            ->sole();

        $assignee = User::query()->find($newAsset->assigned_to, ['id', 'first_name', 'last_name', 'email', 'username']);

        $activityLogs = ActionLog::query()
            ->where('item_type', Asset::class)
            ->where('item_id', $newAsset->id)
            ->get();

        $this->assertCount(2, $activityLogs);

        $this->assertEquals($activityLogs[0]->action_type, 'checkout');
        $this->assertEquals($activityLogs[0]->item_type, Asset::class);
        $this->assertEquals($activityLogs[0]->target_id, $assignee->id);
        $this->assertEquals($activityLogs[0]->target_type, User::class);
        $this->assertEquals($activityLogs[0]->note, 'Checkout from CSV Importer');

        $this->assertEquals($activityLogs[1]->action_type, 'create');
        $this->assertNull($activityLogs[1]->target_id);
        $this->assertEquals($activityLogs[1]->item_type, Asset::class);
        $this->assertNull($activityLogs[1]->note);
        $this->assertNull($activityLogs[1]->target_type);

        $this->assertEquals("{$assignee->first_name} {$assignee->last_name}", $row['assigneeFullName']);
        $this->assertEquals($assignee->email, $row['assigneeEmail']);
        $this->assertEquals($assignee->username, $row['assigneeUsername']);

        $this->assertEquals($newAsset->model->category->name, $row['category']);
        $this->assertEquals($newAsset->model->manufacturer->name, $row['manufacturerName']);
        $this->assertEquals($newAsset->name, $row['itemName']);
        $this->assertEquals($newAsset->asset_tag, $row['tag']);
        $this->assertEquals($newAsset->model->name, $row['model']);
        $this->assertEquals($newAsset->model->model_number, $row['modelNumber']);
        $this->assertEquals($newAsset->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertNull($newAsset->asset_eol_date);
        $this->assertEquals(0, $newAsset->eol_explicit);
        $this->assertEquals($newAsset->location_id, $newAsset->rtd_location_id);
        $this->assertEquals($newAsset->purchase_cost, $row['purchaseCost']);
        $this->assertNull($newAsset->order_number);
        $this->assertEquals($newAsset->image, '');
        $this->assertNull($newAsset->user_id);
        $this->assertEquals($newAsset->physical, 1);
        $this->assertEquals($newAsset->assetStatus->name, $row['status']);
        $this->assertEquals($newAsset->archived, 0);
        $this->assertEquals($newAsset->warranty_months, $row['warrantyInMonths']);
        $this->assertNull($newAsset->deprecate);
        $this->assertEquals($newAsset->supplier->name, $row['supplierName']);
        $this->assertEquals($newAsset->requestable, 0);
        $this->assertEquals($newAsset->defaultLoc->name, $row['location']);
        $this->assertEquals($newAsset->accepted, null);
        $this->assertEquals(Carbon::parse($newAsset->last_checkout)->toDateString(), now()->toDateString());
        $this->assertEquals($newAsset->last_checkin, 0);
        $this->assertEquals($newAsset->expected_checkin, 0);
        $this->assertEquals($newAsset->company->name, $row['companyName']);
        $this->assertEquals($newAsset->assigned_type, User::class);
        $this->assertNull($newAsset->last_audit_date);
        $this->assertNull($newAsset->next_audit_date);
        $this->assertEquals($newAsset->location->name, $row['location']);
        $this->assertEquals($newAsset->checkin_counter, 0);
        $this->assertEquals($newAsset->checkout_counter, 1);
        $this->assertEquals($newAsset->requests_counter, 0);
        $this->assertEquals($newAsset->byod, 0);

        //Notes is never read.
        //$this->assertEquals($asset->notes, $row['notes']);

        Notification::assertSentTo($assignee, CheckoutAssetNotification::class);
    }

    #[Test]
    public function willIgnoreUnknownColumnsWhenFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willNotCreateNewAssetWhenAssetWithSameTagAlreadyExists(): void
    {
        $asset = AssetFactory::new()->create(['asset_tag' => $this->faker->uuid]);
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['tag' => $asset->asset_tag]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status' => 'import-errors',
                'payload' => null,
                'messages' => [
                    '' => [
                        'asset_tag' => [
                            'asset_tag' => [
                                "An asset with the asset tag {$asset->asset_tag} already exists and an update was not requested. No change was made."
                            ]
                        ]
                    ]
                ]
            ]);

        $assetsWithSameTag = Asset::query()->where('asset_tag', $asset->asset_tag)->get();

        $this->assertCount(1, $assetsWithSameTag);
    }

    #[Test]
    public function willNotCreateNewCompanyWhenCompanyExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['companyName' => Str::random()]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(1, $newAssets->pluck('company_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewLocationWhenLocationExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['location' => Str::random()]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(1, $newAssets->pluck('location_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewSupplierWhenSupplierExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['supplierName' => $this->faker->company]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get(['supplier_id']);

        $this->assertCount(1, $newAssets->pluck('supplier_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewManufacturerWhenManufacturerExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['manufacturerName' => $this->faker->company]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->with('model.manufacturer')
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(1, $newAssets->pluck('model.manufacturer_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateCategoryWhenCategoryExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['category' => $this->faker->company]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->with('model.category')
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(1, $newAssets->pluck('model.category_id')->unique()->all());
    }

    #[Test]
    public function willNotCreateNewAssetModelWhenAssetModelExists(): void
    {
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['model' => Str::random()]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAssets = Asset::query()
            ->with('model')
            ->whereIn('serial', $importFileBuilder->pluck('serialNumber'))
            ->get();

        $this->assertCount(1, $newAssets->pluck('model.name')->unique()->all());
    }

    #[Test]
    public function whenColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::times()->forget([
            'purchaseCost',
            'purchaseDate',
            'status'
        ]);

        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAsset = Asset::query()
            ->with(['assetStatus'])
            ->where('serial', $importFileBuilder->firstRow()['serialNumber'])
            ->sole();

        $this->assertEquals($newAsset->assetStatus->name, 'Ready to Deploy');
        $this->assertNull($newAsset->purchase_date);
        $this->assertNull($newAsset->purchase_cost);
    }

    #[Test]
    public function willFormatValues(): void
    {
        $importFileBuilder = ImportFileBuilder::new([
            'warrantyInMonths' => '3 months',
            'purchaseDate'    => '2022/10/10'
        ]);

        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAsset = Asset::query()
            ->where('serial', $importFileBuilder->firstRow()['serialNumber'])
            ->sole();

        $this->assertEquals($newAsset->warranty_months, 3);
        $this->assertEquals($newAsset->purchase_date->toDateString(), '2022-10-10');
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::times(2)
            ->forget(['tag'])
            ->replace(['model' => '']);

        $rows = $importFileBuilder->all();
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertJson([
                'status' => 'import-errors',
                'payload' => null,
                'messages' => [
                    $rows[0]['itemName'] => [
                        "Asset \"{$rows[0]['itemName']}\"" => [
                            'asset_tag' => [
                                'The asset tag field must be at least 1 characters.',
                            ],
                            'model_id' => [
                                'The model id field is required.'
                            ]
                        ]
                    ],
                    $rows[1]['itemName'] => [
                        "Asset \"{$rows[1]['itemName']}\"" => [
                            'asset_tag' => [
                                'The asset tag field must be at least 1 characters.',
                            ],
                            'model_id' => [
                                'The model id field is required.'
                            ]
                        ]
                    ]
                ]
            ]);

        $newAssets = Asset::query()
            ->whereIn('serial', Arr::pluck($rows, 'serialNumber'))
            ->get();

        $this->assertCount(0, $newAssets);
    }

    #[Test]
    public function updateAssetFromImport(): void
    {
        $asset = AssetFactory::new()->create()->refresh();
        $importFileBuilder = ImportFileBuilder::times(1)->replace(['tag' => $asset->asset_tag]);
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedAsset = Asset::query()
            ->with(['location', 'supplier', 'company', 'defaultLoc', 'assetStatus', 'model.category', 'model.manufacturer'])
            ->find($asset->id);

        $assignee = User::query()->find($updatedAsset->assigned_to, ['id', 'first_name', 'last_name', 'email', 'username']);

        $updatedAttributes = [
            'category', 'manufacturer_id', 'name', 'tag', 'model_id',
            'model_number', 'purchase_date', 'purchase_cost', 'warranty_months', 'supplier_id',
            'location_id', 'company_id', 'serial', 'assigned_to', 'status_id', 'rtd_location_id',
            'last_checkout', 'requestable', 'updated_at', 'checkout_counter', 'assigned_type'
        ];

        $this->assertEquals("{$assignee->first_name} {$assignee->last_name}", $row['assigneeFullName']);
        $this->assertEquals($assignee->email, $row['assigneeEmail']);
        $this->assertEquals($assignee->username, $row['assigneeUsername']);

        $this->assertEquals($updatedAsset->model->category->name, $row['category']);
        $this->assertEquals($updatedAsset->model->manufacturer->name, $row['manufacturerName']);
        $this->assertEquals($updatedAsset->name, $row['itemName']);
        $this->assertEquals($updatedAsset->asset_tag, $row['tag']);
        $this->assertEquals($updatedAsset->model->name, $row['model']);
        $this->assertEquals($updatedAsset->model->model_number, $row['modelNumber']);
        $this->assertEquals($updatedAsset->purchase_date->toDateString(), $row['purchaseDate']);
        $this->assertEquals($updatedAsset->purchase_cost, $row['purchaseCost']);
        $this->assertEquals($updatedAsset->assetStatus->name, $row['status']);
        $this->assertEquals($updatedAsset->warranty_months, $row['warrantyInMonths']);
        $this->assertEquals($updatedAsset->supplier->name, $row['supplierName']);
        $this->assertEquals($updatedAsset->defaultLoc->name, $row['location']);
        $this->assertEquals($updatedAsset->company->name, $row['companyName']);
        $this->assertEquals($updatedAsset->location->name, $row['location']);
        $this->assertEquals($updatedAsset->checkout_counter, 1);
        $this->assertEquals($updatedAsset->assigned_type, user::class);

        //RequestAble is always updated regardless of initial value.
        //$this->assertEquals($updatedAsset->requestable, $asset->requestable);

        $this->assertEquals(
            Arr::except($updatedAsset->attributesToArray(), $updatedAttributes),
            Arr::except($asset->attributesToArray(), $updatedAttributes),
        );
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::new()->definition();
        $row = [
            'assigneeFullName'    => $faker['supplierName'],
            'assigneeEmail'       => $faker['manufacturerName'],
            'assigneeUsername'    => $faker['serialNumber'],
            'category'            => $faker['location'],
            'companyName'         => $faker['purchaseCost'],
            'itemName'            => $faker['modelNumber'],
            'location'            => $faker['assigneeUsername'],
            'manufacturerName'    => $faker['status'],
            'model'               => $faker['itemName'],
            'modelNumber'         => $faker['category'],
            'notes'               => $faker['notes'],
            'purchaseCost'        => $faker['model'],
            'purchaseDate'        => $faker['companyName'],
            'serialNumber'        => $faker['tag'],
            'supplierName'        => $faker['purchaseDate'],
            'status'              => $faker['warrantyInMonths'],
            'tag'                 => $faker['assigneeEmail'],
            'warrantyInMonths'    => $faker['assigneeFullName'],
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);
        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Asset Tag'     => 'email',
                'Category'      => 'location',
                'Company'       => 'purchase_cost',
                'Email'         => 'manufacturer',
                'Full Name'     => 'supplier',
                'Item Name'     => 'model_number',
                'Location'      => 'username',
                'Manufacturer'  => 'status',
                'Model name'    => 'item_name',
                'Model Number'  => 'category',
                'Notes'         => 'asset_notes',
                'Purchase Cost' => 'asset_model',
                'Purchase Date' => 'company',
                'Serial number' => 'asset_tag',
                'Status'        => 'warranty_months',
                'Supplier'      => 'purchase_date',
                'Username'      => 'serial',
                'Warranty'      => 'full_name',
            ]
        ])->assertOk();

        $asset = Asset::query()
            ->with(['location', 'supplier', 'company', 'assignedAssets', 'defaultLoc', 'assetStatus', 'model.category', 'model.manufacturer'])
            ->where('serial', $row['assigneeUsername'])
            ->sole();

        $assignee = User::query()->find($asset->assigned_to, ['id', 'first_name', 'last_name', 'email', 'username']);

        $this->assertEquals("{$assignee->first_name} {$assignee->last_name}", $row['warrantyInMonths']);
        $this->assertEquals($assignee->email, $row['tag']);
        $this->assertEquals($assignee->username, $row['location']);

        $this->assertEquals($asset->model->category->name, $row['modelNumber']);
        $this->assertEquals($asset->model->manufacturer->name, $row['assigneeEmail']);
        $this->assertEquals($asset->name, $row['model']);
        $this->assertEquals($asset->asset_tag, $row['serialNumber']);
        $this->assertEquals($asset->model->name, $row['purchaseCost']);
        $this->assertEquals($asset->model->model_number, $row['itemName']);
        $this->assertEquals($asset->purchase_date->toDateString(), $row['supplierName']);
        $this->assertEquals($asset->purchase_cost, $row['companyName']);
        $this->assertEquals($asset->assetStatus->name, $row['manufacturerName']);
        $this->assertEquals($asset->warranty_months, $row['status']);
        $this->assertEquals($asset->supplier->name, $row['assigneeFullName']);
        $this->assertEquals($asset->defaultLoc->name, $row['category']);
        $this->assertEquals($asset->company->name, $row['purchaseDate']);
        $this->assertEquals($asset->location->name, $row['category']);
        $this->assertEquals($asset->notes, $row['notes']);
        $this->assertNull($asset->asset_eol_date);
        $this->assertEquals(0, $asset->eol_explicit);
        $this->assertNull($asset->order_number);
        $this->assertEquals($asset->image, '');
        $this->assertNull($asset->user_id);
        $this->assertEquals($asset->physical, 1);
        $this->assertEquals($asset->archived, 0);
        $this->assertNull($asset->deprecate);
        $this->assertEquals($asset->requestable, 0);
        $this->assertEquals($asset->accepted, null);
        $this->assertEquals(Carbon::parse($asset->last_checkout)->toDateString(), now()->toDateString());
        $this->assertEquals($asset->last_checkin, 0);
        $this->assertEquals($asset->expected_checkin, 0);
        $this->assertEquals($asset->assigned_type, User::class);
        $this->assertNull($asset->last_audit_date);
        $this->assertNull($asset->next_audit_date);
        $this->assertEquals($asset->checkin_counter, 0);
        $this->assertEquals($asset->checkout_counter, 1);
        $this->assertEquals($asset->requests_counter, 0);
        $this->assertEquals($asset->byod, 0);
    }

    #[Test]
    public function customFields(): void
    {
        $macAddress = $this->faker->macAddress;

        $row = ImportFileBuilder::new()->definition();
        $row['Mac Address'] = $macAddress;

        $importFileBuilder = new ImportFileBuilder([$row]);
        $customField = CustomField::query()->where('name', 'Mac Address')->firstOrNew();

        if (!$customField->exists) {
            $customField = CustomFieldFactory::new()->macAddress()->create(['db_column' => '_snipeit_mac_address_1']);
        }

        if ($customField->field_encrypted) {
            $customField->field_encrypted = 0;
            $customField->save();
        }

        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newAsset = Asset::query()->where('serial', $importFileBuilder->firstRow()['serialNumber'])->sole();

        $this->assertEquals($newAsset->getAttribute($customField->db_column), $macAddress);
    }

    #[Test]
    public function willEncryptCustomFields(): void
    {
        $macAddress = $this->faker->macAddress;
        $row = ImportFileBuilder::new()->definition();

        $row['Mac Address'] = $macAddress;

        $importFileBuilder = new ImportFileBuilder([$row]);
        $customField = CustomField::query()->where('name', 'Mac Address')->firstOrNew();

        if (!$customField->exists) {
            $customField = CustomFieldFactory::new()->macAddress()->create();
        }

        if (!$customField->field_encrypted) {
            $customField->field_encrypted = 1;
            $customField->save();
        }

        $import = ImportFactory::new()->asset()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $asset = Asset::query()->where('serial', $importFileBuilder->firstRow()['serialNumber'])->sole();
        $encryptedMacAddress = $asset->getAttribute($customField->db_column);

        $this->assertNotEquals($encryptedMacAddress, $macAddress);
    }
}
