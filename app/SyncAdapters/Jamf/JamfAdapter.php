<?php

namespace App\SyncAdapters\Jamf;

use App\Models\Asset;
use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\PushableAdapter;
use App\SyncAdapters\SyncAdapter;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Jamf Pro adapter. Pulls computer inventory via the Jamf Pro API and
 * normalizes it into HostInventoryRecord objects. Authenticates via
 * OAuth 2.0 client credentials against Jamf Pro's /api/oauth/token
 * endpoint (Jamf Pro does not issue long-lived personal tokens, so
 * this is the only workable flow). Also pushes Snipe-IT-authoritative
 * fields (asset_tag today) back to Jamf via the
 * /api/v1/computers-inventory-detail/{id} PATCH endpoint using the
 * same exchanged bearer.
 */
class JamfAdapter extends SyncAdapter implements PushableAdapter
{
    public static function typeLabel(): string
    {
        return 'Jamf Pro';
    }

    public static function typeSlug(): string
    {
        return 'jamf';
    }

    public static function docsUrl(): ?string
    {
        return 'https://developer.jamf.com/jamf-pro/reference';
    }

    public function baseUrlPlaceholder(): ?string
    {
        return 'https://your-subdomain.jamfcloud.com';
    }

    public function settingsSchema(): array
    {
        return [
            [
                'key' => 'client_id',
                'label' => trans('admin/settings/sync_adapters.label_client_id'),
                'help' => trans('admin/settings/sync_adapters.jamf_client_id_help'),
            ],
            [
                'key' => 'client_secret',
                'label' => trans('admin/settings/sync_adapters.label_client_secret'),
                'secret' => true,
                'help' => trans('admin/settings/sync_adapters.jamf_client_secret_help'),
            ],
            [
                'key' => 'include_mobile_devices',
                'label' => trans('admin/settings/sync_adapters.jamf_label_include_mobile_devices'),
                'type' => 'checkbox',
                'required' => false,
                'help' => trans('admin/settings/sync_adapters.jamf_include_mobile_devices_help'),
            ],
        ];
    }

    public function extraFields(): array
    {
        return [
            'jamf_udid' => ['label_key' => 'admin/settings/sync_adapters.extra_udid'],
            'jamf_last_enrolled' => ['label_key' => 'admin/settings/sync_adapters.extra_last_enrolled'],
            'jamf_model_identifier' => ['label_key' => 'admin/settings/sync_adapters.extra_model_identifier'],
            // Mobile-only fields. Blank on computer records so admins
            // can still map them without worrying about overwriting a
            // computer's custom field with an empty string.
            'jamf_mobile_device_type' => ['label_key' => 'admin/settings/sync_adapters.jamf_extra_mobile_device_type'],
            'jamf_mobile_managed' => ['label_key' => 'admin/settings/sync_adapters.jamf_extra_mobile_managed', 'type' => 'boolean'],
            'jamf_mobile_supervised' => ['label_key' => 'admin/settings/sync_adapters.jamf_extra_mobile_supervised', 'type' => 'boolean'],
        ];
    }

    public function supportsGroupScoping(): bool
    {
        return true;
    }

    public function vendorGroupLabel(): string
    {
        return trans('admin/settings/sync_adapters.vendor_group_jamf_site');
    }

    public function fetchGroups(): array
    {
        $client = new JamfClient(
            baseUrl: $this->url(),
            clientId: $this->credential('client_id'),
            clientSecret: $this->credential('client_secret'),
        );

        return array_map(
            fn (array $site) => [
                'id' => (string) ($site['id'] ?? ''),
                'label' => (string) ($site['name'] ?? $site['id'] ?? '?'),
            ],
            $client->sites(),
        );
    }

    public function pull(): iterable
    {
        $client = new JamfClient(
            baseUrl: $this->url(),
            clientId: $this->credential('client_id'),
            clientSecret: $this->credential('client_secret'),
        );

        foreach ($client->computers() as $computer) {
            yield $this->normalizeComputer($computer);
        }

        if ($this->shouldPullMobileDevices()) {
            foreach ($client->mobileDevices() as $device) {
                yield $this->normalizeMobileDevice($device);
            }
        }
    }

    /**
     * Opt-in toggle for syncing iOS / iPadOS / tvOS devices alongside
     * computers. Off by default so adding the mobile pull doesn't
     * surprise existing installs on their next scheduled run. Reads via
     * credential() because the base class's config storage treats
     * every schema entry (secret or not) through the same get/set
     * path.
     */
    private function shouldPullMobileDevices(): bool
    {
        try {
            return $this->credential('include_mobile_devices') === '1';
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Convert a Jamf computer payload into the normalized record shape.
     * Jamf's numeric `id` is stable per enrollment and is what we key
     * asset_external_sources on. Fields come from the GENERAL, HARDWARE, and
     * OPERATING_SYSTEM sections (the client only requests those).
     *
     * Computer sourceIds stay bare numeric to preserve back-compat with
     * every existing asset_external_sources.external_id row written by
     * this adapter before mobile support landed. The mobile path uses a
     * `mobile:` prefix instead to keep the two Jamf namespaces from
     * colliding (Jamf's computer id 42 and mobile id 42 are unrelated).
     *
     * @param  array<string, mixed>  $computer
     */
    private function normalizeComputer(array $computer): HostInventoryRecord
    {
        return new HostInventoryRecord(
            sourceKey: $this->name(),
            sourceId: (string) Arr::get($computer, 'id'),
            hostname: Arr::get($computer, 'general.name'),
            hardwareSerial: Arr::get($computer, 'hardware.serialNumber'),
            hardwareModel: Arr::get($computer, 'hardware.model'),
            manufacturer: Arr::get($computer, 'hardware.make'),
            primaryMac: Arr::get($computer, 'hardware.macAddress'),
            primaryIp: null,
            os: Arr::get($computer, 'operatingSystem.name'),
            osVersion: Arr::get($computer, 'operatingSystem.version'),
            lastSeen: $this->parseTimestamp(Arr::get($computer, 'general.lastContactTime')),
            assetTag: Arr::get($computer, 'general.assetTag'),
            assignedUserEmail: Arr::get($computer, 'userAndLocation.email'),
            assignedUserName: Arr::get($computer, 'userAndLocation.username'),
            vendorGroupId: Arr::has($computer, 'general.site.id') ? (string) Arr::get($computer, 'general.site.id') : null,
            extra: [
                'jamf_udid' => Arr::get($computer, 'udid'),
                'jamf_last_enrolled' => Arr::get($computer, 'general.lastEnrolledDate'),
                'jamf_model_identifier' => Arr::get($computer, 'hardware.modelIdentifier'),
            ],
        );
    }

    /**
     * Convert a /api/v2/mobile-devices list entry into the normalized
     * record shape. Mobile Jamf payloads are flatter than computer
     * ones: everything except assigned-user info lives at the top
     * level, so no section dot-paths. Manufacturer isn't carried
     * either (Jamf Pro's mobile fleet is Apple-only in practice), so
     * we hard-code 'Apple' to match what the computer path emits for
     * macs and let model-dedup land both on the same manufacturer.
     *
     * @param  array<string, mixed>  $device
     */
    private function normalizeMobileDevice(array $device): HostInventoryRecord
    {
        $sourceId = 'mobile:'.(string) Arr::get($device, 'id');

        return new HostInventoryRecord(
            sourceKey: $this->name(),
            sourceId: $sourceId,
            hostname: Arr::get($device, 'name'),
            hardwareSerial: Arr::get($device, 'serialNumber'),
            hardwareModel: Arr::get($device, 'model'),
            manufacturer: 'Apple',
            primaryMac: Arr::get($device, 'wifiMacAddress'),
            primaryIp: Arr::get($device, 'ipAddress'),
            os: Arr::get($device, 'osType'),
            osVersion: Arr::get($device, 'osVersion'),
            lastSeen: $this->parseTimestamp(Arr::get($device, 'lastInventoryUpdateTimestamp')),
            assetTag: Arr::get($device, 'assetTag'),
            assignedUserEmail: Arr::get($device, 'location.emailAddress'),
            assignedUserName: Arr::get($device, 'location.username'),
            vendorGroupId: Arr::has($device, 'site.id') ? (string) Arr::get($device, 'site.id') : null,
            extra: [
                'jamf_udid' => Arr::get($device, 'udid'),
                'jamf_model_identifier' => Arr::get($device, 'modelIdentifier'),
                'jamf_mobile_device_type' => Arr::get($device, 'deviceType'),
                'jamf_mobile_managed' => Arr::get($device, 'managed'),
                'jamf_mobile_supervised' => Arr::get($device, 'supervised'),
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

    /**
     * Jamf Pro writes are gated by the API Client's role privileges.
     * Both pull + push work with the same OAuth client when the role
     * grants the "Update Computers" privilege. No tier / license gate,
     * so canPush is always true for a configured instance.
     */
    public function canPush(): bool
    {
        return true;
    }

    /**
     * Jamf Pro's computer record has a freeform notes field at
     * general.notes on the inventory-detail JSON. Dotted path so
     * Arr::set can slot the composed value into the right nested
     * object.
     */
    public function notesFieldTarget(): ?string
    {
        return 'general.notes';
    }

    /**
     * Push Snipe-IT-authoritative fields to Jamf Pro via the newer
     * JSON detail endpoint. The payload uses Jamf's nested-object
     * shape (assetTag lives inside userAndLocation, not at the top
     * level), so sourceFieldToJamfPath() returns dotted paths that
     * get assembled via Arr::set before the PATCH.
     *
     * @param  array<int, string>  $changedFields
     */
    public function push(Asset $asset, array $changedFields = []): bool
    {
        return $this->pushViaSinglePayload($asset, $changedFields);
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<int, string>}
     */
    protected function buildPushPayload(Asset $asset): array
    {
        $payload = [];
        $touched = [];
        foreach ($this->pushDirectedFields() as $field) {
            $path = self::sourceFieldToJamfPath($field);
            if ($path === null) {
                continue;
            }

            $value = $this->assetValueForSourceField($asset, $field);
            if ($value === null) {
                continue;
            }

            Arr::set($payload, $path, $value);
            $touched[] = $path;
        }

        return [$payload, $touched];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    protected function dispatchPush(\App\Models\AssetExternalSource $externalSource, array $payload): void
    {
        // Mobile Jamf devices are pull-only in this adapter. The push
        // path only runs against /api/v1/computers-inventory-detail, so
        // short-circuit on the `mobile:` prefix the mobile normalizer
        // writes. Snipe-IT-authoritative fields on a mobile asset stay
        // local to Snipe-IT.
        if (str_starts_with($externalSource->external_id, 'mobile:')) {
            return;
        }

        $client = new JamfClient(
            baseUrl: $this->url(),
            clientId: $this->credential('client_id'),
            clientSecret: $this->credential('client_secret'),
        );
        $client->updateComputerDetail($externalSource->external_id, $payload);
    }

    /**
     * Map a source-field name to its dotted path in Jamf's
     * computers-inventory-detail JSON. Return null for fields Jamf
     * doesn't expose as writable (hostname is derived from the device
     * itself, not admin-settable).
     */
    private static function sourceFieldToJamfPath(string $field): ?string
    {
        return match ($field) {
            'asset_tag' => 'userAndLocation.assetTag',
            default => null,
        };
    }
}
