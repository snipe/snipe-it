<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\AssetModel;
use App\Models\CustomFieldset;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Tests\TestCase;

class DefaultFieldsetAutoCreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Statuslabel::factory()->rtd()->create();
    }

    public function test_auto_created_model_gets_adapter_configured_default_fieldset()
    {
        $fieldset = CustomFieldset::create(['name' => 'Fleet Hardware Fieldset']);

        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'default_fieldset_id', (string) $fieldset->id);

        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '42',
            hostname: 'wksn-42',
            hardwareSerial: 'SN-DEFAULT-FIELDSET-1',
            hardwareModel: 'ThinkPad X1',
            manufacturer: 'Lenovo',
        ));

        $model = AssetModel::where('name', 'ThinkPad X1')->first();
        $this->assertNotNull($model);
        $this->assertSame(
            $fieldset->id,
            $model->fieldset_id,
            'Auto-created AssetModel must inherit the adapter instance\'s configured default_fieldset_id so custom fields show on synced devices.'
        );
    }

    public function test_auto_created_model_has_null_fieldset_when_adapter_not_configured()
    {
        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '43',
            hostname: 'wksn-43',
            hardwareSerial: 'SN-DEFAULT-FIELDSET-2',
            hardwareModel: 'ThinkPad X2',
            manufacturer: 'Lenovo',
        ));

        $model = AssetModel::where('name', 'ThinkPad X2')->first();
        $this->assertNotNull($model);
        $this->assertNull(
            $model->fieldset_id,
            'When default_fieldset_id is unset, new auto-created models must stay fieldset-less. This preserves pre-feature behavior for installs that have not opted in.'
        );
    }

    public function test_existing_model_match_does_not_overwrite_existing_fieldset()
    {
        $vendorFieldset = CustomFieldset::create(['name' => 'Vendor Default Fieldset']);
        $adminChosenFieldset = CustomFieldset::create(['name' => 'Admin Chosen Fieldset']);

        $preExisting = AssetModel::factory()->create([
            'name' => 'MacBook Pro 16',
            'fieldset_id' => $adminChosenFieldset->id,
        ]);

        $instance = SyncAdapterInstance::where('slug', 'fleet')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'default_fieldset_id', (string) $vendorFieldset->id);

        SyncAdapter::syncFromRecord(new HostInventoryRecord(
            sourceKey: 'fleet',
            sourceId: '44',
            hostname: 'wksn-44',
            hardwareSerial: 'SN-DEFAULT-FIELDSET-3',
            hardwareModel: 'MacBook Pro 16',
            manufacturer: 'Apple',
        ));

        $preExisting->refresh();
        $this->assertSame(
            $adminChosenFieldset->id,
            $preExisting->fieldset_id,
            'An existing AssetModel matched by exact name must keep its own fieldset. default_fieldset_id only stamps new models, never overwrites existing ones.'
        );
    }
}
