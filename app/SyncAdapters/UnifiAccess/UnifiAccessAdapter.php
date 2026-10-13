<?php

namespace App\SyncAdapters\UnifiAccess;

use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * UniFi Access adapter. Pulls access-hardware inventory (door hubs,
 * readers, elevator hubs, Access-managed cameras) from a UniFi
 * console's Access app and normalizes it into HostInventoryRecord
 * objects.
 *
 * This is a sibling to UnifiAdapter, not a replacement. Network and
 * Access are separate UniFi apps with separate APIs, separate API
 * tokens, and no shared site model. Admins running both configure one
 * instance of each (the clone pattern on the Add Adapter modal makes
 * that cheap).
 */
class UnifiAccessAdapter extends SyncAdapter
{
    public static function typeLabel(): string
    {
        return 'UniFi Access';
    }

    public static function typeSlug(): string
    {
        return 'unifi-access';
    }

    public static function docsUrl(): ?string
    {
        return 'https://assets.identity.ui.com/unifi-access/api_reference.pdf';
    }

    public function baseUrlPlaceholder(): ?string
    {
        // UniFi Access runs its API on port 12445, independent of
        // Network (443/8443). Server cert is self-signed per the docs.
        return 'https://your-console:12445';
    }

    public function settingsSchema(): array
    {
        return [
            [
                'key' => 'api_token',
                'label' => trans('admin/settings/sync_adapters.label_api_token'),
                'secret' => true,
                'help' => trans('admin/settings/sync_adapters.unifi_access_api_token_help'),
            ],
        ];
    }

    public function presetExtraFields(): array
    {
        return [
            'unifi_access_device_type' => ['label_key' => 'admin/settings/sync_adapters.extra_model_code'],
            'unifi_access_status' => ['label_key' => 'admin/settings/sync_adapters.extra_device_state'],
            'unifi_access_adopted' => ['label_key' => 'admin/settings/sync_adapters.extra_adopted', 'type' => 'boolean'],
        ];
    }

    public function pull(): iterable
    {
        $client = new UnifiAccessClient(
            baseUrl: $this->url(),
            apiToken: $this->credential('api_token'),
        );

        foreach ($client->devices() as $device) {
            yield $this->normalize($device);
        }
    }

    /**
     * Convert a UniFi Access device payload into the normalized record
     * shape. Access's `id` is stable per adopted device and is what we
     * key asset_external_sources on. The documented /devices response
     * is minimal (id, name, type, alias). The mac, ip, firmware,
     * serial, and last_seen fallbacks are opportunistic. They may be
     * present on some firmware revisions, absent on others, and
     * resolve to null when absent. Field-name variants (snake_case vs
     * camelCase) also fall through so API revisions don't silently
     * blank the record.
     *
     * @param  array<string, mixed>  $device
     */
    private function normalize(array $device): HostInventoryRecord
    {
        $id = (string) (Arr::get($device, 'id') ?? Arr::get($device, 'unique_id') ?? '');
        $hostname = Arr::get($device, 'name') ?? Arr::get($device, 'alias');
        $serial = Arr::get($device, 'serial_number') ?? Arr::get($device, 'serialNumber');
        $model = Arr::get($device, 'model_name')
            ?? Arr::get($device, 'model')
            ?? Arr::get($device, 'type')
            ?? Arr::get($device, 'device_type');
        $mac = Arr::get($device, 'mac') ?? Arr::get($device, 'mac_address') ?? Arr::get($device, 'macAddress');
        $ip = Arr::get($device, 'ip') ?? Arr::get($device, 'ip_address') ?? Arr::get($device, 'lan_ip');
        $firmware = Arr::get($device, 'firmware_version')
            ?? Arr::get($device, 'firmwareVersion')
            ?? Arr::get($device, 'firmware');
        $lastSeen = Arr::get($device, 'last_seen')
            ?? Arr::get($device, 'lastSeen')
            ?? Arr::get($device, 'last_activity_at');

        // Status comes through as either a boolean `online` or a string
        // `status` depending on firmware. Normalize to a short string
        // so the extra field renders consistently.
        $status = Arr::get($device, 'status');
        if ($status === null) {
            $online = Arr::get($device, 'online');
            if ($online !== null) {
                $status = $online ? 'online' : 'offline';
            }
        }

        return new HostInventoryRecord(
            sourceKey: $this->name(),
            sourceId: $id,
            hostname: $hostname,
            hardwareSerial: $serial,
            hardwareModel: $model,
            manufacturer: 'Ubiquiti',
            primaryMac: $mac,
            primaryIp: $ip,
            os: 'UniFi Access',
            osVersion: $firmware,
            lastSeen: $this->parseTimestamp($lastSeen),
            extra: [
                'unifi_access_device_type' => Arr::get($device, 'type') ?? Arr::get($device, 'device_type'),
                'unifi_access_status' => $status,
                'unifi_access_adopted' => Arr::get($device, 'adopted'),
            ],
        );
    }

    private function parseTimestamp(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Access reports last_seen as either a unix epoch (int or
        // numeric string) or an ISO 8601 string, depending on firmware.
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp((int) $value);
        }

        return Carbon::parse($value);
    }
}
