<?php

namespace App\Rules;

use App\Helpers\PublicIpCheck;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Reject URLs that point at loopback, link-local, private-network, or
 * otherwise-non-public addresses so a super-admin can't be tricked (or
 * accidentally) turn the outbound webhook path into an SSRF primitive
 * against 169.254.169.254, 127.0.0.1, RFC-1918, [::1], and friends.
 *
 * The rule is intentionally scheme-strict (http/https only): the previous
 * webhook validator accepted ftp:// and irc://, which have no legitimate
 * webhook use and expand the attack surface.
 *
 * Between this check and the outbound request there is still a DNS
 * rebinding window; that is acceptable given the super-admin threat
 * model. If we ever need to close it, pin the resolved IP into Guzzle
 * via CURLOPT_RESOLVE on the actual request.
 */
class ExternalUrl implements ValidationRule
{
    /**
     * Each caller specifies which config flag disables the IP-range
     * check for its context. Webhooks and sync adapters have separate
     * SSRF threat models (event-driven push vs admin-triggered pull),
     * so operators can opt into internal targets for one without
     * loosening the other.
     */
    public function __construct(private string $allowInternalConfigKey) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            $fail(trans('validation.external_url'));

            return;
        }

        $parts = parse_url($value);

        if ($parts === false || empty($parts['scheme']) || empty($parts['host'])) {
            $fail(trans('validation.external_url'));

            return;
        }

        if (! in_array(strtolower($parts['scheme']), ['http', 'https'], true)) {
            $fail(trans('validation.external_url'));

            return;
        }

        // Operators who legitimately need to point at an on-LAN target
        // flip the context-specific env in .env. Scheme restrictions
        // above still apply, only the IP-range check is skipped.
        if (config($this->allowInternalConfigKey)) {
            return;
        }

        $host = $parts['host'];

        if (str_starts_with($host, '[') && str_ends_with($host, ']')) {
            $host = substr($host, 1, -1);
        }

        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : $this->resolveHost($host);

        if ($ips === []) {
            $fail(trans('validation.external_url'));

            return;
        }

        foreach ($ips as $ip) {
            if (! PublicIpCheck::isPublic($ip)) {
                $fail(trans('validation.external_url'));

                return;
            }
        }
    }

    private function resolveHost(string $host): array
    {
        $ips = [];

        // gethostbynamel goes through nsswitch (/etc/hosts, mDNS, DNS) —
        // the same lookup path the outbound HTTP client will use. dns_get_record
        // alone is a pure DNS query that ignores /etc/hosts and may apply
        // search suffixes, which would let "localhost" resolve to a public IP
        // under "localhost.<search-domain>" and slip past the check.
        $v4 = @gethostbynamel($host);
        if (is_array($v4)) {
            foreach ($v4 as $ip) {
                $ips[] = $ip;
            }
        }

        // There is no stdlib nsswitch equivalent for IPv6, so this leg is
        // best-effort DNS. The IPv4 leg above already catches the common
        // "localhost" / hosts-file cases, so a missed AAAA record here
        // can't silently pass a name we would have otherwise rejected.
        $v6 = @dns_get_record($host, DNS_AAAA);
        if (is_array($v6)) {
            foreach ($v6 as $r) {
                if (! empty($r['ipv6'])) {
                    $ips[] = $r['ipv6'];
                }
            }
        }

        return array_values(array_unique($ips));
    }
}
