<?php

namespace App\SyncAdapters\JamfPlatform;

use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Jamf Platform adapter. Pulls device inventory via the Jamf Platform
 * API (GA September 2025) and normalizes it into HostInventoryRecord
 * objects.
 *
 * The Platform API is Jamf's unified gateway that fronts multiple
 * products including what used to be Jamf Now (blueprints + basic
 * device inventory). Customers previously configuring Jamf Now
 * authenticate here, and Jamf Pro / Jamf School customers can also
 * point this adapter at their Platform environment for cross-product
 * inventory. The full-featured JamfAdapter (Jamf Pro Classic + Pro
 * API) and JamfSchoolAdapter (Network-ID basic auth) remain the right
 * choice when an admin needs the deeper per-product surface Platform
 * does not yet subsume.
 */
class JamfPlatformAdapter extends SyncAdapter
{
    public static function typeLabel(): string
    {
        return 'Jamf Platform';
    }

    public static function typeSlug(): string
    {
        return 'jamf_platform';
    }

    public static function docsUrl(): ?string
    {
        return 'https://developer.jamf.com/platform-api/';
    }

    public function baseUrlPlaceholder(): ?string
    {
        return 'https://us.api.jamfcloud.com';
    }

    public function settingsSchema(): array
    {
        return [
            [
                'key' => 'client_id',
                'label' => trans('admin/settings/sync_adapters.label_client_id'),
                'help' => trans('admin/settings/sync_adapters.jamf_platform_client_id_help'),
            ],
            [
                'key' => 'client_secret',
                'label' => trans('admin/settings/sync_adapters.label_client_secret'),
                'secret' => true,
                'help' => trans('admin/settings/sync_adapters.jamf_platform_client_secret_help'),
            ],
            [
                'key' => 'environment_id',
                'label' => trans('admin/settings/sync_adapters.label_environment_id'),
                'help' => trans('admin/settings/sync_adapters.jamf_platform_environment_id_help'),
            ],
        ];
    }

    public function extraFields(): array
    {
        return [
            'jamf_platform_udid' => ['label_key' => 'admin/settings/sync_adapters.extra_udid'],
            'jamf_platform_device_type' => ['label_key' => 'admin/settings/sync_adapters.extra_device_type'],
            'jamf_platform_supervised' => ['label_key' => 'admin/settings/sync_adapters.extra_supervised', 'type' => 'boolean'],
            'jamf_platform_blueprint_id' => ['label_key' => 'admin/settings/sync_adapters.extra_blueprint_id'],
        ];
    }

    public function supportsGroupScoping(): bool
    {
        return true;
    }

    public function vendorGroupLabel(): string
    {
        return trans('admin/settings/sync_adapters.vendor_group_jamf_platform_blueprint');
    }

    public function fetchGroups(): array
    {
        $client = $this->buildClient();

        return array_map(
            fn (array $blueprint) => [
                'id' => (string) ($blueprint['id'] ?? ''),
                'label' => (string) ($blueprint['name'] ?? $blueprint['id'] ?? '?'),
            ],
            $client->blueprints(),
        );
    }

    public function pull(): iterable
    {
        $client = $this->buildClient();

        foreach ($client->devices() as $device) {
            yield $this->normalize($device);
        }
    }

    private function buildClient(): JamfPlatformClient
    {
        return new JamfPlatformClient(
            baseUrl: $this->url(),
            clientId: $this->credential('client_id'),
            clientSecret: $this->credential('client_secret'),
            environmentId: $this->credential('environment_id'),
        );
    }

    /**
     * Convert a Platform device payload into the normalized record
     * shape. Device UDID is stable per enrolled device and is what we
     * key asset_external_sources on. Field paths follow the Jamf
     * Platform devices envelope. If the tenant this adapter is pointed
     * at reports a different shape, the reference at
     * https://developer.jamf.com/platform-api/reference/ is
     * authoritative.
     *
     * @param  array<string, mixed>  $device
     */
    private function normalize(array $device): HostInventoryRecord
    {
        return new HostInventoryRecord(
            sourceKey: $this->name(),
            sourceId: (string) Arr::get($device, 'udid'),
            hostname: Arr::get($device, 'name'),
            hardwareSerial: Arr::get($device, 'serialNumber'),
            hardwareModel: Arr::get($device, 'model'),
            manufacturer: 'Apple',
            primaryMac: Arr::get($device, 'wifiMacAddress'),
            primaryIp: null,
            os: Arr::get($device, 'os'),
            osVersion: Arr::get($device, 'osVersion'),
            lastSeen: $this->parseTimestamp(Arr::get($device, 'lastReported')),
            assetTag: Arr::get($device, 'assetTag'),
            vendorGroupId: Arr::has($device, 'blueprintId') ? (string) Arr::get($device, 'blueprintId') : null,
            extra: [
                'jamf_platform_udid' => Arr::get($device, 'udid'),
                'jamf_platform_device_type' => Arr::get($device, 'deviceType'),
                'jamf_platform_supervised' => Arr::get($device, 'isSupervised'),
                'jamf_platform_blueprint_id' => Arr::get($device, 'blueprintId'),
            ],
        );
    }

    private function parseTimestamp(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value);
    }
}
