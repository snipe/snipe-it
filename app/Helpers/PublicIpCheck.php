<?php

namespace App\Helpers;

/**
 * Shared SSRF-guard check for whether a resolved IP address refers to a
 * publicly-routable target. Callers that accept a URL or hostname from
 * an admin (webhook endpoints, LDAP hosts, etc.) validate the resolved
 * address through this helper so the "block internal targets" behavior
 * lives in one place.
 *
 * PHP's built-in `FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE`
 * combo covers most of what we need, but has two known gaps that this
 * class handles explicitly:
 *
 *   1. The unspecified address (`::` and `0.0.0.0`) is not classified as
 *      reserved by filter_var across all PHP versions.
 *
 *   2. IPv6 transition prefixes (NAT64, 6to4, Teredo) embed an IPv4
 *      target inside a globally-routable IPv6 wrapper. filter_var only
 *      inspects the wrapper prefix, so an attacker who supplies an IPv6
 *      literal like `64:ff9b::169.254.169.254` slips past the guard on
 *      any host that has NAT64 (or 6to4 or Teredo) tunneling enabled.
 *      See GHSA-5j6m-rr83-rpj7.
 *
 * The transition-address extraction is transport-agnostic on purpose.
 * We don't check whether the current host actually has the tunnel up.
 * Defense in depth means blocking these prefixes regardless of the
 * environment they'd be reachable in.
 */
class PublicIpCheck
{
    /**
     * True when the address resolves to a publicly-routable target. Returns
     * false for loopback, RFC-1918 private, link-local, unique-local,
     * multicast, broadcast, unspecified, and IPv6 transition prefixes whose
     * embedded IPv4 would itself be non-public.
     */
    public static function isPublic(string $ip): bool
    {
        // Unwrap IPv4-mapped IPv6 (::ffff:x.x.x.x) so the IPv4
        // NO_PRIV_RANGE / NO_RES_RANGE checks apply to the payload.
        if (stripos($ip, '::ffff:') === 0) {
            $ipv4 = substr($ip, 7);
            if (filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = $ipv4;
            }
        }

        // Explicit unspecified-address block. filter_var's classification
        // of `::` and `0.0.0.0` isn't consistent across PHP versions.
        if ($ip === '::' || $ip === '0.0.0.0') {
            return false;
        }

        // IPv6 transition prefixes: extract the embedded IPv4 and recurse.
        // A non-public embedded IPv4 fails the check regardless of the
        // wrapper being technically routable IPv6 space.
        $embedded = self::extractTransitionIpv4($ip);
        if ($embedded !== null) {
            return self::isPublic($embedded);
        }

        return (bool) filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * If the address is an IPv6 transition prefix (NAT64, 6to4, or Teredo)
     * that carries an IPv4 payload, return that payload as a dotted-quad
     * string. Otherwise null.
     */
    private static function extractTransitionIpv4(string $ip): ?string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            return null;
        }

        $packed = @inet_pton($ip);
        if ($packed === false || strlen($packed) !== 16) {
            return null;
        }

        $words = array_values(unpack('n8', $packed));

        // NAT64 well-known prefix (RFC 6052): 64:ff9b::/96.
        // Last 32 bits hold the embedded IPv4.
        if ($words[0] === 0x0064 && $words[1] === 0xFF9B
            && $words[2] === 0 && $words[3] === 0
            && $words[4] === 0 && $words[5] === 0) {
            return long2ip(($words[6] << 16) | $words[7]);
        }

        // 6to4 (RFC 3056): 2002::/16.
        // Bits 16-47 (the next two 16-bit words) hold the embedded IPv4.
        if ($words[0] === 0x2002) {
            return long2ip(($words[1] << 16) | $words[2]);
        }

        // Teredo (RFC 4380): 2001:0000::/32.
        // Client IPv4 lives in bits 96-127, XOR'd with 0xFFFFFFFF.
        if ($words[0] === 0x2001 && $words[1] === 0x0000) {
            return long2ip((($words[6] ^ 0xFFFF) << 16) | ($words[7] ^ 0xFFFF));
        }

        return null;
    }
}
