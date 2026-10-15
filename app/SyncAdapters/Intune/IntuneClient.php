<?php

namespace App\SyncAdapters\Intune;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Thin wrapper around Microsoft Graph for the Intune Managed Devices
 * endpoint. Handles OAuth 2.0 client-credentials token exchange and
 * Graph cursor pagination (via the `@odata.nextLink` response field).
 *
 * Auth model: Azure app registration with a tenant + client_id +
 * client_secret. Token exchange POSTs to the tenant-scoped OAuth 2.0
 * token endpoint with scope `https://graph.microsoft.com/.default`.
 * The returned bearer is valid for ~60 minutes. A single sync run
 * stays inside that window so we don't refresh mid-run.
 *
 * Sovereign clouds swap both hosts. The `graphBaseUrl` and
 * `loginBaseUrl` constructor args let the adapter derive the login
 * host from the Graph host so the settings-page URL field controls
 * both endpoints.
 */
class IntuneClient
{
    private ?string $token = null;

    public function __construct(
        private readonly string $graphBaseUrl,
        private readonly string $loginBaseUrl,
        private readonly string $tenantId,
        private readonly string $clientId,
        private readonly string $clientSecret,
    ) {}

    /**
     * Iterate every managed device visible to the app registration.
     * Uses Graph's `@odata.nextLink` for cursor pagination.
     *
     * When $scopeTagIds is non-empty, appends an OData `$filter` that
     * only returns devices whose `roleScopeTagIds` array intersects the
     * caller's list. Pushes the filter server-side so large tenants
     * with distributed-IT separation don't pay the pagination cost for
     * devices they don't even care about.
     * See https://learn.microsoft.com/en-us/intune/fundamentals/role-based-access-control/scope-tags.
     *
     * @param  array<int, string>|null  $scopeTagIds  Null = no filter. Empty array = no filter.
     * @return iterable<int, array<string, mixed>>
     */
    public function managedDevices(?array $scopeTagIds = null): iterable
    {
        $graphOrigin = $this->origin($this->graphBaseUrl);
        $url = rtrim($this->graphBaseUrl, '/').'/v1.0/deviceManagement/managedDevices';

        $query = [];
        if (is_array($scopeTagIds) && $scopeTagIds !== []) {
            // Graph expects: $filter=roleScopeTagIds/any(x: x eq 'id1' or x eq 'id2')
            // Quote each id and OR them inside a single any() clause.
            $clauses = array_map(fn (string $id) => "x eq '".addslashes($id)."'", $scopeTagIds);
            $query['$filter'] = 'roleScopeTagIds/any(x: '.implode(' or ', $clauses).')';
        }

        do {
            $response = $this->request()->get($url, $query)->throw()->json();

            foreach (($response['value'] ?? []) as $device) {
                yield $device;
            }

            // Query only on the first page. Graph's nextLink carries
            // the filter forward in its own cursor opaquely.
            $query = [];

            $url = $this->rebasedCursor($response['@odata.nextLink'] ?? null, $graphOrigin);
        } while ($url !== null);
    }

    /**
     * Fetch every role scope tag defined in the tenant. Used by the
     * adapter to resolve admin-entered scope tag names into the IDs
     * the managedDevices filter needs, and (eventually) to populate
     * a settings-page multiselect of available tags.
     *
     * Returns an array of ['id' => '...', 'displayName' => '...'].
     *
     * @return array<int, array{id: string, displayName: string}>
     */
    public function roleScopeTags(): array
    {
        $graphOrigin = $this->origin($this->graphBaseUrl);
        $url = rtrim($this->graphBaseUrl, '/').'/v1.0/deviceManagement/roleScopeTags';

        $out = [];
        do {
            $response = $this->request()->get($url)->throw()->json();
            foreach (($response['value'] ?? []) as $tag) {
                $id = $tag['id'] ?? null;
                $name = $tag['displayName'] ?? null;
                if (is_scalar($id) && is_string($name)) {
                    $out[] = ['id' => (string) $id, 'displayName' => $name];
                }
            }
            $url = $this->rebasedCursor($response['@odata.nextLink'] ?? null, $graphOrigin);
        } while ($url !== null);

        return $out;
    }

    /**
     * Strip a server-supplied absolute URL down to path+query and
     * re-base it onto the configured graph origin, so a hostile
     * upstream can't redirect the cursor (and its bearer) to an
     * attacker-chosen target. Returns null when the cursor is
     * absent or unparseable, or when the configured graph URL
     * itself has no usable origin.
     */
    private function rebasedCursor(?string $url, ?string $origin): ?string
    {
        if ($url === null || $url === '' || $origin === null) {
            return null;
        }

        $parsed = parse_url($url);
        if (! is_array($parsed)) {
            return null;
        }

        // Reject path-relative cursors with no leading slash
        // ("page2" rather than "/page2"). Rebasing those produced an
        // unparseable "https://hostpage2" that aborted the sync on the
        // next iteration. Fails safe but we'd rather be explicit
        // (reported post-fix by Zer0Gate as a robustness note).
        // Only path+query is kept from the supplied cursor on purpose,
        // so any path prefix on the configured base URL (not Graph's
        // case, but legal in general) is dropped. Absolute cursors are
        // the standard shape here and this matches that.
        $path = $parsed['path'] ?? '/';
        if (! str_starts_with($path, '/')) {
            return null;
        }

        return $origin.$path.(isset($parsed['query']) ? '?'.$parsed['query'] : '');
    }

    /**
     * Scheme+host(+port) of the given absolute URL, or null when it is
     * not a parseable absolute URL.
     */
    private function origin(string $url): ?string
    {
        $parts = parse_url($url);
        if (! is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            return null;
        }

        return $parts['scheme'].'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
    }

    /**
     * Per-device GET against Graph's managedDevice endpoint with a
     * caller-chosen $select set. Used for properties the LIST
     * endpoint always returns null for (ethernetMacAddress,
     * physicalMemoryInBytes, etc. - Microsoft docs explicitly flag
     * these as "requires per-device GET"). Returns the attributes
     * array on success. Fails soft to null on 4xx/5xx so one bad
     * device doesn't abort the enclosing enrichment pass.
     *
     * @param  array<int, string>  $select
     * @return array<string, mixed>|null
     */
    public function managedDeviceDetail(string $deviceId, array $select): ?array
    {
        $url = rtrim($this->graphBaseUrl, '/').'/v1.0/deviceManagement/managedDevices/'.rawurlencode($deviceId);

        try {
            return $this->request()
                ->get($url, ['$select' => implode(',', $select)])
                ->throw()
                ->json();
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Fetch (or reuse) a bearer token via OAuth 2.0 client-credentials
     * against the tenant-scoped token endpoint. Token is cached on
     * this instance for the life of the sync run.
     */
    private function bearer(): string
    {
        if ($this->token !== null) {
            return $this->token;
        }

        $tokenUrl = rtrim($this->loginBaseUrl, '/').'/'.$this->tenantId.'/oauth2/v2.0/token';

        $response = Http::asForm()
            ->withOptions(['allow_redirects' => false])
            ->timeout(30)
            ->post($tokenUrl, [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => rtrim($this->graphBaseUrl, '/').'/.default',
            ])
            ->throw()
            ->json();

        return $this->token = (string) ($response['access_token'] ?? '');
    }

    /**
     * Push writable metadata to a managed device via Graph beta's
     * per-device endpoint. The v1.0 endpoint doesn't expose notes
     * as writable. Beta does (matches what community integrations
     * like Brady Widener's Snipe-IT-Azure-Integration use). Fields
     * the caller doesn't include stay untouched.
     *
     * @param  array<string, scalar|null>  $payload
     */
    public function updateManagedDevice(string $deviceId, array $payload): void
    {
        $url = rtrim($this->graphBaseUrl, '/').'/beta/deviceManagement/managedDevices/'.$deviceId;

        Http::withToken($this->bearer())
            ->withOptions(['allow_redirects' => false])
            ->asJson()
            ->acceptJson()
            ->timeout(30)
            ->patch($url, $payload)
            ->throw();
    }

    private function request(): PendingRequest
    {
        return Http::withToken($this->bearer())
            ->withOptions(['allow_redirects' => false])
            ->acceptJson()
            ->timeout(30);
    }
}
