<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\AssetModel;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Tests\TestCase;

class ManufacturerAutoCreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Statuslabel::factory()->rtd()->create();
    }

    public function test_new_model_gets_the_records_manufacturer()
    {
        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-ABC123',
            hardwareModel: 'MacBook Pro',
            manufacturer: 'Apple',
        ));

        $model = AssetModel::where('name', 'MacBook Pro')->first();
        $this->assertNotNull($model);
        $this->assertNotNull($model->manufacturer_id);
        $this->assertSame('Apple', $model->manufacturer->name);
    }

    public function test_existing_manufacturer_is_reused_not_duplicated()
    {
        // Case-insensitive matching on MySQL's default collation
        // handles casing differences in production. The test DB
        // is SQLite (BINARY collation by default), so this pins
        // the same-case reuse case.
        $existing = Manufacturer::factory()->create(['name' => 'Apple']);

        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-ABC123',
            hardwareModel: 'MacBook Pro',
            manufacturer: 'Apple',
        ));

        $this->assertSame(1, Manufacturer::where('name', 'Apple')->count(), 'Existing manufacturer should be reused, not duplicated.');

        $model = AssetModel::where('name', 'MacBook Pro')->first();
        $this->assertSame($existing->id, $model->manufacturer_id);
    }

    public function test_no_manufacturer_on_record_leaves_manufacturer_id_null()
    {
        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-ABC123',
            hardwareModel: 'MacBook Pro',
            manufacturer: null,
        ));

        $model = AssetModel::where('name', 'MacBook Pro')->first();
        $this->assertNotNull($model);
        $this->assertNull($model->manufacturer_id);
    }

    public function test_blank_manufacturer_string_leaves_manufacturer_id_null()
    {
        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-ABC123',
            hardwareModel: 'MacBook Pro',
            manufacturer: '   ',
        ));

        $model = AssetModel::where('name', 'MacBook Pro')->first();
        $this->assertNull($model->manufacturer_id);
    }

    public function test_existing_model_is_not_reassigned_on_resync()
    {
        // Preserve hand-curated manufacturer values on models the
        // admin already touched. This is the "leave existing alone"
        // half of the reporter's suggested fix.
        $handPickedManufacturer = Manufacturer::factory()->create(['name' => 'Apple, Inc.']);
        $existing = AssetModel::factory()->create([
            'name' => 'MacBook Pro',
            'manufacturer_id' => $handPickedManufacturer->id,
        ]);

        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '1',
            hostname: 'wksn-01',
            hardwareSerial: 'SN-ABC123',
            hardwareModel: 'MacBook Pro',
            manufacturer: 'Apple',
        ));

        $existing->refresh();
        $this->assertSame($handPickedManufacturer->id, $existing->manufacturer_id, 'Existing model manufacturer should not be clobbered by sync.');
    }
}
