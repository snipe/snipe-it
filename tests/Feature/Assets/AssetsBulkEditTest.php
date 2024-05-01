<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class AssetsBulkEditTest extends TestCase
{
    public function testBulkEditAssetsAcceptsAllPossibleAttributes()
    {
        // sets up all needed models and attributes on the assets
        // this test does not deal with custom fields - will be dealt with in separate cases
        $status1 = Statuslabel::factory()->create();
        $status2 = Statuslabel::factory()->create();
        $model1 = AssetModel::factory()->create();
        $model2 = AssetModel::factory()->create();
        $supplier1 = Supplier::factory()->create();
        $supplier2 = Supplier::factory()->create();
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        $assets = Asset::factory()->count(10)->create([
            'purchase_date'    => '2023-01-01',
            'expected_checkin' => '2023-01-01',
            'status_id'        => $status1->id,
            'model_id'         => $model1->id,
            // skipping locations on this test, it deserves it's own test
            'purchase_cost'    => 1234.90,
            'supplier_id'      => $supplier1->id,
            'company_id'       => $company1->id,
            'order_number'     => '123456',
            'warranty_months'  => 24,
            'next_audit_date'  => '2024-06-01',
            'requestable'      => false
        ]);

        // gets the ids together to submit to the endpoint
        $id_array = $assets->pluck('id')->toArray();

        // submits the ids and new values for each attribute
        $this->actingAs(User::factory()->editAssets()->create())->post(route('hardware/bulksave'), [
            'ids'              => $id_array,
            'purchase_date'    => '2024-01-01',
            'expected_checkin' => '2024-01-01',
            'status_id'        => $status2->id,
            'model_id'         => $model2->id,
            'purchase_cost'    => 5678.92,
            'supplier_id'      => $supplier2->id,
            'company_id'       => $company2->id,
            'order_number'     => '7890',
            'warranty_months'  => 36,
            'next_audit_date'  => '2025-01-01',
            'requestable'      => true
        ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        // asserts that each asset has the updated values
        Asset::findMany($id_array)->each(function (Asset $asset) use ($status2, $model2, $supplier2, $company2) {
            $this->assertEquals('2024-01-01', $asset->purchase_date->format('Y-m-d'));
            $this->assertEquals('2024-01-01', $asset->expected_checkin->format('Y-m-d'));
            $this->assertEquals($status2->id, $asset->status_id);
            $this->assertEquals($model2->id, $asset->model_id);
            $this->assertEquals(5678.92, $asset->purchase_cost);
            $this->assertEquals($supplier2->id, $asset->supplier_id);
            $this->assertEquals($company2->id, $asset->company_id);
            $this->assertEquals(7890, $asset->order_number);
            $this->assertEquals(36, $asset->warranty_months);
            $this->assertEquals('2025-01-01', $asset->next_audit_date->format('Y-m-d'));
            // shouldn't requestable be cast as a boolean??? it's not.
            $this->assertEquals(1, $asset->requestable);
        });
    }

    public function testBulkEditAssetsAcceptsAndUpdatesUnencryptedCustomFields()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $mac_address = CustomField::factory()->macAddress()->create();
        $ram = CustomField::factory()->ram()->create();
        $cpu = CustomField::factory()->cpu()->create();

        $assets = Asset::factory()->count(10)->hasMultipleCustomFields([$mac_address, $ram, $cpu])->create([
            $ram->db_column => 8,
            $cpu->db_column => '2.1',
        ]);

        // seems like the fieldset is random, so bulkedit isn't working because assets don't have the "correct" fieldset
        // look into more tomorrow
        dd(Asset::find(1)->model->fieldset);

        $id_array = $assets->pluck('id')->toArray();

        $this->actingAs(User::factory()->editAssets()->create())->post(route('hardware/bulksave'), [
            'ids'           => $id_array,
            $ram->db_column => 16,
            $cpu->db_column => '4.1',
        ]);

        Asset::findMany($id_array)->each(function (Asset $asset) use ($ram, $cpu, $mac_address) {
            $this->assertEquals(16, $asset->{$ram->db_column});
            $this->assertEquals('4.1', $asset->{$ram->db_column});
        });
    }
}
