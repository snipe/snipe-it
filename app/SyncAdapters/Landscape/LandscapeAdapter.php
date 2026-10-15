<?php

namespace App\SyncAdapters\Landscape;

use App\SyncAdapters\HostInventoryRecord;
use App\SyncAdapters\SyncAdapter;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Landscape adapter. Pulls computer inventory from a Canonical
 * Landscape instance (SaaS or self-hosted) and normalizes it into
 * HostInventoryRecord objects.
 *
 * Authentication is a bearer JWT the admin obtains once by POSTing
 * credentials to /api/v2/login on their Landscape instance. Landscape
 * has no UI for issuing static API tokens, so admins paste the JWT
 * returned by that call. The token's expiry_minutes at login time
 * controls how long the paste stays valid.
 *
 * Push (Snipe-IT -> Landscape) is not wired. Landscape's v2 API
 * only exposes specialized action endpoints on a computer (restart,
 * archive, sanitize, delete). It has no PATCH endpoint for the
 * writable metadata fields the admin UI can edit (comment, title,
 * tags, access_group). The `comment` field would be an obvious
 * composed-notes target if Canonical ever publishes a generic
 * update endpoint.
 */
class LandscapeAdapter extends SyncAdapter
{
    public static function typeLabel(): string
    {
        return 'Landscape';
    }

    public static function typeSlug(): string
    {
        return 'landscape';
    }

    public static function docsUrl(): ?string
    {
        return 'https://ubuntu.com/landscape/docs/reference/api/';
    }

    public function settingsSchema(): array
    {
        return [
            [
                'key' => 'token',
                'label' => trans('admin/settings/sync_adapters.label_bearer_token'),
                'secret' => true,
                'help' => trans('admin/settings/sync_adapters.landscape_token_help'),
            ],
        ];
    }

    public function extraFields(): array
    {
        return [
            'landscape_tags' => ['label_key' => 'admin/settings/sync_adapters.extra_tags'],
            'landscape_access_group' => ['label_key' => 'admin/settings/sync_adapters.extra_group'],
            'landscape_distribution' => ['label_key' => 'admin/settings/sync_adapters.extra_distribution'],
            'landscape_reboot_required' => [
                'label_key' => 'admin/settings/sync_adapters.extra_reboot_required',
                'type' => 'boolean',
            ],
            'landscape_ubuntu_pro' => ['label_key' => 'admin/settings/sync_adapters.extra_ubuntu_pro'],
        ];
    }

    public function canPush(): bool
    {
        return false;
    }

    public function supportsGroupScoping(): bool
    {
        // Landscape has access groups but the v2 API does not
        // publish a list-access-groups endpoint we can enumerate
        // from. Leaving group scoping off until we either find that
        // endpoint or add a manual "type in group names" flow.
        return false;
    }

    public function pull(): iterable
    {
        $client = new LandscapeClient(
            baseUrl: $this->url(),
            token: $this->credential('token'),
        );

        foreach ($client->computers() as $computer) {
            yield $this->normalize($computer);
        }
    }

    /**
     * Convert a Landscape computer payload into the normalized record
     * shape. Landscape's numeric `id` is the stable per-computer key
     * for asset_external_sources.
     *
     * Assigned-user extraction is null in v1: Landscape does not
     * natively track a primary user on the computer record. Installs
     * that populate a custom field via a run-once script can surface
     * that through the vendor-custom-fields extras path instead.
     *
     * @param  array<string, mixed>  $computer
     */
    private function normalize(array $computer): HostInventoryRecord
    {
        $system = $this->firstHardwareRecord($computer, 'system');
        $network = $this->firstHardwareRecord($computer, 'network');

        return new HostInventoryRecord(
            sourceKey: $this->name(),
            sourceId: (string) Arr::get($computer, 'id'),
            hostname: Arr::get($computer, 'hostname') ?? Arr::get($computer, 'title'),
            hardwareSerial: Arr::get($system, 'serial') ?? Arr::get($system, 'serial_number'),
            hardwareModel: Arr::get($system, 'product') ?? Arr::get($system, 'product_name'),
            manufacturer: Arr::get($system, 'vendor') ?? Arr::get($system, 'manufacturer'),
            primaryMac: Arr::get($network, 'mac') ?? Arr::get($network, 'mac_address'),
            primaryIp: Arr::get($network, 'ip') ?? Arr::get($network, 'ip_address'),
            os: 'Ubuntu',
            osVersion: Arr::get($computer, 'distribution'),
            lastSeen: $this->parseTimestamp(Arr::get($computer, 'last_ping_time')),
            assignedUserEmail: null,
            assignedUserName: null,
            vendorGroupId: null,
            extra: [
                'landscape_tags' => Arr::get($computer, 'tags'),
                'landscape_access_group' => Arr::get($computer, 'access_group'),
                'landscape_distribution' => Arr::get($computer, 'distribution'),
                'landscape_reboot_required' => (bool) Arr::get($computer, 'reboot_required_flag'),
                'landscape_ubuntu_pro' => Arr::get($computer, 'ubuntu_pro_info'),
            ],
        );
    }

    /**
     * Landscape's grouped_hardware entries may come back as either a
     * flat object (single system, single primary NIC) or a list of
     * objects, depending on the install and category. Return the
     * first record in either shape.
     *
     * @param  array<string, mixed>  $computer
     * @return array<string, mixed>|null
     */
    private function firstHardwareRecord(array $computer, string $category): ?array
    {
        $entry = Arr::get($computer, 'grouped_hardware.' . $category);
        if (!is_array($entry) || $entry === []) {
            return null;
        }

        if (array_is_list($entry)) {
            $first = $entry[0] ?? null;

            return is_array($first) ? $first : null;
        }

        return $entry;
    }

    private function parseTimestamp(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value);
    }
}
