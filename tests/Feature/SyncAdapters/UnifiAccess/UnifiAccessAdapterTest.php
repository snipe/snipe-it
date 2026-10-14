<?php

namespace Tests\Feature\SyncAdapters\UnifiAccess;

use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\SyncAdapter;
use App\SyncAdapters\UnifiAccess\UnifiAccessAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * End-to-end coverage for the UniFi Access adapter through
 * SyncAdapter. Mocks the Access developer API, asserts assets +
 * asset_external_sources land correctly, and that the Bearer token
 * (not X-API-KEY) goes out on the request.
 */
class UnifiAccessAdapterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_pulls_devices_from_unifi_access_and_creates_assets()
    {
        $adapter = $this->configuredUnifiAccessAdapter();

        Http::fake([
            '*/api/v1/developer/devices' => Http::response([
                'code' => 'SUCCESS',
                'msg' => '',
                'data' => [
                    $this->accessDevice(id: 'door-1', name: 'Front Door Hub', type: 'UA-HUB-DOOR'),
                    $this->accessDevice(id: 'reader-1', name: 'Lobby Reader', type: 'UA-G2-PRO'),
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 2);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'unifi-access', 'external_id' => 'door-1']);
        $this->assertDatabaseHas('assets', ['name' => 'Front Door Hub']);
    }

    public function test_bearer_token_is_sent_not_x_api_key_or_cookie()
    {
        $adapter = $this->configuredUnifiAccessAdapter();

        Http::fake([
            '*/api/v1/developer/devices' => Http::response(['code' => 'SUCCESS', 'data' => []]),
        ]);

        iterator_to_array($adapter->pull());

        // UniFi Access uses a Bearer token, provisioned separately
        // from the Network X-API-KEY. A copy-paste regression that
        // sent the token via the Network header would fail auth
        // against a real Access console.
        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer fake-unifi-access-token')
                && ! $request->hasHeader('X-API-KEY')
                && ! $request->hasHeader('Cookie');
        });
    }

    public function test_envelope_free_payload_is_also_accepted()
    {
        $adapter = $this->configuredUnifiAccessAdapter();

        // Some firmware revisions drop the {code, msg, data} envelope
        // and return a bare array of devices. The client falls back to
        // the top-level shape so an API revision doesn't break the pull.
        Http::fake([
            '*/api/v1/developer/devices' => Http::response([
                $this->accessDevice(id: 'bare-1', name: 'Service Entrance Hub', type: 'UAH-DOOR'),
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseHas('asset_external_sources', ['source' => 'unifi-access', 'external_id' => 'bare-1']);
    }

    public function test_normalized_record_carries_expected_fields()
    {
        $adapter = $this->configuredUnifiAccessAdapter();

        Http::fake([
            '*/api/v1/developer/devices' => Http::response([
                'data' => [
                    $this->accessDevice(
                        id: 'hub-7',
                        name: 'West Wing Hub',
                        type: 'UAH-DOOR',
                        serial: 'UAH-7XY',
                        mac: 'aa:bb:cc:11:22:33',
                        ip: '10.0.0.42',
                        firmware: '2.14.6',
                        lastSeen: '2026-01-15T10:00:00.000Z',
                        status: 'online',
                    ),
                ],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);

        $record = $records[0];
        $this->assertSame('unifi-access', $record->sourceKey);
        $this->assertSame('hub-7', $record->sourceId);
        $this->assertSame('West Wing Hub', $record->hostname);
        $this->assertSame('UAH-7XY', $record->hardwareSerial);
        $this->assertSame('UAH-DOOR', $record->hardwareModel);
        $this->assertSame('Ubiquiti', $record->manufacturer);
        $this->assertSame('aa:bb:cc:11:22:33', $record->primaryMac);
        $this->assertSame('10.0.0.42', $record->primaryIp);
        $this->assertSame('UniFi Access', $record->os);
        $this->assertSame('2.14.6', $record->osVersion);
        $this->assertNotNull($record->lastSeen);
        $this->assertSame('online', $record->extra['unifi_access_status']);
    }

    public function test_unix_epoch_last_seen_parses_through()
    {
        $adapter = $this->configuredUnifiAccessAdapter();

        // Older Access firmware reports last_seen as a unix epoch
        // integer. The adapter's parseTimestamp accepts either shape.
        Http::fake([
            '*/api/v1/developer/devices' => Http::response([
                'data' => [
                    $this->accessDevice(
                        id: 'epoch-1',
                        name: 'Loading Dock Reader',
                        lastSeen: 1_736_000_000,
                    ),
                ],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);
        $this->assertNotNull($records[0]->lastSeen);
    }

    private function configuredUnifiAccessAdapter(): UnifiAccessAdapter
    {
        $instance = SyncAdapterInstance::where('slug', 'unifi-access')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://access.example.test');
        SyncAdapterConfig::put($instance->id, 'api_token', Crypt::encrypt('fake-unifi-access-token'));

        return new UnifiAccessAdapter($instance->fresh());
    }

    /**
     * @return array<string, mixed>
     */
    private function accessDevice(
        string $id,
        string $name = 'Device',
        string $type = 'UA-HUB-DOOR',
        ?string $serial = null,
        ?string $mac = null,
        ?string $ip = null,
        ?string $firmware = null,
        string|int|null $lastSeen = null,
        string $status = 'online',
    ): array {
        return [
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'model_name' => $type,
            'serial_number' => $serial,
            'mac' => $mac,
            'ip' => $ip,
            'firmware_version' => $firmware,
            'last_seen' => $lastSeen,
            'status' => $status,
            'adopted' => true,
        ];
    }
}
