<?php

namespace Tests\Feature\SyncAdapters\Landscape;

use App\Models\Asset;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\SyncAdapters\Landscape\LandscapeAdapter;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LandscapeAdapterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Statuslabel::factory()->rtd()->create();
    }

    public function test_pulls_computers_from_landscape_and_creates_assets()
    {
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'ubuntu-01', product: 'PowerEdge R450', mac: 'aa:bb:cc:00:00:42'),
                    $this->landscapeComputer(id: 99, hostname: 'ubuntu-02', product: 'ThinkSystem SR630', mac: 'aa:bb:cc:00:00:99'),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 2);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'landscape', 'external_id' => '42']);
        $this->assertDatabaseHas('asset_external_sources', ['source' => 'landscape', 'external_id' => '99']);
        $this->assertDatabaseHas('assets', ['name' => 'ubuntu-01']);
        $this->assertDatabaseHas('assets', ['name' => 'ubuntu-02']);
    }

    public function test_re_running_updates_existing_assets_instead_of_duplicating()
    {
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'ubuntu-01', product: 'PowerEdge'),
                ]))
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'ubuntu-01-renamed', product: 'PowerEdge', ip: '10.0.0.42'),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 1);
        $this->assertDatabaseCount('assets', 1);
        $originalAssetId = Asset::where('name', 'ubuntu-01')->firstOrFail()->id;

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 1);
        $this->assertDatabaseCount('assets', 1);

        $this->assertSame('ubuntu-01-renamed', Asset::find($originalAssetId)->name);
        $this->assertSame('10.0.0.42', DB::table('asset_external_sources')->where('asset_id', $originalAssetId)->value('primary_ip'));
    }

    public function test_normalized_record_carries_expected_fields()
    {
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(
                        id: 7,
                        hostname: 'ubuntu-server',
                        product: 'PowerEdge R750',
                        vendor: 'Dell',
                        serial: 'DELL-ABC-123',
                        mac: 'aa:bb:cc:dd:ee:ff',
                        ip: '192.168.1.7',
                        distribution: '24.04',
                        last_ping_time: '2026-01-15T10:00:00Z',
                        tags: ['prod', 'db'],
                        access_group: 'engineering',
                        reboot_required: true,
                    ),
                ])),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(1, $records);

        $record = $records[0];
        $this->assertSame('landscape', $record->sourceKey);
        $this->assertSame('7', $record->sourceId);
        $this->assertSame('ubuntu-server', $record->hostname);
        $this->assertSame('PowerEdge R750', $record->hardwareModel);
        $this->assertSame('DELL-ABC-123', $record->hardwareSerial);
        $this->assertSame('Dell', $record->manufacturer);
        $this->assertSame('aa:bb:cc:dd:ee:ff', $record->primaryMac);
        $this->assertSame('192.168.1.7', $record->primaryIp);
        $this->assertSame('Ubuntu', $record->os);
        $this->assertSame('24.04', $record->osVersion);
        $this->assertNotNull($record->lastSeen);

        $this->assertSame(['prod', 'db'], $record->extra['landscape_tags']);
        $this->assertSame('engineering', $record->extra['landscape_access_group']);
        $this->assertSame('24.04', $record->extra['landscape_distribution']);
        $this->assertTrue($record->extra['landscape_reboot_required']);
    }

    public function test_hostname_falls_back_to_title_when_hostname_missing()
    {
        // Some Landscape installs populate `title` (the display name in
        // the admin UI) but not `hostname` (the OS-reported name).
        // Normalize falls back to title so the asset row still has a
        // useful name column.
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    ['id' => 1, 'title' => 'title-only', 'grouped_hardware' => []],
                ])),
        ]);

        $record = iterator_to_array($adapter->pull())[0];
        $this->assertSame('title-only', $record->hostname);
    }

    public function test_grouped_hardware_tolerates_list_shape_for_system()
    {
        // Landscape's grouped_hardware.system comes back as a flat
        // object on some responses and as a single-element list on
        // others. firstHardwareRecord() unwraps both to the same
        // shape so serial/vendor/product extraction is stable.
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    [
                        'id' => 1,
                        'hostname' => 'list-shape',
                        'grouped_hardware' => [
                            'system' => [
                                ['serial' => 'LIST-SN', 'vendor' => 'Dell', 'product' => 'PowerEdge'],
                            ],
                            'network' => [
                                ['mac' => 'aa:bb:cc:00:00:01', 'ip' => '10.0.0.1'],
                            ],
                        ],
                    ],
                ])),
        ]);

        $record = iterator_to_array($adapter->pull())[0];
        $this->assertSame('LIST-SN', $record->hardwareSerial);
        $this->assertSame('Dell', $record->manufacturer);
        $this->assertSame('PowerEdge', $record->hardwareModel);
    }

    public function test_pagination_stops_when_next_url_is_null()
    {
        // Landscape returns `next: null` on the final page. The pull
        // loop must terminate rather than hammering the endpoint
        // forever. Multi-page fake with the second page marking end.
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push([
                    'results' => [$this->landscapeComputer(id: 1, hostname: 'page1-host', product: 'P1')],
                    'next' => 'https://landscape.example.test/api/v2/computers?offset=500',
                ])
                ->push([
                    'results' => [$this->landscapeComputer(id: 2, hostname: 'page2-host', product: 'P2')],
                    'next' => null,
                ]),
        ]);

        $records = iterator_to_array($adapter->pull());
        $this->assertCount(2, $records);
        $this->assertSame('page1-host', $records[0]->hostname);
        $this->assertSame('page2-host', $records[1]->hostname);
    }

    public function test_adopts_existing_asset_by_serial_when_toggle_is_on()
    {
        // Migration scenario: customer already has assets in Snipe-IT
        // (from a homegrown script that populated `serial`) but no
        // asset_external_sources rows for this adapter. With
        // adopt_by_serial turned on, the first sync should adopt the
        // existing asset instead of creating a duplicate.
        $adapter = $this->configuredLandscapeAdapter();
        $instance = SyncAdapterInstance::where('slug', 'landscape')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '1');

        $existing = Asset::factory()->create(['serial' => 'ADOPT-ME-001', 'name' => 'pre-existing']);

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'landscape-sees-it', product: 'PowerEdge', serial: 'ADOPT-ME-001'),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('assets', 1);
        $this->assertDatabaseHas('asset_external_sources', [
            'asset_id' => $existing->id,
            'source' => 'landscape',
            'external_id' => '42',
        ]);

        // Adopted asset's non-mapped columns should not be reset.
        // Name comes from the vendor via the standard mapping loop,
        // so it updates. Serial is the match key and stays put.
        $existing->refresh();
        $this->assertSame('ADOPT-ME-001', $existing->serial);
    }

    public function test_does_not_adopt_when_toggle_is_off()
    {
        
        $adapter = $this->configuredLandscapeAdapter();
        $instance = SyncAdapterInstance::where('slug', 'landscape')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '0');
        Asset::factory()->create(['serial' => 'NO-ADOPT-001', 'name' => 'pre-existing']);

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'landscape-sees-it', product: 'PowerEdge', serial: 'NO-ADOPT-001'),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('assets', 2);
    }

    public function test_adopt_does_not_re_link_an_already_linked_asset()
    {
        // Idempotency guard: if the asset is already linked (its
        // asset_external_sources row exists for this source), the
        // primary matching path handles it. adoptExistingAssetBySerial
        // should not double-insert.
        $adapter = $this->configuredLandscapeAdapter();
        $instance = SyncAdapterInstance::where('slug', 'landscape')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '1');

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'first-sync', product: 'PowerEdge', serial: 'DUP-001'),
                ]))
                ->push($this->landscapeComputersResponse([
                    $this->landscapeComputer(id: 42, hostname: 'second-sync', product: 'PowerEdge', serial: 'DUP-001'),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }
        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('asset_external_sources', 1);
        $this->assertDatabaseCount('assets', 1);
    }

    public function test_adopt_skips_when_vendor_record_has_no_serial()
    {
        // Some Landscape installs return computer records without a
        // serial (grouped_hardware disabled, or dmidecode unavailable
        // on that host). Adoption should be a no-op in that case, not
        // adopt a random unrelated asset by matching NULL to NULL.
        $adapter = $this->configuredLandscapeAdapter();
        $instance = SyncAdapterInstance::where('slug', 'landscape')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'adopt_by_serial', '1');
        Asset::factory()->create(['serial' => null, 'name' => 'unrelated-existing']);

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([
                    // Product info populated so createShellAsset can
                    // still derive a model. serial stays null so the
                    // adopt path is the thing under test.
                    $this->landscapeComputer(id: 42, hostname: 'no-serial-host', product: 'PowerEdge', vendor: 'Dell', serial: null),
                ])),
        ]);

        foreach ($adapter->pull() as $record) {
            SyncAdapter::syncFromRecord($record);
        }

        $this->assertDatabaseCount('assets', 2);
    }

    public function test_bearer_token_is_sent_on_every_request()
    {
        $adapter = $this->configuredLandscapeAdapter();

        Http::fake([
            '*/api/v2/computers*' => Http::sequence()
                ->push($this->landscapeComputersResponse([])),
        ]);

        iterator_to_array($adapter->pull());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/api/v2/computers')
                && $request->hasHeader('Authorization', 'Bearer fake-token');
        });
    }

    private function configuredLandscapeAdapter(): LandscapeAdapter
    {
        $instance = SyncAdapterInstance::where('slug', 'landscape')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'url', 'https://landscape.example.test');
        SyncAdapterConfig::put($instance->id, 'token', Crypt::encrypt('fake-token'));

        return new LandscapeAdapter($instance->fresh());
    }

    /**
     * Wraps a set of computer objects in the top-level shape
     * Landscape's list endpoint returns.
     *
     * @param  array<int, array<string, mixed>>  $computers
     * @return array<string, mixed>
     */
    private function landscapeComputersResponse(array $computers): array
    {
        return [
            'results' => $computers,
            'next' => null,
        ];
    }

    /**
     * @param  array<int, string>  $tags
     * @return array<string, mixed>
     */
    private function landscapeComputer(
        int $id,
        string $hostname = 'ubuntu-host',
        string $product = 'Generic Server',
        ?string $vendor = null,
        ?string $serial = null,
        ?string $mac = null,
        ?string $ip = null,
        ?string $distribution = null,
        ?string $last_ping_time = null,
        array $tags = [],
        ?string $access_group = null,
        bool $reboot_required = false,
    ): array {
        return [
            'id' => $id,
            'hostname' => $hostname,
            'title' => $hostname,
            'distribution' => $distribution,
            'last_ping_time' => $last_ping_time,
            'tags' => $tags,
            'access_group' => $access_group,
            'reboot_required_flag' => $reboot_required,
            'grouped_hardware' => [
                'system' => [
                    'serial' => $serial,
                    'vendor' => $vendor,
                    'product' => $product,
                ],
                'network' => [
                    ['mac' => $mac, 'ip' => $ip],
                ],
            ],
        ];
    }
}
