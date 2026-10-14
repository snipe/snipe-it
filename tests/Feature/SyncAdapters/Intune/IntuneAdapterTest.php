<?php

namespace Tests\Feature\SyncAdapters\Intune;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Intune\IntuneAdapter;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * End-to-end coverage for the Microsoft Intune adapter through
 * SyncAdapter. Fakes the OAuth token exchange and the
 * Graph managedDevices endpoint.
 */
class IntuneAdapterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Statuslabel::factory()->rtd()->create();
    }

    public function test_pulls_devices_from_graph_and_creates_assets()
    {
        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [
                    $this->intuneDevice(id: 'guid-42', name: 'intune-host-1'),
                    $this->intuneDevice(id: 'guid-99', name: 'intune-host-2'),
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 2);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'intune', 'external_id' => 'guid-42']);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'intune', 'external_id' => 'guid-99']);
    }

    public function test_normalized_record_carries_expected_fields()
    {
        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [
                    [
                        'id' => 'guid-7',
                        'deviceName' => 'intune-mbp',
                        'serialNumber' => 'FW-ABC-123',
                        'model' => 'Surface Pro 9',
                        'manufacturer' => 'Microsoft',
                        'ethernetMacAddress' => 'aa:bb:cc:dd:ee:ff',
                        'wiFiMacAddress' => '11:22:33:44:55:66',
                        'operatingSystem' => 'Windows',
                        'osVersion' => '11.24H2',
                        'lastSyncDateTime' => '2026-01-15T10:00:00Z',
                        'userPrincipalName' => 'alice@example.test',
                        'complianceState' => 'compliant',
                    ],
                ],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);

        $record = $records[0];
        $this->assertSame('intune', $record->sourceKey);
        $this->assertSame('guid-7', $record->sourceId);
        $this->assertSame('intune-mbp', $record->hostname);
        $this->assertSame('FW-ABC-123', $record->hardwareSerial);
        $this->assertSame('Surface Pro 9', $record->hardwareModel);
        $this->assertSame('Microsoft', $record->manufacturer);
        $this->assertSame('aa:bb:cc:dd:ee:ff', $record->primaryMac);
        $this->assertSame('Windows', $record->os);
        $this->assertSame('11.24H2', $record->osVersion);
        $this->assertSame('alice@example.test', $record->assignedUserEmail);
        $this->assertNotNull($record->lastSeen);
    }

    public function test_nextlink_cursor_cannot_redirect_bearer_to_arbitrary_host()
    {
        // Graph normally serves `@odata.nextLink` from the same host as
        // the base URL. A hostile upstream (compromised vendor API or
        // MITM) can nominate any URL, so the adapter must keep the
        // next hop on the configured graph host so the bearer token
        // never travels to an attacker-chosen target.
        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'leak-canary', 'expires_in' => 3600]),
            'graph.microsoft.com/v1.0/deviceManagement/managedDevices' => Http::response([
                'value' => [$this->intuneDevice(id: 'guid-1', name: 'host-one')],
                '@odata.nextLink' => 'https://attacker.example/exfil?token=steal',
            ]),
            'graph.microsoft.com/exfil*' => Http::response([
                'value' => [$this->intuneDevice(id: 'guid-2', name: 'host-two')],
            ]),
            'attacker.example/*' => Http::response(['value' => []]),
        ]);

        iterator_to_array($adapter->pull());

        Http::assertNotSent(fn ($request) => str_contains($request->url(), 'attacker.example'));
        Http::assertSent(fn ($request) => str_contains($request->url(), 'graph.microsoft.com/exfil')
            && $request->hasHeader('Authorization', 'Bearer leak-canary'));
    }

    /**
     * Reporter-identified robustness note (Zer0Gate post-fix for
     * GHSA-cf4m-f928-928g): if upstream emits a path-relative cursor
     * with no leading slash (e.g. `"@odata.nextLink": "page2"`),
     * `parse_url` returns `path => "page2"` and the earlier shape
     * concatenated it directly onto the origin, producing an
     * unparseable "https://hostpage2". Pagination aborted on the next
     * iteration (fail-safe) but we'd rather be explicit. The
     * rebasedCursor helper now rejects the cursor outright when its
     * path lacks a leading slash.
     */
    public function test_relative_nextlink_cursor_without_leading_slash_terminates_pagination_without_malformed_request()
    {
        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub', 'expires_in' => 3600]),
            'graph.microsoft.com/v1.0/deviceManagement/managedDevices' => Http::response([
                'value' => [$this->intuneDevice(id: 'guid-1', name: 'host-one')],
                '@odata.nextLink' => 'page2',
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());

        $this->assertCount(1, $records, 'First page should still process, pagination stops at malformed cursor.');
        Http::assertNotSent(fn ($request) => str_contains($request->url(), 'graph.microsoft.compage2')
            || str_contains($request->url(), 'graph.microsoft.com/page2'));
    }

    public function test_scope_tag_filter_resolves_names_to_ids_and_sends_odata_filter()
    {
        $adapter = $this->configuredAdapter(scopeTagFilter: 'Marketing, 7');

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/roleScopeTags*' => Http::response([
                'value' => [
                    ['id' => '3', 'displayName' => 'Marketing'],
                    ['id' => '7', 'displayName' => 'Engineering'],
                    ['id' => '11', 'displayName' => 'Finance'],
                ],
            ]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [
                    $this->intuneDevice(id: 'guid-marketing', name: 'host-marketing'),
                ],
            ]),
        ]);

        iterator_to_array($adapter->pull());

        Http::assertSent(function ($request) {
            if (! str_contains($request->url(), '/v1.0/deviceManagement/managedDevices')) {
                return false;
            }
            $url = urldecode($request->url());

            return str_contains($url, 'roleScopeTagIds/any(x:')
                && str_contains($url, "x eq '3'")
                && str_contains($url, "x eq '7'");
        });
    }

    public function test_blank_scope_tag_filter_sends_no_odata_filter()
    {
        $adapter = $this->configuredAdapter(scopeTagFilter: '');

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response(['value' => []]),
        ]);

        iterator_to_array($adapter->pull());

        // No roleScopeTags call fired, no $filter param on the devices call.
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '/v1.0/deviceManagement/roleScopeTags'));
        Http::assertSent(fn ($request) => str_contains($request->url(), '/v1.0/deviceManagement/managedDevices')
            && ! str_contains(urldecode($request->url()), '$filter'));
    }

    public function test_unresolved_scope_tag_entry_is_dropped()
    {
        // "Ghost" matches no tag. "Marketing" resolves to 3. Expect the
        // outgoing filter to carry 3 only.
        $adapter = $this->configuredAdapter(scopeTagFilter: 'Marketing, Ghost');

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/roleScopeTags*' => Http::response([
                'value' => [['id' => '3', 'displayName' => 'Marketing']],
            ]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response(['value' => []]),
        ]);

        iterator_to_array($adapter->pull());

        Http::assertSent(function ($request) {
            if (! str_contains($request->url(), '/v1.0/deviceManagement/managedDevices')) {
                return false;
            }
            $url = urldecode($request->url());

            return str_contains($url, "x eq '3'") && ! str_contains($url, 'Ghost');
        });
    }

    public function test_scope_tag_ids_surface_on_normalized_record_as_comma_joined_string()
    {
        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [[
                    'id' => 'guid-tagged',
                    'deviceName' => 'tagged-host',
                    'serialNumber' => 'SN-TAGGED',
                    'model' => 'Surface Pro 9',
                    'roleScopeTagIds' => ['3', '7'],
                ]],
            ]),
        ]);

        $records = iterator_to_array($adapter->pull());

        $this->assertSame('3,7', $records[0]->extra['intune_role_scope_tag_ids']);
    }

    private function configuredAdapter(?string $scopeTagFilter = null): IntuneAdapter
    {
        $instance = SyncAdapterInstance::where('slug', 'intune')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://graph.microsoft.com');
        SyncAdapterConfig::put($instance->id, 'tenant_id', 'stub-tenant');
        SyncAdapterConfig::put($instance->id, 'client_id', 'stub-client');
        SyncAdapterConfig::put($instance->id, 'client_secret', Crypt::encrypt('fake-secret'));
        if ($scopeTagFilter !== null) {
            SyncAdapterConfig::put($instance->id, 'scope_tag_filter', $scopeTagFilter);
        }

        return new IntuneAdapter($instance->fresh());
    }

    /**
     * @return array<string, mixed>
     */
    private function intuneDevice(string $id, string $name): array
    {
        return [
            'id' => $id,
            'deviceName' => $name,
            'serialNumber' => 'SN-'.$id,
            'model' => 'Generic Model',
        ];
    }

    public function test_vendor_record_without_serial_is_skipped_when_model_requires_serial()
    {
        AssetModel::factory()->create([
            'name' => 'Generic Model',
            'require_serial' => 1,
        ]);

        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [
                    [
                        'id' => 'guid-no-serial',
                        'deviceName' => 'defender-onboarded-host',
                        'serialNumber' => '',
                        'model' => 'Generic Model',
                    ],
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseMissing('asset_external_sources', ['source' => 'intune', 'external_id' => 'guid-no-serial']);
        $this->assertSame(0, Asset::query()->count(), 'No asset should be created when the model requires a serial and the vendor record has none.');
    }

    public function test_vendor_record_without_serial_still_creates_when_model_does_not_require_serial()
    {
        AssetModel::factory()->create([
            'name' => 'Generic Model',
            'require_serial' => 0,
        ]);

        $adapter = $this->configuredAdapter();

        Http::fake([
            '*/oauth2/v2.0/token' => Http::response(['access_token' => 'stub-bearer', 'expires_in' => 3600]),
            '*/v1.0/deviceManagement/managedDevices*' => Http::response([
                'value' => [
                    [
                        'id' => 'guid-no-serial-ok',
                        'deviceName' => 'serial-less-but-ok',
                        'serialNumber' => '',
                        'model' => 'Generic Model',
                    ],
                ],
            ]),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseHas('asset_external_sources', ['source' => 'intune', 'external_id' => 'guid-no-serial-ok']);
    }
}
