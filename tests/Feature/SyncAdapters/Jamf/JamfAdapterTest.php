<?php

namespace Tests\Feature\SyncAdapters\Jamf;

use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Jamf\JamfAdapter;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * End-to-end coverage for the Jamf Pro adapter through
 * SyncAdapter. Mocks the Jamf Pro API, asserts assets +
 * asset_external_sources land correctly, and that the totalCount /
 * pagination termination works.
 */
class JamfAdapterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_pulls_computers_from_jamf_and_creates_assets()
    {
        $adapter = $this->configuredJamfAdapter();

        Http::fake([
            '*/api/oauth/token' => $this->jamfTokenResponse(),
            '*/api/v1/computers-inventory*' => Http::response([
                'totalCount' => 2,
                'results' => [
                    $this->jamfComputer(id: 42, name: 'lab-mac-01', model: 'iMac'),
                    $this->jamfComputer(id: 99, name: 'lab-mac-02', model: 'Mac mini'),
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 2);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => '42']);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => '99']);
        $this->assertDatabaseHas('assets', ['name' => 'lab-mac-01']);

        // Laravel's default array-shaped query encoding produces the bracketed
        // form and Jamf silently drops it, leaving every asset with
        // no hardware section (and no model id). The client hand-builds
        // the query string to force the API shape Jamf actually reads.
        Http::assertSent(function ($request) {
            if (! str_contains($request->url(), '/api/v1/computers-inventory')) {
                return false;
            }
            $url = $request->url();

            return str_contains($url, 'section=GENERAL')
                && str_contains($url, 'section=HARDWARE')
                && str_contains($url, 'section=OPERATING_SYSTEM')
                && str_contains($url, 'section=USER_AND_LOCATION')
                && ! str_contains($url, 'section%5B')
                && ! str_contains($url, 'section[');
        });
    }

    public function test_normalized_record_carries_expected_fields()
    {
        $adapter = $this->configuredJamfAdapter();

        Http::fake([
            '*/api/oauth/token' => $this->jamfTokenResponse(),
            '*/api/v1/computers-inventory*' => Http::response([
                'totalCount' => 1,
                'results' => [
                    $this->jamfComputer(
                        id: 7,
                        name: 'design-mbp',
                        model: 'MacBook Pro (16-inch, M3)',
                        serialNumber: 'C02XYZ',
                        macAddress: 'aa:bb:cc:11:22:33',
                        osName: 'macOS',
                        osVersion: '14.2.1',
                        lastContactTime: '2026-01-15T10:00:00.000Z',
                    ),
                ],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);

        $record = $records[0];
        $this->assertSame('jamf', $record->sourceKey);
        $this->assertSame('7', $record->sourceId);
        $this->assertSame('design-mbp', $record->hostname);
        $this->assertSame('MacBook Pro (16-inch, M3)', $record->hardwareModel);
        $this->assertSame('C02XYZ', $record->hardwareSerial);
        $this->assertSame('Apple', $record->manufacturer);
        $this->assertSame('aa:bb:cc:11:22:33', $record->primaryMac);
        $this->assertSame('macOS', $record->os);
        $this->assertSame('14.2.1', $record->osVersion);
        $this->assertNotNull($record->lastSeen);
    }

    public function test_mobile_devices_pulled_when_toggle_is_on()
    {
        $adapter = $this->configuredJamfAdapter(includeMobile: true);

        Http::fake([
            '*/api/oauth/token' => $this->jamfTokenResponse(),
            '*/api/v1/computers-inventory*' => Http::response([
                'totalCount' => 1,
                'results' => [$this->jamfComputer(id: 42, name: 'lab-mac-01', model: 'iMac')],
            ]),
            '*/api/v2/mobile-devices*' => Http::response([
                'totalCount' => 2,
                'results' => [
                    $this->jamfMobileDevice(id: 10, name: 'kiosk-ipad-01', model: 'iPad Pro', serialNumber: 'DMPXYZ', osType: 'iOS', osVersion: '17.4'),
                    $this->jamfMobileDevice(id: 11, name: 'conf-apple-tv', model: 'Apple TV 4K', serialNumber: 'C07ABC', osType: 'tvOS', osVersion: '17.1', deviceType: 'tvos'),
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        // Three distinct external_sources rows: one bare-numeric for the
        // computer, two `mobile:`-prefixed for the devices. Prefix on
        // mobile keeps the two Jamf id namespaces from colliding on
        // the (source, external_id) uniqueness constraint.
        $this->assertDatabaseCount('asset_external_sources', 3);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => '42']);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => 'mobile:10']);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => 'mobile:11']);

        $this->assertDatabaseHas('assets', ['name' => 'kiosk-ipad-01']);
        $this->assertDatabaseHas('assets', ['name' => 'conf-apple-tv']);
    }

    public function test_mobile_devices_skipped_when_toggle_is_off()
    {
        $adapter = $this->configuredJamfAdapter();

        Http::fake([
            '*/api/oauth/token' => $this->jamfTokenResponse(),
            '*/api/v1/computers-inventory*' => Http::response([
                'totalCount' => 1,
                'results' => [$this->jamfComputer(id: 42, name: 'lab-mac-01', model: 'iMac')],
            ]),
            '*/api/v2/mobile-devices*' => Http::response([
                'totalCount' => 1,
                'results' => [$this->jamfMobileDevice(id: 10, name: 'should-not-sync')],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 1);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'jamf', 'external_id' => '42']);
        $this->assertDatabaseMissing('assets', ['name' => 'should-not-sync']);

        // Toggle off means we don't bill Jamf for a mobile pull at all.
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '/api/v2/mobile-devices'));
    }

    public function test_mobile_record_carries_expected_fields()
    {
        $adapter = $this->configuredJamfAdapter(includeMobile: true);

        Http::fake([
            '*/api/oauth/token' => $this->jamfTokenResponse(),
            '*/api/v1/computers-inventory*' => Http::response([
                'totalCount' => 0,
                'results' => [],
            ]),
            '*/api/v2/mobile-devices*' => Http::response([
                'totalCount' => 1,
                'results' => [
                    $this->jamfMobileDevice(
                        id: 55,
                        name: 'ipad-55',
                        model: 'iPad Air',
                        serialNumber: 'C02ABC',
                        osType: 'iOS',
                        osVersion: '17.5',
                        wifiMacAddress: 'aa:bb:cc:dd:ee:ff',
                        ipAddress: '10.0.0.55',
                        lastInventoryUpdateTimestamp: '2026-02-15T10:00:00.000Z',
                        locationUsername: 'jdoe',
                        locationEmail: 'jdoe@example.com',
                        deviceType: 'ios',
                        managed: true,
                        supervised: true,
                    ),
                ],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);

        $record = $records[0];
        $this->assertSame('jamf', $record->sourceKey);
        $this->assertSame('mobile:55', $record->sourceId);
        $this->assertSame('ipad-55', $record->hostname);
        $this->assertSame('iPad Air', $record->hardwareModel);
        $this->assertSame('C02ABC', $record->hardwareSerial);
        $this->assertSame('Apple', $record->manufacturer);
        $this->assertSame('aa:bb:cc:dd:ee:ff', $record->primaryMac);
        $this->assertSame('10.0.0.55', $record->primaryIp);
        $this->assertSame('iOS', $record->os);
        $this->assertSame('17.5', $record->osVersion);
        $this->assertSame('jdoe', $record->assignedUserName);
        $this->assertSame('jdoe@example.com', $record->assignedUserEmail);
        $this->assertNotNull($record->lastSeen);
        $this->assertSame('ios', $record->extra['jamf_mobile_device_type']);
        $this->assertTrue($record->extra['jamf_mobile_managed']);
        $this->assertTrue($record->extra['jamf_mobile_supervised']);
    }

    private function configuredJamfAdapter(bool $includeMobile = false): JamfAdapter
    {
        $instance = SyncAdapterInstance::where('slug', 'jamf')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://example.jamfcloud.com');
        SyncAdapterConfig::put($instance->id, 'client_id', Crypt::encrypt('fake-jamf-client-id'));
        SyncAdapterConfig::put($instance->id, 'client_secret', Crypt::encrypt('fake-jamf-client-secret'));
        SyncAdapterConfig::put($instance->id, 'include_mobile_devices', $includeMobile ? '1' : '0');

        return new JamfAdapter($instance->fresh());
    }

    /**
     * Jamf Pro's /api/oauth/token response shape. expires_in is
     * whatever the API Client is configured for. The client's bearer
     * cache honors it with a 30-second buffer before re-exchanging.
     * No return type hint because Http::response() inside a fake
     * handler resolves to a promise, not a bare Response.
     */
    private function jamfTokenResponse()
    {
        return Http::response([
            'access_token' => 'fake-jamf-access-token',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ]);
    }

    /**
     * Shape of a /api/v2/mobile-devices list entry Jamf Pro returns.
     * Mobile responses are flatter than computer ones: no section
     * nesting, just a top-level field set per device.
     *
     * @return array<string, mixed>
     */
    private function jamfMobileDevice(
        int $id,
        string $name = 'ipad',
        string $model = 'iPad',
        ?string $serialNumber = null,
        ?string $osType = 'iOS',
        ?string $osVersion = null,
        ?string $wifiMacAddress = null,
        ?string $ipAddress = null,
        ?string $lastInventoryUpdateTimestamp = null,
        ?string $locationUsername = null,
        ?string $locationEmail = null,
        string $deviceType = 'ios',
        bool $managed = true,
        bool $supervised = false,
    ): array {
        return [
            'id' => (string) $id,
            'name' => $name,
            'udid' => 'jamf-mobile-udid-'.$id,
            'serialNumber' => $serialNumber,
            'assetTag' => null,
            'model' => $model,
            'modelIdentifier' => 'iPad'.$id,
            'deviceType' => $deviceType,
            'osType' => $osType,
            'osVersion' => $osVersion,
            'wifiMacAddress' => $wifiMacAddress,
            'ipAddress' => $ipAddress,
            'lastInventoryUpdateTimestamp' => $lastInventoryUpdateTimestamp,
            'managed' => $managed,
            'supervised' => $supervised,
            'location' => [
                'username' => $locationUsername,
                'emailAddress' => $locationEmail,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function jamfComputer(
        int $id,
        string $name = 'computer',
        string $model = 'MacBook',
        ?string $serialNumber = null,
        ?string $macAddress = null,
        ?string $osName = 'macOS',
        ?string $osVersion = null,
        ?string $lastContactTime = null,
    ): array {
        return [
            'id' => (string) $id,
            'udid' => 'jamf-udid-'.$id,
            'general' => [
                'name' => $name,
                'lastContactTime' => $lastContactTime,
                'lastEnrolledDate' => null,
            ],
            'hardware' => [
                'make' => 'Apple',
                'model' => $model,
                'modelIdentifier' => 'Mac'.$id,
                'serialNumber' => $serialNumber,
                'macAddress' => $macAddress,
            ],
            'operatingSystem' => [
                'name' => $osName,
                'version' => $osVersion,
            ],
        ];
    }
}
