<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAssetTest extends TestCase
{
    public function test_all_fields_are_saved()
    {
        Storage::fake('public');

        $user = User::factory()->createAssets()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();
        $defaultLocation = Location::factory()->create();
        $supplier = Supplier::factory()->create();
        $file = UploadedFile::fake()->image("test.jpg", 2000);


        $response = $this->actingAs($user)
            ->post(route('hardware.store'), [
                'redirect_option' => 'item',
                'name'            => 'Test Asset',
                'model_id'        => $model->id,
                'status_id'       => $status->id,
                // ugh, this is because for some reason asset tags and serials are expected to start at an index of [1], so throwing an empty in for [0]
                'asset_tags'      => ['', 'TEST-ASSET'],
                'serials'         => ['', 'TEST-SERIAL'],
                'notes'           => 'Test Notes',
                'rtd_location_id' => $defaultLocation->id,
                'requestable'     => true,
                'image'           => $file,
                'warranty_months' => 12,
                'next_audit_date' => Carbon::now()->addMonths(12)->format('Y-m-d'),
                'byod'            => true,
                'order_number'    => 'TEST-ORDER',
                'purchase_date'   => Carbon::now()->format('Y-m-d'),
                'asset_eol_date'  => Carbon::now()->addMonths(36)->format('Y-m-d'),
                'supplier_id'     => $supplier->id,
                'purchase_cost'   => 1234.56,
            ])->assertSessionHasNoErrors();

        $storedAsset = Asset::where('asset_tag', 'TEST-ASSET')->sole();

        $response->assertRedirect(route('hardware.show', $storedAsset));

        $this->assertDatabaseHas('assets', [
            'id'              => $storedAsset->id,
            'name'            => 'Test Asset',
            'model_id'        => $model->id,
            'status_id'       => $status->id,
            'asset_tag'       => 'TEST-ASSET',
            'serial'          => 'TEST-SERIAL',
            'notes'           => 'Test Notes',
            'rtd_location_id' => $defaultLocation->id,
            'requestable'     => 1,
            'image'           => $storedAsset->image,
            'warranty_months' => 12,
            'next_audit_date' => Carbon::now()->addMonths(12)->format('Y-m-d'),
            'byod'            => 1,
            'order_number'    => 'TEST-ORDER',
            'purchase_date'   => Carbon::now()->format('Y-m-d'),
            'asset_eol_date'  => Carbon::now()->addMonths(36)->format('Y-m-d'),
            'supplier_id'     => $supplier->id,
            'purchase_cost'   => 1234.56,
        ]);
    }

    public function test_multiple_assets_are_stored()
    {
        $user = User::factory()->createAssets()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();
        $defaultLocation = Location::factory()->create();
        $supplier = Supplier::factory()->create();
        $file = UploadedFile::fake()->image("test.jpg", 2000);

        $this->actingAs($user)->post(route('hardware.store'), [
            'redirect_option' => 'index',
            'name'            => 'Test Assets',
            'model_id'        => $model->id,
            'status_id'       => $status->id,
            'asset_tags'      => ['', 'TEST-ASSET-1', 'TEST-ASSET-2'],
            'serials'         => ['', 'TEST-SERIAL-1', 'TEST-SERIAL-2'],
            'notes'           => 'Test Notes',
            'rtd_location_id' => $defaultLocation->id,
            'requestable'     => true,
            'image'           => $file,
            'warranty_months' => 12,
            'next_audit_date' => Carbon::now()->addMonths(12)->format('Y-m-d'),
            'byod'            => true,
            'order_number'    => 'TEST-ORDER',
            'purchase_date'   => Carbon::now()->format('Y-m-d'),
            'asset_eol_date'  => Carbon::now()->addMonths(36)->format('Y-m-d'),
            'supplier_id'     => $supplier->id,
            'purchase_cost'   => 1234.56,
        ])->assertRedirect(route('hardware.index'))->assertSessionHasNoErrors();

        $storedAsset = Asset::where('asset_tag', 'TEST-ASSET-1')->sole();
        $storedAsset2 = Asset::where('asset_tag', 'TEST-ASSET-2')->sole();

        $commonData = [
            'name'            => 'Test Assets',
            'model_id'        => $model->id,
            'status_id'       => $status->id,
            'notes'           => 'Test Notes',
            'rtd_location_id' => $defaultLocation->id,
            'requestable'     => 1,
            'warranty_months' => 12,
            'next_audit_date' => Carbon::now()->addMonths(12)->format('Y-m-d'),
            'byod'            => 1,
            'order_number'    => 'TEST-ORDER',
            'purchase_date'   => Carbon::now()->format('Y-m-d'),
            'asset_eol_date'  => Carbon::now()->addMonths(36)->format('Y-m-d'),
            'supplier_id'     => $supplier->id,
            'purchase_cost'   => 1234.56,
        ];

        $this->assertDatabaseHas('assets', array_merge($commonData, ['asset_tag' => 'TEST-ASSET-1', 'serial' => 'TEST-SERIAL-1', 'image' => $storedAsset->image]));
        $this->assertDatabaseHas('assets', array_merge($commonData, ['asset_tag' => 'TEST-ASSET-2', 'serial' => 'TEST-SERIAL-2', 'image' => $storedAsset2->image]));
    }

    public function test_user_without_permission_denied()
    {
        $user = User::factory()->create();
        $model = AssetModel::factory()->create();
        $status = Statuslabel::factory()->readyToDeploy()->create();

        $this->actingAs($user)->post(route('hardware.store'), [
            'redirect_option' => 'index',
            'name'            => 'Test Assets',
            'model_id'        => $model->id,
            'status_id'       => $status->id,
            'asset_tags'      => ['', 'TEST-ASSET-1'],
            'serials'         => ['', 'TEST-SERIAL-1'],
        ])->assertForbidden();
    }
}