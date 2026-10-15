<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Fleet\FleetAdapter;
use Tests\TestCase;


class AdoptBySerialDefaultTest extends TestCase
{
    public function test_defaults_on_for_never_saved_never_synced_instance()
    {
        $instance = $this->makeInstance();

        $adapter = new FleetAdapter($instance);
        $this->assertTrue($adapter->adoptsBySerial());
    }

    public function test_defaults_off_once_the_instance_has_synced()
    {
        $instance = $this->makeInstance();
        $instance->last_synced_at = now();
        $instance->save();

        $adapter = new FleetAdapter($instance->fresh());
        $this->assertFalse($adapter->adoptsBySerial());
    }

    public function test_explicit_off_persists_before_first_sync()
    {
        // Admin unchecks the box and saves. That '0' is stored even
        // though last_synced_at is still null, and adoptsBySerial()
        // must honor the explicit value.
        $instance = $this->makeInstance();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '0');

        $adapter = new FleetAdapter($instance->fresh());
        $this->assertFalse($adapter->adoptsBySerial());
    }

    public function test_explicit_on_persists_after_first_sync()
    {
        $instance = $this->makeInstance();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '1');
        $instance->last_synced_at = now();
        $instance->save();

        $adapter = new FleetAdapter($instance->fresh());
        $this->assertTrue($adapter->adoptsBySerial());
    }

    private function makeInstance(): SyncAdapterInstance
    {
        return SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Fleet Test '.uniqid('', true),
            'active' => true,
        ]);
    }
}
