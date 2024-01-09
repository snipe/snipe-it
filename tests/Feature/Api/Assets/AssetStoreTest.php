<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetStoreTest extends TestCase
{
    use InteractsWithSettings;

    public function testRequiresPermissionToCreateAsset()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.assets.store'))
            ->assertForbidden();
    }

    public function testAllAssetAttributesAreStored()
    {
        $company = Company::factory()->create();
        $location = Location::factory()->create();
        $model = AssetModel::factory()->create();
        $rtdLocation = Location::factory()->create();
        $status = Statuslabel::factory()->create();
        $supplier = Supplier::factory()->create();
        $user = User::factory()->createAssets()->create();
        $userAssigned = User::factory()->create();

        $response = $this->actingAsForApi($user)
            ->postJson(route('api.assets.store'), [
                'asset_eol_date' => '2024-06-02',
                'asset_tag' => 'random_string',
                'assigned_user' => $userAssigned->id,
                'company_id' => $company->id,
                'last_audit_date' => '2023-09-03',
                'location_id' => $location->id,
                'model_id' => $model->id,
                'name' => 'A New Asset',
                'notes' => 'Some notes',
                'order_number' => '5678',
                'purchase_cost' => '123.45',
                'purchase_date' => '2023-09-02',
                'requestable' => true,
                'rtd_location_id' => $rtdLocation->id,
                'serial' => '1234567890',
                'status_id' => $status->id,
                'supplier_id' => $supplier->id,
                'warranty_months' => 10,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);

        $this->assertTrue($asset->adminuser->is($user));

        $this->assertEquals('2024-06-02', $asset->asset_eol_date);
        $this->assertEquals('random_string', $asset->asset_tag);
        $this->assertEquals($userAssigned->id, $asset->assigned_to);
        $this->assertTrue($asset->company->is($company));
        // I don't see this on the GUI side either, but it's in the docs so I'm guessing that's a mistake? It wasn't in the controller.
        // $this->assertEquals('2023-09-03', $asset->last_audit_date);
        $this->assertTrue($asset->location->is($location));
        $this->assertTrue($asset->model->is($model));
        $this->assertEquals('A New Asset', $asset->name);
        $this->assertEquals('Some notes', $asset->notes);
        $this->assertEquals('5678', $asset->order_number);
        $this->assertEquals('123.45', $asset->purchase_cost);
        $this->assertTrue($asset->purchase_date->is('2023-09-02'));
        $this->assertEquals('1', $asset->requestable);
        $this->assertTrue($asset->defaultLoc->is($rtdLocation));
        $this->assertEquals('1234567890', $asset->serial);
        $this->assertTrue($asset->assetstatus->is($status));
        $this->assertTrue($asset->supplier->is($supplier));
        $this->assertEquals(10, $asset->warranty_months);
    }

    public function testArchivedDepreciateAndPhysicalCanBeNull()
    {
        $model = AssetModel::factory()->ipadModel()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'archive' => null,
                'depreciate' => null,
                'physical' => null
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertEquals(0, $asset->archived);
        $this->assertEquals(1, $asset->physical);
        $this->assertEquals(0, $asset->depreciate);
    }

    public function testArchivedDepreciateAndPhysicalCanBeEmpty()
    {
        $model = AssetModel::factory()->ipadModel()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'archive' => '',
                'depreciate' => '',
                'physical' => ''
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertEquals(0, $asset->archived);
        $this->assertEquals(1, $asset->physical);
        $this->assertEquals(0, $asset->depreciate);
    }

    public function testAssetEolDateIsCalculatedIfPurchaseDateSet()
    {
        $model = AssetModel::factory()->mbp13Model()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'purchase_date' => '2021-01-01',
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertEquals('2024-01-01', $asset->asset_eol_date);
    }

    public function testAssetEolDateIsNotCalculatedIfPurchaseDateNotSet()
    {
        $model = AssetModel::factory()->mbp13Model()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertNull($asset->asset_eol_date);
    }

    public function testAssetEolExplicitIsSetIfAssetEolDateIsExplicitlySet()
    {
        $model = AssetModel::factory()->mbp13Model()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'asset_eol_date' => '2025-01-01',
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertEquals('2025-01-01', $asset->asset_eol_date);
        $this->assertTrue($asset->eol_explicit);
    }

    public function testAssetGetsAssetTagWithAutoIncrement()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);
        $this->assertNotNull($asset->asset_tag);
    }

    public function testAssetCreationFailsWithNoAssetTagOrAutoIncrement()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();

        $this->settings->disableAutoIncrement();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testUniqueSerialNumbersIsEnforcedWhenEnabled()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $serial = '1234567890';

        $this->settings->enableAutoIncrement();
        $this->settings->enableUniqueSerialNumbers();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'serial' => $serial,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'serial' => $serial,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testUniqueSerialNumbersIsNotEnforcedWhenDisabled()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $serial = '1234567890';

        $this->settings->enableAutoIncrement();
        $this->settings->disableUniqueSerialNumbers();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'serial' => $serial,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'model_id' => $model->id,
                'status_id' => $status->id,
                'serial' => $serial,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');
    }

    public function testAssetTagsMustBeUniqueWhenUndeleted()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $asset_tag = '1234567890';

        $this->settings->disableAutoIncrement();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'asset_tag' => $asset_tag,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'asset_tag' => $asset_tag,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testAssetTagsCanBeDuplicatedIfDeleted()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $asset_tag = '1234567890';

        $this->settings->disableAutoIncrement();

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'asset_tag' => $asset_tag,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

       Asset::find($response['payload']['id'])->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.assets.store'), [
                'asset_tag' => $asset_tag,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');
    }

    public function testAnAssetCanBeCheckedOutToUserOnStore()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $user = User::factory()->createAssets()->create();
        $userAssigned = User::factory()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi($user)
            ->postJson(route('api.assets.store'), [
                'assigned_user' => $userAssigned->id,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);

        $this->assertTrue($asset->adminuser->is($user));
        $this->assertTrue($asset->checkedOutToUser());
        $this->assertTrue($asset->assignedTo->is($userAssigned));
    }

    public function testAnAssetCanBeCheckedOutToLocationOnStore()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $location = Location::factory()->create();
        $user = User::factory()->createAssets()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi($user)
            ->postJson(route('api.assets.store'), [
                'assigned_location' => $location->id,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset = Asset::find($response['payload']['id']);

        $this->assertTrue($asset->adminuser->is($user));
        $this->assertTrue($asset->checkedOutToLocation());
        $this->assertTrue($asset->location->is($location));
    }

    public function testAnAssetCanBeCheckedOutToAssetOnStore()
    {
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->create();
        $asset = Asset::factory()->create();
        $user = User::factory()->createAssets()->create();

        $this->settings->enableAutoIncrement();

        $response = $this->actingAsForApi($user)
            ->postJson(route('api.assets.store'), [
                'assigned_asset' => $asset->id,
                'model_id' => $model->id,
                'status_id' => $status->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $apiAsset = Asset::find($response['payload']['id']);

        $this->assertTrue($apiAsset->adminuser->is($user));
        $this->assertTrue($apiAsset->checkedOutToAsset());
        // I think this makes sense, but open to a sanity check
        $this->assertTrue($asset->assignedAssets()->find($response['payload']['id'])->is($apiAsset));
    }

    public function testCompanyIdNeedsToBeInteger()
    {
        $this->actingAsForApi(User::factory()->createAssets()->create())
            ->postJson(route('api.assets.store'), [
                'company_id' => [1],
            ])
            ->assertStatusMessageIs('error')
            ->assertJson(function (AssertableJson $json) {
                $json->has('messages.company_id')->etc();
            });
    }
}
